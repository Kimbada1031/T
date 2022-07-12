<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EditorController;
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

Route::middleware([    
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/* Route::get('/', [TaskController::class, 'index']);
Route::get('tasks/create', [TaskController::class, 'create']);
Route::post('tasks', [TaskController::class, 'store']); */
//Route::resource('tasks', TaskController::class);

Route::get('/post/{category}', [PostController::class, 'index'])->name('post');
Route::get('/write', [TestController::class, 'store'])->name('write');
Route::post('/writePost', [PostController::class, 'store'])->name('write_post');
Route::get('/show/{id}', [PostController::class, 'show'])->name('show');
Route::get('/edit/{id}', [PostController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [PostController::class, 'update'])->name('update');
Route::get('/delete/{id}', [PostController::class, 'destroy'])->name('delete');

Route::get('/comment', [PostController::class, 'commentStore'])->name('comment');
Route::get('/d_comment/{id}', [PostController::class, 'commentDestroy'])->name('d_comment');
Route::get('/u_comment/{id}', [PostController::class, 'commentUpdate'])->name('u_comment');

Route::get('/test', [TestController::class, 'index'])->name('test');

Route::post('/editor/upload', [EditorController::class, 'upload'])->name('editor.upload');