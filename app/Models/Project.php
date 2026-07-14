<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'env',
        'image',
        'status',
        'prod_url',
        'local_url',
        'hidden_from_boss',
    ];

    protected function casts(): array
    {
        return [
            'hidden_from_boss' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function links(): HasMany
    {
        return $this->hasMany(ProjectLink::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function scopeVisibleToBoss($query)
    {
        return $query->where('hidden_from_boss', false);
    }

    public function isVisibleToBoss(): bool
    {
        return ! $this->hidden_from_boss;
    }

    public function activeTicketsCount(): int
    {
        return $this->tickets()
            ->when(! can_see_hidden(), fn ($q) => $q->visibleToBoss())
            ->whereIn('status', ['backlog', 'en_progreso', 'en_revision'])
            ->count();
    }

    public function completedTicketsCount(): int
    {
        return $this->tickets()
            ->when(! can_see_hidden(), fn ($q) => $q->visibleToBoss())
            ->where('status', 'done')
            ->count();
    }
}
