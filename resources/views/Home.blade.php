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
    
    .nav-create-sidebar {
        background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
        color: #fff;
        border: 2px solid var(--neon-cyan);
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
        font-weight: 600;
    }
    
    .nav-create-sidebar:hover {
        transform: translateX(5px);
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
    }
    
    .nav-create-sidebar svg {
        stroke: #fff;
        stroke-width: 2.5;
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
            <a href="{{ route('posts.create') }}" class="nav-item nav-create-sidebar" style="margin-bottom: 1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                <span>Create Post</span>
            </a>
            
            <a href="{{ route('home') }}" class="nav-item {{ !request('tag') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span>Home</span>
            </a>
            
            <a href="#" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                </svg>
                <span>Trending</span>
            </a>
            
            <a href="#" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <span>Messages</span>
            </a>
            
            <a href="#" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <span>Bookmarks</span>
            </a>
            
            <a href="#" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                <span>My Posts</span>
            </a>
            
            <div style="margin: 2rem 0 0.75rem 1.25rem; font-size: 0.7rem; font-weight: 800; color: var(--neon-cyan); text-transform: uppercase; letter-spacing: 0.15em;">
                <span style="border-bottom: 2px solid var(--neon-cyan); padding-bottom: 0.25rem;">Game Categories</span>
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
        <!-- Posts Container -->
        <div id="posts-container" class="feed-column">
            @foreach($posts as $post)
                @include('partials.post-card', ['post' => $post])
            @endforeach
        </div>

        <!-- Scroll Sentinel -->
        <div id="infinite-scroll-sentinel" style="height: 10px; margin-bottom: 50px;"></div>
        
        <!-- Loading Indicator -->
        <div id="loading-indicator" style="display: none;">
            <div class="spinner-wrapper">
                <div class="app-spinner"></div>
                <span class="spinner-text">Finding more memories...</span>
            </div>
        </div>

        <!-- Hidden Pagination for initial state -->
        <div id="pagination-links" style="display: none;">
            {{ $posts->links() }}
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

// Toggle post media (screenshot ↔ doodle)
function togglePostMedia(btn, postId) {
    const container = btn.parentElement;
    const screenshot = container.querySelector('.post-media-screenshot');
    const doodle = container.querySelector('.post-media-doodle');
    
    if (!screenshot || !doodle) return;
    
    const isShowingScreenshot = screenshot.classList.contains('active');
    
    if (isShowingScreenshot) {
        // Switch to doodle
        screenshot.classList.remove('active');
        setTimeout(() => {
            screenshot.style.display = 'none';
        }, 300);
        
        doodle.style.display = 'block';
        setTimeout(() => {
            doodle.classList.add('active');
        }, 50);
        
        btn.textContent = 'View Screenshot 📷';
        btn.classList.add('showing-doodle');
    } else {
        // Switch to screenshot
        doodle.classList.remove('active');
        setTimeout(() => {
            doodle.style.display = 'none';
        }, 300);
        
        screenshot.style.display = 'block';
        setTimeout(() => {
            screenshot.classList.add('active');
        }, 50);
        
        btn.textContent = 'View Doodle 🎨';
        btn.classList.remove('showing-doodle');
    }
}

// Infinite Scroll Logic
let nextPageUrl = document.querySelector('#pagination-links a[rel="next"]')?.href;
let isLoading = false;

const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting && nextPageUrl && !isLoading) {
        loadMorePosts();
    }
}, {
    rootMargin: '200px'
});

const sentinel = document.getElementById('infinite-scroll-sentinel');
if (sentinel) observer.observe(sentinel);

async function loadMorePosts() {
    if (!nextPageUrl || isLoading) return;

    isLoading = true;
    document.getElementById('loading-indicator').style.display = 'block';

    try {
        const response = await fetch(nextPageUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.html) {
            const container = document.getElementById('posts-container');
            container.insertAdjacentHTML('beforeend', data.html);
            nextPageUrl = data.next_page;
        }

        if (!nextPageUrl) {
            observer.unobserve(sentinel);
            sentinel.style.display = 'none';
        }
    } catch (error) {
        console.error('Error loading posts:', error);
    } finally {
        isLoading = false;
        document.getElementById('loading-indicator').style.display = 'none';
    }
}
</script>
@endpush
@endsection