<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TicketActivityTimestampsTest extends TestCase
{
    protected function user(string $role = 'dev'): User
    {
        static $n = 0;
        $n++;

        return User::create([
            'name' => "Usuario {$n}",
            'username' => "user{$n}",
            'email' => "user{$n}@kernel.local",
            'password' => 'secret',
            'role' => $role,
        ]);
    }

    protected function ticket(array $attributes = []): Ticket
    {
        $project = Project::create(['name' => 'Kernel', 'slug' => 'kernel-'.uniqid()]);

        return Ticket::create(array_merge([
            'project_id' => $project->id,
            'title' => 'Ticket de prueba',
            'status' => 'backlog',
            'created_by' => $this->user()->id,
        ], $attributes));
    }

    public function test_completing_a_ticket_stamps_completed_at(): void
    {
        Carbon::setTestNow('2026-07-01 10:00:00');
        $ticket = $this->ticket();
        $this->assertNull($ticket->completed_at);

        Carbon::setTestNow('2026-07-05 09:30:00');
        $ticket->update(['status' => 'done']);

        $this->assertSame('2026-07-05 09:30:00', $ticket->fresh()->completed_at->toDateTimeString());
    }

    public function test_completed_at_does_not_move_when_a_done_ticket_is_edited(): void
    {
        Carbon::setTestNow('2026-07-05 09:30:00');
        $ticket = $this->ticket(['status' => 'done']);

        Carbon::setTestNow('2026-07-20 18:00:00');
        $ticket->update(['title' => 'Título corregido']);

        $this->assertSame('2026-07-05 09:30:00', $ticket->fresh()->completed_at->toDateTimeString());
    }

    public function test_reopening_a_ticket_clears_completed_at(): void
    {
        $ticket = $this->ticket(['status' => 'done']);

        $ticket->update(['status' => 'en_progreso']);

        $this->assertNull($ticket->fresh()->completed_at);
    }

    public function test_assigning_a_ticket_stamps_assigned_at(): void
    {
        Carbon::setTestNow('2026-07-01 10:00:00');
        $ticket = $this->ticket();
        $this->assertNull($ticket->assigned_at);

        Carbon::setTestNow('2026-07-08 12:00:00');
        $ticket->update(['assigned_to' => $this->user()->id]);

        $this->assertSame('2026-07-08 12:00:00', $ticket->fresh()->assigned_at->toDateTimeString());
    }

    public function test_unassigning_a_ticket_clears_assigned_at(): void
    {
        $ticket = $this->ticket(['assigned_to' => $this->user()->id]);
        $this->assertNotNull($ticket->assigned_at);

        $ticket->update(['assigned_to' => null]);

        $this->assertNull($ticket->fresh()->assigned_at);
    }

    public function test_activity_timestamps_are_not_mass_assignable(): void
    {
        $ticket = $this->ticket([
            'completed_at' => '2020-01-01 00:00:00',
            'assigned_at' => '2020-01-01 00:00:00',
        ]);

        $this->assertNull($ticket->fresh()->completed_at);
        $this->assertNull($ticket->fresh()->assigned_at);
    }
}
