<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $fillable = ['title', 'message', 'recipient_count', 'sent_at'];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function scopeSent($query)
    {
        return $query->whereNotNull('sent_at');
    }

    public function scopePending($query)
    {
        return $query->whereNull('sent_at');
    }

    public function isSent(): bool
    {
        return $this->sent_at !== null;
    }
}
