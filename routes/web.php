<?php

use Max\Foundation\Facades\Route;

Route::get('/t/<id>.html', function($id) {
    return redirect('/note/' . $id . '.html');
});
