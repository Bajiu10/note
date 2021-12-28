<?php

use Max\Foundation\Facades\Route;

Route::get('/t/(\d+)\.html', function ($id) {
    return redirect('/note/' . $id . '.html');
});
