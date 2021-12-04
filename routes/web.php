<?php

/**
 * 路由定义文件
 */

use App\Http\Controllers\Index\Index;
use App\Http\Controllers\Index\Note;
use App\Http\Controllers\Index\User;
use Max\Foundation\Facades\Route;

Route::get('/', [Index::class, 'index']);
Route::get('/note/(\d+)\.html', [Note::class, 'read'])->alias('read');
Route::get('/search', [Note::class, 'search']);
Route::get('/about', [Index::class, 'about']);

Route::middleware(\App\Http\Middleware\Common\Login::class)->group(function () {
    Route::get('/logout', [User::class, 'logout']);
    Route::prefix('/notes')->group(function () {  // note 路由
        Route::request('/add', [Note::class, 'create']);
        Route::request('/edit/(\d+)', [Note::class, 'edit'])->alias('edit');
        Route::get('/delete/(\d+)', [Note::class, 'delete']);
    });
});

Route::middleware(\App\Http\Middleware\Common\Logined::class)->group(function () {
    Route::request('/login', [User::class, 'login']);
    Route::request('/users/add', [User::class, 'add']);
});

Route::get('/ws/chat', \App\Http\Controllers\WebSocket\Chat::class);
