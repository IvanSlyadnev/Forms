<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Telegram\Bot\Laravel\Facades\Telegram;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'telegram_chat_id',
        'current_message_id',
        'email',
        'invite_link'
    ];

    public function users() {
        return $this->morphedByMany(User::class, 'chatable');
    }



    public function getInviteLinkAttribute() {
        if ($this->attributes['invite_link']) {
            return $this->attributes['invite_link'];
        } else {
            $link = Telegram::exportChatInviteLink([
                'chat_id' => $this->telegram_chat_id
            ]);
            $this->update(['invite_link' => $link]);
            return $link;
        }

    }
}
