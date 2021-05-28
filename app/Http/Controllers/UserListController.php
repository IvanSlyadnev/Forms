<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Tables\UsersListTable;
use Illuminate\Http\Request;
use App\Observers\UserObserver;
use Telegram\Bot\Laravel\Facades\Telegram;

class UserListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user/index', [
            'table' => (new UsersListTable())->setup()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $chats = Chat::all();

        /*$chats->each(function ($chat) use ($user) {
            {
                try {
                    $chat->users()->detach($user);
                } catch (\Throwable $e) {
                    logger()->info($e->getMessage());
                }
                Telegram::kickChatMember([
                    'chat_id' => $chat->telegram_chat_id,
                    'user_id' => $user->telegram_chat_id
                ]);
            }
        });
        $user->delete();*/

        //
        return redirect()->route('users.index');
    }
}
