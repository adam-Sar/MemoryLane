<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentLikeController extends Controller
{
   public function like(Comment $comment)
    {
    $userId = Auth::id();
    $liked = false;

    DB::transaction(function () use ($comment, $userId, &$liked) {
        $exists = CommentLike::where('user_id', $userId)
            ->where('comment_id', $comment->id)
            ->exists();

        if ($exists) {
            CommentLike::where('user_id', $userId)
                ->where('comment_id', $comment->id)
                ->delete();
            $liked = false;
        } else {
            CommentLike::query()->insert([
                'user_id' => $userId,
                'comment_id' => $comment->id,
            ]);

            $liked = true;
        }
    });

    $count = CommentLike::where('comment_id', $comment->id)->count();

    return response()->json([
        'liked' => $liked,
        'likes_count' => $count,
    ]);
    }

}
