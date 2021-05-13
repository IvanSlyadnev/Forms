<?php


use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::resource('forms', FormController::class);
    Route::resource('forms.questions', QuestionController::class)->shallow();
});

Route::get('/f', [FormController::class, 'index'])->name('f');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
