<?php


use App\Http\Controllers\FormController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\QuestionAnswerController;
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


Auth::routes();

Route::middleware('auth')->group(function () {
    Route::resource('forms', FormController::class);
    Route::resource('forms.questions', QuestionController::class)->shallow();
    Route::resource('forms.leads', LeadController::class)
        ->only('index','show')
        ->shallow();
});

Route::post('forms/question/answer/{form}', [QuestionAnswerController::class, 'foo'])->name('forms.question.answer');

Route::get('forms/fill/{form}', [FormController::class, 'fill'])->name('forms.fill');




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
