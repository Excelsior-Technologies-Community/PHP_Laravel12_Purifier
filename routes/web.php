<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return redirect('/posts');
});

Route::get('/post/create', [PostController::class, 'create']);
Route::post('/post/store', [PostController::class, 'store'])
        ->name('post.store');

Route::get('/posts', [PostController::class, 'index'])
        ->name('posts.index');

Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');