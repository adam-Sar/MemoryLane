<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
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