<?php

namespace App\Models;

use App\Traits\HasValuesArray;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Message extends Model
{
    use HasFactory, HasValuesArray;

    protected $fillable = [
        'type',
        'values',
        'text'
    ];

    public function chats() {
        return $this->belongsToMany(Chat::class)->withPivot('answer');
    }

    public function currentChats() {
        return $this->hasMany(Chat::class, 'current_message_id');
    }

    
}
