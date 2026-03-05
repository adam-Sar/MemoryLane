<?php
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\CommunityController;
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
    // Home route - view the feed
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/logout', Logout::class)->name('logout');
    Route::post('/like/post/{post}',[PostLikeController::class,'like'])->name('like.post');
    Route::post('/like/comment/{comment}',[CommentLikeController::class,'like'])->name('like.comment');
    
    // Create post page
    Route::get('/posts/create', [PostController::class, 'index'])->name('posts.create');
    
    // Post viewing
    Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');

    Route::post('/create/post',[PostController::class,'store'])->name('create.post');
    Route::post('/create/comment',[CommentController::class,'create'])->name('create.comment');
    
    // Community routes
    Route::get('/communities', [CommunityController::class, 'index'])->name('communities.index');
    Route::get('/communities/create', [CommunityController::class, 'create'])->name('communities.create');
    Route::post('/communities', [CommunityController::class, 'store'])->name('communities.store');
    Route::get('/c/{community}', [CommunityController::class, 'show'])->name('communities.show');
    Route::post('/communities/{community}/join', [CommunityController::class, 'join'])->name('communities.join');
    Route::post('/communities/{community}/leave', [CommunityController::class, 'leave'])->name('communities.leave');
});

Route::middleware('guest')->group(function (){
    Route::get('/register', function() {
        return view('auth.register');
    })->name('register');
    Route::post('/register', Register::class);

    Route::get('/login', function() {
        return view('auth.login');
    })->name('login');
    Route::post('/login', Login::class);
});

