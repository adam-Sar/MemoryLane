<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
{
    $posts = Post::withCount('likes')->orderBy('inserted_at')->orderBy('id', 'desc') ->cursorPaginate(15);
    return view('/home', compact('posts'));
}

}
