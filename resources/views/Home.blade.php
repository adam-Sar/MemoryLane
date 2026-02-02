@extends('layouts.app')

@section('content')
<style>
    /* Override for wider layout */
    .container {
        max-width: 1600px !important;
    }

    /* Home Specific Layout */
    .home-grid {
        display: grid;
        grid-template-columns: 260px 1fr 320px;
        gap: 4rem;
        align-items: start;
    }

    /* Sidebar Navigation */
    .sidebar-left {
        position: sticky;
        top: 6rem;
    }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    /* Right Sidebar Sticky */
    .sidebar-right {
        position: sticky;
        top: 6rem;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-md);
        color: var(--text-muted);
        font-weight: 500;
        transition: all 0.2s;
    }

    .nav-item:hover, .nav-item.active {
        background-color: var(--bg-card-hover);
        color: var(--text-main);
    }
    
    .nav-item.active {
        background-color: rgba(253, 164, 175, 0.1); /* Primary with opacity */
        color: var(--primary);
    }

    /* Feed */
    .feed-column {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        /* Ensure feed takes up space but doesn't stretch indiscriminately if using 1fr */
        width: 100%; 
    }

    /* Create Post Card */
    .create-post-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1rem;
    }
    
    .create-input-fake {
        background: var(--bg-input);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        color: var(--text-muted);
        cursor: text;
        transition: all 0.2s;
    }
    .create-input-fake:hover {
        border-color: var(--text-muted);
    }

    /* Post Card */
    .post-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: border-color 0.2s;
    }
    
    .post-card:hover {
        border-color: var(--bg-card-hover);
    }

    .post-header {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #fff;
        font-size: 0.8rem;
    }

    .post-meta {
        display: flex;
        flex-direction: column;
    }
    .post-author {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-main);
    }
    .post-date {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .post-content {
        padding: 1rem;
    }
    .post-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: var(--text-main);
    }
    .post-body {
        display: block !important;   /* 👈 kills flex */
        align-items: unset !important;
        justify-content: unset !important;

        margin: 0;
        padding: 0;
        white-space: pre-wrap;
        line-height: 1.8;
    }
    
    .post-tag {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: rgba(253, 164, 175, 0.1);
        color: var(--primary);
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.2rem;
        align-items:right;
        margin-left: auto; 
        font-size:20px;
    }

    .post-actions {
        padding: 0.75rem 1.5rem;
        background: rgba(0,0,0,0.1);
        display: flex;
        gap: 1rem;
    }

    .action-btn {
        background: transparent;
        border: none;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        padding: 0.5rem;
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: all 0.2s;
    }
    .action-btn:hover {
        background: rgba(255,255,255,0.05);
        color: var(--text-main);
    }
    .action-btn.liked {
        color: var(--accent);
    }
    .action-btn.liked svg {
        fill: var(--accent);
    }

    /* Comments Area */
    .comments-section {
        padding: 0 1.5rem 1.5rem;
        border-top: 1px solid rgba(255,255,255,0.05);
        background: rgba(0,0,0,0.02);
    }
    .comment-item {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .comment-item:last-child {
        border-bottom: none;
    }

    /* Right Sidebar */
    .widget-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .widget-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 1024px) {
        .home-grid {
            grid-template-columns: 200px 1fr;
        }
        .sidebar-right {
            display: none;
        }
    }
    @media (max-width: 768px) {
        .home-grid {
            grid-template-columns: 1fr;
        }
        .sidebar-nav {
            display: none; /* In real app, make this a mobile drawer */
        }
    }
</style>

