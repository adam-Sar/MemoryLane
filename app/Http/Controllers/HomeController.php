<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
{
    $tag=$request->tag;
    $posts = Post::query();
    if(isset($tag)){
        $posts->where('tag',$tag);
    }

    $posts=$posts->withCount(['likes', 'comments'])
    ->addSelect(DB::raw(
        'EXISTS (
            SELECT 1
            FROM post_likes
            WHERE post_likes.post_id = posts.id
            AND post_likes.user_id = ' . (int) Auth::id() . '
        )::int AS liked_by_me'
    ))
    ->with([
        'user'
    ])
    ->orderByDesc('id')
    ->cursorPaginate(15)
    ->withQueryString();


    return view('/home', compact('posts'));
}

}
