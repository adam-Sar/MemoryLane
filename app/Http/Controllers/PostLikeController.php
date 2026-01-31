<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function like(Post $post){
         PostLike::query()->insert([
        'user_id' => Auth::id(),
        'post_id' => $post->id,
    ]);
        return redirect()->back();
    }   
}