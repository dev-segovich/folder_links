<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->timestamp('assigned_at')->nullable()->after('assigned_to');
            $table->timestamp('completed_at')->nullable()->after('deadline');
        });

        // Backfill with the best evidence available for tickets that predate the columns.
        // Assignments were never audited, so creation time is the only signal we have.
        DB::table('tickets')
            ->whereNotNull('assigned_to')
            ->update(['assigned_at' => DB::raw('created_at')]);

        DB::table('tickets')
            ->where('status', 'done')
            ->update(['completed_at' => DB::raw('updated_at')]);

        // Existing audit rows were stamped by the database (AuditLog has no app-side
        // timestamps, so MySQL filled created_at with CURRENT_TIMESTAMP), which means
        // they carry the DB server's clock instead of the app's. Realign them before
        // using them as a source of truth. No-op when both clocks already agree.
        $this->realignAuditClock();

        // Completions were audited, so prefer the audit trail over `updated_at`
        // (which moves every time the ticket is touched after being closed).
        // Ordered ascending so the most recent completion wins.
        $completions = DB::table('audit_log')
            ->where('action', 'status_changed')
            ->where('details', 'like', "%a 'done'%")
            ->orderBy('created_at')
            ->get(['ticket_id', 'created_at']);

        foreach ($completions as $completion) {
            DB::table('tickets')
                ->where('id', $completion->ticket_id)
                ->where('status', 'done')
                ->update(['completed_at' => $completion->created_at]);
        }
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['assigned_at', 'completed_at']);
        });
    }

    /**
     * Shift audit rows written on the DB server's clock onto the app's clock.
     *
     * One-time and forward-only: from here on AuditLog stamps `created_at` itself,
     * so re-running this migration after a rollback would shift correct rows again.
     */
    protected function realignAuditClock(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            return;
        }

        $dbNow = Carbon::parse(DB::selectOne('select NOW() as now')->now);
        $offset = (int) round($dbNow->diffInSeconds(now(), false) / 60) * 60;

        if ($offset === 0) {
            return;
        }

        DB::table('audit_log')->update([
            'created_at' => DB::raw("DATE_ADD(created_at, INTERVAL {$offset} SECOND)"),
        ]);
    }
};
