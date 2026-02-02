<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostLikeController extends Controller
{
    public function like(Post $post)
    {
        $userId = Auth::id();
        $liked = false;

        DB::transaction(function () use ($post, $userId, &$liked) {
            $exists = PostLike::where('user_id', $userId)
                ->where('post_id', $post->id)
                ->exists();

            if ($exists) {
                PostLike::where('user_id', $userId)
                    ->where('post_id', $post->id)
                    ->delete();

                $liked = false;
            } else {
                PostLike::query()->insert([
                    'user_id' => $userId,
                    'post_id' => $post->id,
                ]);
                $liked = true;
            }
        });

        $count = PostLike::where('post_id', $post->id)->count();

        return response()->json([
            'liked' => $liked,
            'likes_count' => $count,
        ]);
    }
}
