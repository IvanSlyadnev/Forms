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
        'invite_link',
        'name',
        'is_public'
    ];

    public function users() {
        return $this->morphedByMany(User::class, 'chatable');
    }

    public function groups() {
        return $this->morphedByMany(Group::class, 'chatable');
    }

    public function getAllUsersAttribute () {
        return User::whereHas('groups', function ($query) {
           $query->whereIn('groups.id', $this->groups()->pluck('groups.id'));
        })->orWhereHas('chats', function ($query) {
            $query->where('chats.id', $this->id);
        })->get();
    }

    public function isUserInChat(User $user) {
        try {
            return !in_array(Telegram::getChatMember([
                'chat_id' => $this->telegram_chat_id,
                'user_id' => $user->telegram_chat_id
            ])->status, ['left', 'kicked']);
        } catch (\Throwable $e) {
            return false;
        }
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
