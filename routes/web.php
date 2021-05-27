<?php


use App\Http\Controllers\ChatController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\QuestionAnswerController;
use App\Http\Controllers\QuestionController;
use \App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::resource('chats', ChatController::class)->only('index', 'show');
    Route::resource('chats.users', UserController::class)->only('index', 'destroy');
    Route::resource('groups', GroupController::class);
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('forms/question/answer/{form}', [QuestionAnswerController::class, 'fillForm'])->name('forms.question.answer');

Route::get('forms/fill/{form}', [FormController::class, 'fill'])->name('forms.fill');

Route::post('user/add/{user}/{chat}', [UserController::class, 'add'])->name('user.add');

Route::get('/auth/redirect', function () {
    return Socialite::driver('telegram')->redirect();
});

Route::get('/auth/callback', [AuthController::class, 'telegramLogin']);
