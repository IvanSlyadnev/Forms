<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Tables\ChatTable;
use App\Tables\UserTable;
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
            'users' => User::whereDoesntHave('chats')->get(),
            'table' => (new UserTable($chat))->setup()
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
