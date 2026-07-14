<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'created_by',
        'assigned_to',
        'deadline',
        'visible_from_boss',
    ];

    protected function casts(): array
    {
        return [
            'project_id' => 'integer',
            'created_by' => 'integer',
            'assigned_to' => 'integer',
            'deadline' => 'date',
            'visible_from_boss' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class);
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(TicketSubtask::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(TicketFile::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function getProgressAttribute(): float
    {
        $total = $this->subtasks()->count();
        if ($total === 0) {
            return 0;
        }
        $completed = $this->subtasks()->where('completed', true)->count();

        return ($completed / $total) * 100;
    }

    public function isOverdue(): bool
    {
        return $this->deadline && now()->isAfter($this->deadline) && $this->status !== 'done';
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['backlog', 'en_progreso', 'en_revision']);
    }

    /**
     * A ticket is visible to the jefe only when it is marked visible and
     * lives in a project that is not hidden from him.
     */
    public function scopeVisibleToBoss($query)
    {
        return $query->where('visible_from_boss', true)
            ->whereHas('project', fn ($q) => $q->where('hidden_from_boss', false));
    }

    public function isVisibleToBoss(): bool
    {
        return $this->visible_from_boss && $this->project && ! $this->project->hidden_from_boss;
    }
}
