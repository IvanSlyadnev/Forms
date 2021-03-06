<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'telegram_chat_id',
        'current_message_id',
        'email'
    ];

    public function messages() {
        return $this->belongsToMany(Message::class)->withPivot('answer');
    }

    public function currentMessage() {
        return $this->belongsTo(Message::class, 'current_message_id');
    }

    public function currentLead () {
        return $this->belongsTo(Lead::class, 'current_lead_id');
    }

}
