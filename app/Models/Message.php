<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function chats() {
        return $this->belongsToMany(Chat::class);
    }

    public function currentMessage() {
        return $this->belongsTo(Chat::class, 'current_message_id');
    }
}
