<?php

use Illuminate\Http\Request;

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

Route::middleware(['auth.apikey'])->group(function () {
    Route::get('/user', function () {
        return $request->user();
    });

    Route::post('notify', 'NotificationController@create');

    Route::get('ping', function() {
        return response()->json([
            'message' => 'Notification API is live.'
        ]);
    });
});
