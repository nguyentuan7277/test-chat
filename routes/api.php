<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/message', function() {
    $user = User::find(1);

    $message = new App\Message();
    $message->message = rand();
    $message->user_id = $user->id;
    $message->save();

    broadcast(new App\Events\MessagePosted($message, $user))->toOthers();
    return ['message' => $message->load('user')];
});