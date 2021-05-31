<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function add(User $user, Chat $chat) {

        if (!$chat->users->contains($user)) $chat->users()->attach($user);
        try {
            Telegram::unbanChatMember([
                'chat_id' => $chat->telegram_chat_id,
                'user_id' => $user->telegram_chat_id
            ]);

            Telegram::sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text' => $chat->invite_link
            ]);
        } catch (\Throwable $e) {

        }

        return redirect()->route('chats.show', $chat->id);
    }

    public function destroy(Chat $chat, User $user) {
        $chat->users()->detach($user);
        try {
            Telegram::kickChatMember([
                'chat_id' => $chat->telegram_chat_id,
                'user_id' => $user->telegram_chat_id
            ]);
        } catch (\Throwable $e) {

        }
        return redirect()->route('chats.show', $chat->id);
    }
}