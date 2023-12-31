<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatApiController;
use App\Http\Controllers\PlayListApiController;
use App\Http\Controllers\StudentProgressApiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('signup', [AuthController::class, 'apiCreateStudent']);
Route::post('login', [AuthController::class, 'apiLoginStudent']);
Route::post('send-push', [ApiController::class, 'sendPushNotification']);



Route::middleware('jwt.verify')->group(function () {
    Route::get('/user', [UserController::class, 'apiGetUser']);
    Route::get('/homeData', [ApiController::class, 'homeData']);

    Route::get('/chapters/{id}', [ApiController::class, 'subjectWiseChapter']);
    Route::get('/likedislike/{id}', [ApiController::class, 'likeDislikeVideo']);
    Route::get('/comments/{id}', [ApiController::class, 'getCommentsOnVideo']);
    Route::post('/comments/{id}', [ApiController::class, 'postCommentsOnVideo']);
    Route::get('/videoByChapter/{id}', [ApiController::class, 'videoByChapterId']);
    Route::get('/videos', [ApiController::class, 'allVideos']);

    Route::get('/todayvideos', [ApiController::class, 'todaysLearningVideos']);
    Route::get('/likedvideos', [ApiController::class, 'likedVideo']);
    Route::get('/search/{subjectName}', [ApiController::class, 'searchVideo']);



    Route::get('/followorunfollow', [ApiController::class, 'followUser']);
    Route::get('/profile', [ApiController::class, 'profileData']);
    Route::get('/updateView', [ApiController::class, 'updateView']);
    Route::get('/views', [ApiController::class, 'getViews']);
    Route::get('/followers', [ApiController::class, 'followersData']);
    Route::get('/following', [ApiController::class, 'followingData']);


    Route::get('/wishlist', [ApiController::class, 'getWishList']);
    Route::post('/wishlist', [ApiController::class, 'postWishList']);

    Route::get('/savelater', [ApiController::class, 'getSaveLater']);
    Route::post('/savelater', [ApiController::class, 'postSaveLater']);


    Route::get('/chatList', [ChatApiController::class, 'getChatList']);
    Route::get('/subscription', [ApiController::class, 'getSubscription']);

    Route::post('/studentProgress', [StudentProgressApiController::class, 'postAddProgress']);
    Route::get('/studentProgress', [StudentProgressApiController::class, 'getProgress']);

    //PlaylistApi
    Route::get('/playlist', [PlayListApiController::class, 'playlistByUser']);
    Route::post('/playlist', [PlayListApiController::class, 'createPlaylistByUser']);
    Route::get('/playlistvideo', [PlayListApiController::class, 'playlistVideo']);








});
