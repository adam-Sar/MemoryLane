<?php
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserController;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function (){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', Logout::class)->name('logout');
    Route::post('/like/post/{post}',[PostLikeController::class,'like'])->name('like.post');
    Route::post('/like/comment/{comment}',[CommentLikeController::class,'like'])->name('like.comment');
    Route::post('/create/post',[PostController::class,'create'])->name('create.post');
    Route::post('/create/comment',[CommentController::class,'create'])->name('create.comment');
});

Route::middleware('guest')->group(function (){
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', Register::class);
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', Login::class);
});