<div class="home-grid">
    <!-- Left Sidebar: Navigation -->
    <aside class="sidebar-left">
        <nav class="sidebar-nav">
            <a href="{{ route('home') }}" class="nav-item {{ !request('tag') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Home
            </a>
            
            <div style="margin: 1rem 0 0.5rem 1rem; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">
                Topics
            </div>
            
            @php
                $tags = ['Battle-Royale','RTS','RPG','FPS','Action','Sports','Mobile'];
                $icons = [
                    'Battle-Royale' => '<path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>',
                    'RTS' => '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>',
                    'RPG' => '<path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/>',
                    'FPS' => '<circle cx="12" cy="12" r="10"/><line x1="22" y1="12" x2="18" y2="12"/><line x1="6" y1="12" x2="2" y2="12"/><line x1="12" y1="6" x2="12" y2="2"/><line x1="12" y1="22" x2="12" y2="18"/>',
                    'Action' => '<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/>',
                    'Sports' => '<circle cx="12" cy="12" r="10"/><path d="M4.93 4.93 19.07 19.07"/><path d="M14.21 4.11a9 9 0 0 1-5.1 11.08"/><path d="M5.11 9.79a9 9 0 0 1 11.08 5.1"/>',
                    'Mobile' => '<rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>'
                ];
            @endphp

            @foreach ($tags as $tag)
                <a href="{{ route('home', ['tag' => $tag]) }}" class="nav-item {{ request('tag') == $tag ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        {!! $icons[$tag] ?? '<circle cx="12" cy="12" r="10"/>' !!}
                    </svg>
                    {{ str_replace('-', ' ', $tag) }}
                </a>
            @endforeach
        </nav>
    </aside>

    <!-- Center: Feed -->
    <main class="feed-column">
        <!-- Create Post Widget -->
        <div class="create-post-card">
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
                <div class="user-avatar" style="width: 40px; height: 40px;">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="create-input-fake" onclick="toggleModal('createPostModal')" style="flex: 1;">
                    Describe notice details of the game you can't remember...
                </div>
            </div>
            <div style="display: flex; gap: 1rem; padding-top: 0.5rem; border-top: 1px solid var(--border);">
               <button class="action-btn" onclick="toggleModal('createPostModal')">
                   <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                   Screenshot / Sketch
               </button>
               <button class="action-btn" onclick="toggleModal('createPostModal')">
                   <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                   Description
               </button>
            </div>
        </div>

        <!-- Posts Loop -->
        @foreach($posts as $post)
            <article class="post-card">
                <!-- Post Header -->
                <div class="post-header">
                    <div class="user-avatar">
                        {{ substr($post->user->name ?? '?', 0, 1) }}
                    </div>
                    <div class="post-meta">
                        <span class="post-author">{{ $post->user->name ?? 'Anonymous' }}</span>
                        <span class="post-date">
                            {{ $post->tag }} • 
                             {{ \Carbon\Carbon::parse($post->inserted_at)->diffForHumans() }} <!-- Placeholder for real date if not available -->
                        </span>
                    </div>
                </div>

                <!-- Post Content -->
                <div class="post-content">
                    <a href="{{ route('post.show', $post) }}" class="post-title" style="display:block; text-decoration:none; color:var(--text-main);">
                        {{ $post->title }}
                    </a>
                    <div class="post-body">{{ Str::limit($post->body, 300) }}</div>
                </div>

                <!-- Post Actions -->
                <div class="post-actions">
                    <button 
                        class="action-btn {{ $post->liked_by_me ? 'liked' : '' }}" 
                        onclick="likePost(this, {{ $post->id }})"
                        data-liked-by-me="{{ $post->liked_by_me }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        <span>{{ $post->likes_count }}</span> Likes
                    </button>
                    
                    <a href="{{ route('post.show', $post) }}" class="action-btn" style="text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <span>{{ $post->comments_count }}</span> Comments
                    </a>
                    @if($post->tag)
                        <span class="post-tag">{{ $post->tag }}</span>
                    @endif
                </div>
            </article>
        @endforeach
        
        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            {{ $posts->links('pagination.simple-modern') }}
        </div>
    </main>

    <!-- Right Sidebar -->
    <aside class="sidebar-right">
        <div class="widget-card">
            <h3 class="widget-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                Trending Now
            </h3>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 600; font-size: 0.9rem;">#EldenRing</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">24.5k posts</div>
                    </div>
                </div>
                 <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 600; font-size: 0.9rem;">#IndieDev</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">12k posts</div>
                    </div>
                </div>
            </div>
            <button class="btn btn-flat" style="width: 100%; margin-top: 1rem; font-size: 0.85rem;">View All</button>
        </div>

        <div class="widget-card">
            <h3 class="widget-title">Community</h3>
            <p style="font-size: 0.9rem; color: var(--text-muted);">
                MemoryLane is dedicated to solving "Tip of My Tongue" gaming mysteries. helping you find those game names you forgot.
            </p>
            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border); display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <a href="#" style="font-size: 0.8rem; color: var(--text-muted);">Guidelines</a>
                <a href="#" style="font-size: 0.8rem; color: var(--text-muted);">E-Safety</a>
            </div>
        </div>
    </aside>
