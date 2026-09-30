<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrSystemOneDecision extends Model
{
    protected $fillable = [
        'support_ticket_id',
        'provider',
        'mode',
        'advisory_only',
        'answers',
        'routing',
        'usage',
        'latency_ms',
    ];

    protected $casts = [
        'advisory_only' => 'boolean',
        'answers' => 'array',
        'routing' => 'array',
        'usage' => 'array',
        'latency_ms' => 'integer',
    ];

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }
}
