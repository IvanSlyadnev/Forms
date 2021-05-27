<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    public function add(User $user, Group  $group) {
        $group->users()->attach($user);
        return redirect()->route('groups.show', $group->id)->with('success', 'Пользователь ' .$user->name. ' успешно добавлен в группу');
    }

    public function destroy (Group $group, User $user) {
        $group->users()->detach($user);
        return redirect()->route('groups.show', $group->id)->with('success', 'Пользователь '.$user->name.' успешно удален из группы');
    }
}
