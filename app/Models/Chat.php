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

    public function users() {
        return $this->belongsToMany(User::class);
    }

}
