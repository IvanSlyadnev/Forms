<?php

namespace App\Observers;

use App\Models\Chat;
use App\Models\User;
use Telegram\Bot\Laravel\Facades\Telegram;

class UserObserver
{
    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $chats = Chat::all();

        $chats->each(function ($chat) use ($user) {
            {
                try {
                    $chat->users()->detach($user);
                    Telegram::kickChatMember([
                        'chat_id' => $chat->telegram_chat_id,
                        'user_id' => $user->telegram_chat_id
                    ]);
                } catch (\Throwable $e) {
                    logger()->info($e->getMessage());
                }
            }
        });
        return redirect()->route('users.index');
    }

}