</div>

<!-- Create Post Modal -->
<div id="createPostModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h2>Ask the Community</h2>
            <button onclick="document.getElementById('createPostModal').classList.remove('active')" class="close-modal">✕</button>
        </div>
        
        <form action="{{ route('create.post') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Subject</label>
                <input type="text" name="title" class="form-control" required placeholder="e.g. PS2 RPG where you play as a dragon...">
            </div>

            <div class="form-group">
                <label class="form-label">Details</label>
                <textarea name="body" class="form-control" rows="5" required placeholder="Describe everything you remember (Platform, Year, Characters, Gameplay mechanics, Art style)..."></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Tag</label>
                <select name="tag" class="form-control">
                     @foreach (['Battle-Royale','RTS','RPG','FPS','Action','Sports','Mobile'] as $tag)
                        <option value="{{$tag}}">{{$tag}}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="button" onclick="document.getElementById('createPostModal').classList.remove('active')" class="btn btn-flat">Cancel</button>
                <button type="submit" class="btn btn-primary">Post</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function optimisticToggle(btn, delta, isComment = false) {
    const span = btn.querySelector('span');
    const svgs = btn.querySelectorAll('svg');
    const count = parseInt(span.textContent, 10);
    span.textContent = count + delta;
    
    if (delta > 0) {
        btn.classList.add('liked');
        // Optional: Fill the SVG
        if(svgs.length > 0) svgs[0].setAttribute('fill', 'currentColor');
    } else {
        btn.classList.remove('liked');
        if(svgs.length > 0) svgs[0].setAttribute('fill', 'none');
    }
}

function likePost(btn, postId) {
    const span = btn.querySelector('span');
    const originalCount = parseInt(span.textContent, 10);
    const liked = btn.dataset.likedByMe === '1';

    // 🔥 instant UI update
    optimisticToggle(btn, liked ? -1 : 1);
    btn.dataset.likedByMe = liked ? '0' : '1';

    fetch(`/like/post/${postId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('Like failed');
        return res.json();
    })
    .catch(() => {
        // rollback
        optimisticToggle(btn, liked ? 1 : -1);
        btn.dataset.likedByMe = liked ? '1' : '0';
    });
}

function likeComment(btn, commentId) {
    const span = btn.querySelector('span');
    const liked = btn.dataset.likedByMe === '1';

    optimisticToggle(btn, liked ? -1 : 1, true);
    btn.dataset.likedByMe = liked ? '0' : '1';
    
    fetch(`/like/comment/${commentId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        // Sync with server source of truth
        btn.dataset.likedByMe = data.liked ? '1' : '0';
        span.textContent = data.likes_count;
        // Ensure visual state matches
        if (data.liked) {
            btn.classList.add('liked');
            btn.querySelector('svg').setAttribute('fill', 'currentColor');
        } else {
            btn.classList.remove('liked');
            btn.querySelector('svg').setAttribute('fill', 'none');
        }
    })
    .catch(() => {
        // Simple rollback could be added here
    });
}

function toggleComments(id) {
    const el = document.getElementById(id);
    if (el.style.display === 'none') {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}
</script>
@endpush
@endsection