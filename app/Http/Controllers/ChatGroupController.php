<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Group;
use App\Tables\ChatGroupTable;
use Illuminate\Http\Request;

class ChatGroupController extends Controller
{

    public function showInGroup(Group $group) {
        return view('chat/index', [
            'table' => (new ChatGroupTable($group))->setup(),
            'group' => $group,
            'chats' => Chat::whereDoesntHave('groups', function ($query) use ($group) {
                $query->where('groups.id', $group->id);
            })->get()
        ]);
    }

    public function addInGroup(Chat $chat, Group $group) {
        $group->chats()->attach($chat);
        return redirect()->route('chats.groups.show', $group)->with('success', 'Чат успешно добавлен в группу');
    }

    public function destroy(Group $group, Chat $chat)
    {
        $group->chats()->detach($chat);
        return redirect()->route('chats.groups.show', $group)->with('success', 'Чат успешно удален из группы');
    }
}
