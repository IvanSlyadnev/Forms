<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Group;
use App\Models\User;
use App\Tables\ChatGroupTable;
use App\Tables\ChatTable;
use App\Tables\UserTable;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat/index', [
            'table' => (new ChatTable())->setup()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        return view('chat/show', [
            'chat' => $chat,
            'table' => (new UserTable($chat))->setup(),
            'users' => User::whereDoesntHave('chats',
                function ($query) use($chat) {
                    $query->where('chats.id', $chat->id);
                })->get(),
        ]);
    }

}
