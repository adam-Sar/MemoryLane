<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index() {
        return view('posts.create');
    }

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

    function store(Request $request){
        $data = $request->validate([
            "title" => 'required|min:3',
            "body" => 'required',
            'tag'=> 'in:Battle-Royale,RTS,RPG,FPS,Action,Sports,Mobile',
            'screenshot' => 'nullable|image|max:5120', // 5MB max
            'doodle' => 'nullable|image|max:5120', // 5MB max
            'doodle_data' => 'nullable|string', // For canvas data
        ]);

        // Handle screenshot upload
        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('posts', 'public');
        }

        // Handle doodle - either from file or canvas
        $doodlePath = null;
        if ($request->hasFile('doodle')) {
            $doodlePath = $request->file('doodle')->store('posts', 'public');
        } elseif ($request->has('doodle_data') && !empty($request->doodle_data)) {
            // Handle canvas data (base64 image)
            $doodlePath = $this->saveCanvasData($request->doodle_data);
        }

        Post::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'body' => $data['body'],
            'tag' => $data['tag'],
            'screenshot_path' => $screenshotPath,
            'doodle_path' => $doodlePath,
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    /**
     * Save canvas data (base64) as image file
     */
    private function saveCanvasData($base64Data)
    {
        // Remove data URL prefix
        $base64Data = preg_replace('#^data:image/\w+;base64,#i', '', $base64Data);
        $base64Data = base64_decode($base64Data);
        
        // Generate unique filename
        $filename = 'doodle_' . uniqid() . '_' . time() . '.png';
        $path = 'posts/' . $filename;
        
        // Store image
        Storage::disk('public')->put($path, $base64Data);
        
        return $path;
    }
}