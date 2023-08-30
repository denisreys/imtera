<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SettingsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('question', QuestionController::class)->except([
    'store', 'edit', 'show'
]);
Route::get('settings', [SettingsController::class, 'index']);
Route::put('setting/{name}/update', [SettingsController::class, 'update']);

Route::get('{any?}', function () {
    return view('welcome');
})->where('any', '.*');