<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function show($id) {
        // Fetch post without user relation first
        $post = Post::query()
            ->where('id', $id)
            ->withCount(['likes', 'comments'])
            ->addSelect(\Illuminate\Support\Facades\DB::raw(
                'EXISTS (
                    SELECT 1
                    FROM post_likes
                    WHERE post_likes.post_id = posts.id
                    AND post_likes.user_id = ' . (int) Auth::id() . '
                )::int AS liked_by_me'
            ))
            ->firstOrFail();
            
        // Fetch comments without user relation
        $comments = \App\Models\Comment::where('post_id', $id)
            ->withCount('likes')
            ->addSelect(\Illuminate\Support\Facades\DB::raw(
                'EXISTS (
                    SELECT 1
                    FROM comment_likes
                    WHERE comment_likes.comment_id = comments.id
                    AND comment_likes.user_id = ' . (int) Auth::id() . '
                )::int AS liked_by_me'
            ))
            ->orderByDesc('id')
            ->cursorPaginate(20);

        // Collect all unique user IDs from post + comments in ONE query
        $userIds = collect([$post->user_id])
            ->merge($comments->pluck('user_id'))
            ->unique()
            ->values();
        
        // Single query to fetch all users
        $users = \App\Models\User::whereIn('id', $userIds)->get()->keyBy('id');
        
        // Manually set the user relationships
        $post->setRelation('user', $users->get($post->user_id));
        $comments->each(function($comment) use ($users) {
            $comment->setRelation('user', $users->get($comment->user_id));
        });

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