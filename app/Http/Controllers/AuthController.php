<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\FormOwnerNotification;
use App\Notifications\RegisterNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class AuthController extends Controller
{
    public function telegramLogin(Request $request) {
        $user = Socialite::driver('telegram')->user();

        $password = Str::random(8);

        $user = User::updateOrCreate(
            ['telegram_chat_id'=>$user->getId()],
            ['name' => $user->getName(), 'password' => Hash::make($password)]
        );

        if ($user->wasRecentlyCreated) {
            $user->notify(new RegisterNotification($password));
        }

        Auth::login($user);
        return redirect()->route('home');
    }

}
