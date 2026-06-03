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

Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');

Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');        

Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

Route::get('/posts/export', [PostController::class, 'export'])->name('posts.export');        