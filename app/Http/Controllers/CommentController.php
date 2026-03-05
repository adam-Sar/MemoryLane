<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    function create(Request $request){
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            "body" => 'required',
            "post_id" => 'required|exists:posts,id',
            "parent_id" => 'nullable|exists:comments,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $data = $validator->validated();
        
        $comment = Comment::create([
            "user_id" => Auth::id(),
            "post_id" => $request->post_id,
            "parent_id" => $request->parent_id,
            "body" => $data['body']
        ]);
        
        return response()->json([
            'success' => true,
            'comment' => $comment->load('user', 'parent.user')
        ]);
    }
}
