<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index() {
        $communities = \App\Models\Community::whereHas('members', function($q) {
            $q->where('user_id', Auth::id());
        })->orderBy('name')->get();
        return view('posts.create', compact('communities'));
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
            
        // Fetch comments using native eager loading (handles N+1 automatically without manual user array merging)
        // the Comment model now automatically appends liked_by_me based on the myLike relationship.
        $comments = \App\Models\Comment::where('post_id', $id)
            ->whereNull('parent_id') // Only fetch top-level comments
            ->withCount('likes')
            ->with(['allReplies', 'user', 'myLike', 'parent.user']) // Eager load replies, users, and myLike across all nestings
            ->orderByDesc('id')
            ->cursorPaginate(20);

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
            'community_id' => [
                'nullable',
                \Illuminate\Validation\Rule::exists('community_members', 'community_id')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
        ], [
            'community_id.exists' => 'You must be a member of this community to post in it.',
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
            'community_id' => $data['community_id'] ?? null,
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