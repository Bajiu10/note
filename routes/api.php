<?php

use App\Http\Controllers\Api\Comment;
use App\Http\Controllers\Api\Note;
use Max\Foundation\Facades\Route;

Route::prefix('/notes')->group(function () {
    Route::get('/heart/(\d+)', [Comment::class, 'heart']);
    Route::post('/comment', [Comment::class, 'create']);
    Route::get('/list', [Note::class, 'list']);
    Route::post('/upload-thumb', [Note::class, 'uploadImage']);
    Route::post('/uploadImage', [Note::class, 'uploadImages']);
});
