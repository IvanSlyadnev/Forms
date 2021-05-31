<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    public function chats() {
        return $this->morphToMany(Chat::class, 'chatable');
    }

    public function groups() {
        return $this->belongsToMany(Group::class);
    }

    public function getAllChatsAttribute() {
        return Chat::whereHas('groups', function ($query) {
            $query->whereIn('groups.id', $this->groups()->pluck('id'));
        })->orWhereHas('users', function ($query) {
            $query->where('users.id', $this->id);
        })->orWhere('chats.is_public', 1)->get()->map(function ($chat) {
            return [
                'chat' => $chat,
                'consists' => $chat->isUserInChat($this)
            ];
        });
    }

    public function getChatsWhereNotConsistsAttribute () {

        return $this->all_chats->filter(function ($value) {
            try {
                return in_array(Telegram::getChatMember([
                        'chat_id' => $value->telegram_chat_id,
                        'user_id' => $this->telegram_chat_id
                    ])->status, ['left', 'kicked']);
            } catch (\Throwable $e) {
                return false;
            }
        });

    }




    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telegram_chat_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForTelegram()
    {
        return $this->telegram_chat_id;
    }

}
