<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketSubtask extends Model
{
    protected $fillable = [
        'ticket_id',
        'title',
        'completed',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'ticket_id' => 'integer',
            'completed' => 'boolean',
            'sort_order' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
