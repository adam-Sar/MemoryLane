@extends('layouts.app')

@section('content')
<style>
    /* Override for wider layout */
    .container {
        max-width: 1600px !important;
    }

    /* Layout Grid */
    .post-grid {
        display: grid;
        grid-template-columns: 260px 1fr 320px;
        gap: 4rem;
        align-items: start;
        padding-top: 1rem;
    }

    /* Sidebars */
    .sidebar-left, .sidebar-right {
        position: sticky;
        top: 6rem;
    }

    /* Main Content */
    .main-column {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
    }

    /* Post Detail Styling */
    .post-detail-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    .post-header {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #fff;
        font-size: 1.2rem;
    }

    .post-content {
        padding: 2rem;
    }

    .post-title {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: var(--text-main);
    }

    .post-body {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-muted);
        white-space: pre-wrap;
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
        padding: 1rem 2rem;
        background: rgba(0,0,0,0.1);
        display: flex;
        gap: 1rem;
        border-top: 1px solid rgba(255,255,255,0.05);
    }

    .action-btn {
        background: transparent;
        border: none;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
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

    /* Comments Section */
    .comments-container {
        margin-top: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .comment-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        transition: border-color 0.2s;
    }
    .comment-card:hover {
        border-color: var(--bg-card-hover);
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    .comment-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .comment-body {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .comment-avatar {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
    }

    /* Comment Form */
    .comment-form-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 0.2rem;
    }
    #commentBody {
        display: block;
        width: 100%;
        resize: none;
        overflow: hidden;
        height: auto;
        min-height: 2.5rem;
        line-height: 1.4rem;
        padding: 0.6rem 0.8rem;
        border-radius: 10px;
        font-size: 0.95rem;
        border: none;
        outline: none;
        box-sizing: border-box;
        background: transparent;
        color: var(--text-main);
        padding-bottom: 0rem;
        margin-bottom: 0rem;
    }

</style>

<div class="post-grid">
    <!-- Left Sidebar -->
    <aside class="sidebar-left">
        <a href="{{ route('home') }}" class="btn btn-flat" style="margin-bottom: 1rem;">
            ← Back to Feed
        </a>
    </aside>

    <!-- Main Content -->
    <main class="main-column">
        <!-- The Post -->
        <article class="post-detail-card">
            <div class="post-header">
                <div class="user-avatar">
                    {{ substr($post->user->name ?? '?', 0, 1) }}
                </div>
                <div>
                    <div style="font-weight: 700; color: var(--text-main);">{{ $post->user->name ?? 'Anonymous' }}</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">Posted earlier</div>
                </div>
            </div>

            <div class="post-content">
                <h1 class="post-title">{{ $post->title }}</h1>
                <div class="post-body">{{ $post->body }}</div>
            </div>

            <div class="post-actions">
                <button 
                    class="action-btn {{ $post->liked_by_me ? 'liked' : '' }}" 
                    onclick="likePost(this, {{ $post->id }})"
                    data-liked-by-me="{{ $post->liked_by_me }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    <span>{{ $post->likes_count }}</span> Likes
                </button>
                <div class="action-btn" style="cursor: default;">
                     <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                     <span id="comment-count-display">{{ $post->comments_count }}</span> Comments
                </div>
                @if($post->tag)
                    <span class="post-tag">{{ $post->tag }}</span>
                @endif
            </div>
        </article>

        <!-- Comment Input -->
        <label for="commentBody">
        <div class="comment-form-card" style=>
            <form id="commentForm" onsubmit="submitComment(event)">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div style="margin-bottom: 0.5rem;">
                    <textarea name="body" id="commentBody" placeholder="What are your thoughts?" oninput="autoResize(this)" required></textarea>
                </div>
                <div style="text-align: right; min-height: 1rem;">
                    <button type="submit" class="btn btn-primary">comment</button>
                </div>
            </form>
        </div>
        </label>
        <!-- Comments List -->
        <div class="comments-container" id="commentsList">
            @foreach($comments as $comment)
                <div class="comment-card" id="comment-{{ $comment->id }}">
                    <div class="comment-header">
                        <div class="comment-meta">
                            <div class="user-avatar comment-avatar">
                                {{ substr($comment->user->name ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <span style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">{{ $comment->user->name ?? 'User' }}</span>
                                <span style="font-size: 0.8rem; color: var(--text-muted); margin-left: 0.5rem;">• 1h ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="comment-body">
                        {{ $comment->body }}
                    </div>
                    <div style="display: flex; gap: 1rem;">
                        <button 
                            class="action-btn {{ $comment->liked_by_me ? 'liked' : '' }}" 
                            style="padding: 0; font-size: 0.85rem;"
                            onclick="likeComment(this, {{ $comment->id }})"
                            data-liked-by-me="{{ $comment->liked_by_me }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            <span>{{ $comment->likes_count }}</span>
                        </button>
                    </div>
                </div>
            @endforeach
            
            <div style="margin-top: 1.5rem;">
                {{ $comments->links('pagination.simple-modern') }}
            </div>
        </div>
    </main>

    <!-- Right Sidebar -->
    <aside class="sidebar-right">
        <div style="background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--border);">
            <h4 style="margin-bottom: 0.5rem;">About this Community</h4>
            <p style="font-size: 0.9rem;">Helping gamers find their lost memories.</p>
        </div>
    </aside>
</div>

@push('scripts')
<script>
    // Optimistic UI for Likes (Reused)
    function optimisticToggle(btn, delta, isComment = false) {
        const span = btn.querySelector('span');
        const svgs = btn.querySelectorAll('svg');
        const count = parseInt(span.textContent, 10);
        span.textContent = count + delta;
        if (delta > 0) {
            btn.classList.add('liked');
            if(svgs.length > 0) svgs[0].setAttribute('fill', 'currentColor');
        } else {
            btn.classList.remove('liked');
            if(svgs.length > 0) svgs[0].setAttribute('fill', 'none');
        }
    }

    function likePost(btn, postId) {
        const liked = btn.dataset.likedByMe === '1';
        optimisticToggle(btn, liked ? -1 : 1);
        btn.dataset.likedByMe = liked ? '0' : '1';
        fetch(`/like/post/${postId}`, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}
        }).catch(() => { optimisticToggle(btn, liked ? 1 : -1); btn.dataset.likedByMe = liked ? '1' : '0'; });
    }

    function likeComment(btn, commentId) {
        // ... (Similar logic, abbreviated for brevity, can copy from Home or create shared JS)
        const liked = btn.dataset.likedByMe === '1';
        optimisticToggle(btn, liked ? -1 : 1, true);
        btn.dataset.likedByMe = liked ? '0' : '1';
        
        // Note: For newly created comments, we need to ensure they have an ID or handle it carefully.
        // If commentId is null/undefined (optimistic), we might block liking until server responds? 
        // For simplicity, strict optimistic liking on brand new comments involves more complex ID tracking.
        if(!commentId) return; 

        fetch(`/like/comment/${commentId}`, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}
        }).catch(() => {});
    }

    // Optimistic Comment Submission
    function submitComment(e) {
        e.preventDefault();
        const form = e.target;
        const body = form.body.value;
        const list = document.getElementById('commentsList');
        const countSpan = document.getElementById('comment-count-display');
        
        // 1. Create Optimistic Element
        const tempId = 'temp-' + Date.now();
        const userName = "{{ Auth::user()->name }}"; // simplifed for immediate feedback
        const userInitial = userName.charAt(0);
        
        const optimisticHTML = `
            <div class="comment-card" id="${tempId}" style="opacity: 0.7;">
                <div class="comment-header">
                    <div class="comment-meta">
                        <div class="user-avatar comment-avatar">${userInitial}</div>
                        <div>
                            <span style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">${userName}</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); margin-left: 0.5rem;">• just now</span>
                        </div>
                    </div>
                </div>
                <div class="comment-body">${body}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">Posting...</div>
            </div>
        `;
        
        // Prepend (or Append? Reddit appends usually, but "newest first" is often better for checking. User said "immediately as i comment it appears")
        // Since the current list is oldest first (usually), we append.
        list.insertAdjacentHTML('beforeend', optimisticHTML);
        
        // Clear input
        form.body.value = '';
        autoResize(form.body);
        // 2. Background Request using Axios
        // Axios is loaded in window calls via app.js -> bootstrap.js
        window.axios.post("{{ route('create.comment') }}", {
            post_id: form.post_id.value,
            body: body
        })
        .then(response => {
            const data = response.data;
            if(data.success) {
                // 3. Success: Update the temp element with real data
                const realElement = document.getElementById(tempId);
                if(realElement) {
                    realElement.style.opacity = '1';
                    // Update ID for liking
                    realElement.id = 'comment-' + data.comment.id;
                    // Replace "Posting..." with action buttons
                    const actionsHTML = `
                        <div style="display: flex; gap: 1rem;">
                            <button 
                                class="action-btn" 
                                style="padding: 0; font-size: 0.85rem;" 
                                onclick="likeComment(this, ${data.comment.id})"
                                data-liked-by-me="0"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                <span>0</span>
                            </button>
                        </div>
                    `;
                    realElement.querySelector('.comment-body').nextElementSibling.outerHTML = actionsHTML;
                    
                    // Update count
                    let currentCount = parseInt(countSpan.textContent);
                    countSpan.textContent = currentCount + 1;
                }
            }
        })
        .catch(error => {
            console.error('Comment Error:', error);
            // 4. Failure: Remove the element
            const el = document.getElementById(tempId);
            if(el) {
                el.remove();
                alert('Failed to post comment. Please try again.');
                // Restore input
                form.body.value = body;
            }
        });
    }
    function autoResize(el) {
        el.style.height = 'auto';
        el.style.height = el.scrollHeight + 'px';
    }

</script>
@endpush
@endsection
