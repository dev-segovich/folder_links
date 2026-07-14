<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $table = 'audit_log';

    public $timestamps = false;

    protected $fillable = [
        'ticket_id',
        'action',
        'performed_by',
        'details',
    ];

    protected function casts(): array
    {
        return [
            'ticket_id' => 'integer',
            'performed_by' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    /**
     * With $timestamps = false, nothing app-side filled `created_at`, so MySQL was
     * defaulting it to CURRENT_TIMESTAMP — the database server's clock, which drifts
     * from the app's timezone. Stamp it here so the audit trail shares one clock.
     */
    protected static function booted(): void
    {
        static::creating(function (AuditLog $log) {
            $log->created_at ??= now();
        });
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
