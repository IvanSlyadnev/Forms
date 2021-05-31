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
        $user->delete();
    }
}
