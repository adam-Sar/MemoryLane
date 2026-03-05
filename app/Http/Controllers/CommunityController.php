<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    /**
     * Display a listing of all communities.
     */
    public function index()
    {
        $communities = Community::with('user')
            ->withCount('posts', 'members')
            ->latest()
            ->paginate(20);
            
        return view('communities.index', compact('communities'));
    }
    
    /**
     * Show the form for creating a new community.
     */
    public function create()
    {
        return view('communities.create');
    }
    
    /**
     * Store a newly created community.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:50|unique:communities,name',
            'description' => 'nullable|max:500',
        ]);
        
        $community = Community::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'user_id' => Auth::id(),
        ]);
        
        // Automatically join the creator
        CommunityMember::create([
            'community_id' => $community->id,
            'user_id' => Auth::id(),
        ]);
        
        return redirect()->route('communities.show', $community->slug)
            ->with('success', 'Community created successfully!');
    }
    
    /**
     * Display the specified community with its posts.
     */
    public function show($slug)
    {
        $community = Community::where('slug', $slug)
            ->with('user')
            ->withCount('posts', 'members')
            ->firstOrFail();
        
        // Get community posts
        $posts = $community->posts()
            ->with('user')
            ->withCount(['likes', 'comments'])
            ->addSelect(\Illuminate\Support\Facades\DB::raw(
                'EXISTS (
                    SELECT 1
                    FROM post_likes
                    WHERE post_likes.post_id = posts.id
                    AND post_likes.user_id = ' . (int) Auth::id() . '
                )::int AS liked_by_me'
            ))
            ->orderBy('posts.inserted_at', 'desc')
            ->cursorPaginate(20);
        
        // Check if current user is a member
        $isMember = Auth::check() ? $community->hasMember(Auth::id()) : false;
        
        return view('communities.show', compact('community', 'posts', 'isMember'));
    }
    
    /**
     * Join a community.
     */
    public function join($slug)
    {
        $community = Community::where('slug', $slug)->firstOrFail();
        
        // Check if already a member
        if ($community->hasMember(Auth::id())) {
            return back()->with('error', 'You are already a member of this community.');
        }
        
        CommunityMember::create([
            'community_id' => $community->id,
            'user_id' => Auth::id(),
        ]);
        
        return back()->with('success', 'You have joined the community!');
    }
    
    /**
     * Leave a community.
     */
    public function leave($slug)
    {
        $community = Community::where('slug', $slug)->firstOrFail();
        
        CommunityMember::where('community_id', $community->id)
            ->where('user_id', Auth::id())
            ->delete();
        
        return back()->with('success', 'You have left the community.');
    }
}