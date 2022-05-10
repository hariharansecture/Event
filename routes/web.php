<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\Controller::class, 'eventListing'])->name('eventListing');
Route::get('/get-event', [App\Http\Controllers\Controller::class, "getEvent"])->name('get-event');
Route::get('/view-statistics', [App\Http\Controllers\Controller::class, "viewStatistics"])->name('view-statistics');
Route::post('/daterange/fetch_data', [App\Http\Controllers\Controller::class, "fetch_data"])->name('daterange.fetch_data');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/create-event', [App\Http\Controllers\HomeController::class, 'createEvent'])->name('create-event');
Route::get('/invite-event', [App\Http\Controllers\HomeController::class, 'inviteEvent'])->name('invite-event');
Route::post('/send-invite', [App\Http\Controllers\HomeController::class, 'sendInvite'])->name('send-invite');
Route::get('accept/{token}', [App\Http\Controllers\HomeController::class, 'acceptInvite'])->name('accept');
Route::post('/save-event', [App\Http\Controllers\HomeController::class, 'saveEvent'])->name('save-event');
Route::get('/view-invite', [App\Http\Controllers\HomeController::class, 'viewInvitation'])->name('view-invite');
Route::get('/delete-invite/{id}', [App\Http\Controllers\HomeController::class, 'deleteInvite'])->name('delete-invite');
