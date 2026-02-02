<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function show($id) {
        $post = Post::query()
            ->where('id', $id)
            ->withCount('likes')
            ->addSelect(\Illuminate\Support\Facades\DB::raw(
                'EXISTS (
                    SELECT 1
                    FROM post_likes
                    WHERE post_likes.post_id = posts.id
                    AND post_likes.user_id = ' . (int) Auth::id() . '
                )::int AS liked_by_me'
            ))
            ->with('user')
            ->firstOrFail();
            
        // Separate query for comments to support pagination
        $comments = \App\Models\Comment::where('post_id', $id)
            ->with('user')
            ->withCount('likes')
            ->addSelect(\Illuminate\Support\Facades\DB::raw(
                'EXISTS (
                    SELECT 1
                    FROM comment_likes
                    WHERE comment_likes.comment_id = comments.id
                    AND comment_likes.user_id = ' . (int) Auth::id() . '
                )::int AS liked_by_me'
            ))
            ->orderByDesc('id') // Newest first usually
            ->cursorPaginate(20);

        return view('posts.show', compact('post', 'comments'));
    }

    function create(Request $request){
        $data = $request->validate([
            "title" => 'required|min:3',
            "body" => 'required',
            'tag'=> 'in:Battle-Royale,RTS,RPG,FPS,Action,Sports,Mobile'
        ]);
        Post::create(["user_id"=>Auth::id()] + $data);
        return redirect()->back();
    }
}