<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    function create(Request $request){
        $data = $request->validate([
            "body" => 'required'
        ]);
        $comment = Comment::create(["user_id"=>Auth::id(),"post_id"=>$request->post_id]+$data);
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user') // Load user for the frontend to display name/avatar
            ]);
        }
        
        return redirect()->back();
    }
}