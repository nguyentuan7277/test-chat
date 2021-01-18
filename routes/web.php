<?php

use App\User;
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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/chat', function() {
    return view('chat');
})->middleware('auth');

Route::get('/getUserLogin', function() {
	return Auth::user();
})->middleware('auth');

Route::get('/messages', function() {
    return App\Message::with('user')->get();
})->middleware('auth');

Route::get('/api/message', function() {
    // $user = Auth::user();
    $user = User::find(1);
    $message = new App\Message();
    $message->message = rand();
    $message->user_id = rand();
    $message->save();

    broadcast(new App\Events\MessagePosted($message, $user))->toOthers();
    return ['message' => $message->load('user')];
});
