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
        background: linear-gradient(145deg, var(--bg-card), var(--bg-darker));
        border: 2px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        position: relative;
    }
    
    .post-detail-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--neon-cyan), var(--neon-purple), var(--neon-pink));
    }

    .post-header {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-bottom: 1px solid var(--border);
    }

    .user-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #fff;
        font-size: 1.4rem;
        border: 3px solid var(--neon-cyan);
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
    }

    .post-content {
        padding: 2.5rem;
    }

    .post-title {
        font-size: 2.2rem;
        margin-bottom: 1.5rem;
        color: var(--text-main);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1.3;
    }

    .post-body {
        font-size: 1.1rem;
        line-height: 1.9;
        color: var(--text-muted);
        white-space: pre-wrap;
    }

    .post-tag {
        display: inline-block;
        padding: 0.4rem 1rem;
        background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(176, 38, 255, 0.15));
        color: var(--neon-cyan);
        border: 1px solid var(--neon-cyan);
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 0 10px rgba(0, 255, 255, 0.2);
    }

    .post-actions {
        padding: 1.25rem 2.5rem;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.3), transparent);
        display: flex;
        gap: 1.5rem;
        border-top: 1px solid var(--border);
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
    
    .comment-card.reply {
        margin-left: 2rem;
        margin-top: 1rem;
        border-left: 3px solid var(--neon-purple);
        background: rgba(176, 38, 255, 0.05);
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
    
    /* Media Tabs for Detail Page */
    .post-media-tabs {
        display: flex;
        gap: 0.5rem;
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .media-tab {
        flex: 1;
        padding: 0.75rem 1.5rem;
        background: var(--bg-input);
        border: 2px solid var(--border);
        border-radius: 999px;
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .media-tab:hover {
        border-color: var(--text-muted);
        color: var(--text-main);
    }
    
    .media-tab.active {
        background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
        border-color: var(--neon-cyan);
        color: #fff;
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.4);
    }
    
    .post-media-content {
        position: relative;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 2px solid var(--border);
        background: rgba(0, 0, 0, 0.2);
    }
    
    .detail-media {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        display: none;
        transition: opacity 0.3s ease-in-out;
    }
    
    .detail-media.active {
        display: block;
        opacity: 1;
    }
    
    .detail-media-doodle {
        max-height: 400px;
        border: 3px dashed var(--neon-purple);
    }
    
    .detail-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        display: block;
        border-radius: var(--radius-md);
    }
    
    .detail-image.doodle {
        max-height: 400px;
        border: 3px dashed var(--neon-purple);
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
                
                <!-- Media Display -->
                @if($post->screenshot_path && $post->doodle_path)
                    <!-- Both: Tab switcher -->
                    <div class="post-media-tabs" data-post-id="{{ $post->id }}">
                        <button type="button" class="media-tab active" data-tab="screenshot" onclick="switchMediaTab(this, 'screenshot')">
                            Screenshot
                        </button>
                        <button type="button" class="media-tab" data-tab="doodle" onclick="switchMediaTab(this, 'doodle')">
                            Doodle 🎨
                        </button>
                    </div>
                    <div class="post-media-content">
                        <img 
                            src="{{ asset('storage/' . $post->screenshot_path) }}" 
                            alt="Screenshot" 
                            class="detail-media detail-media-screenshot active"
                        >
                        <img 
                            src="{{ asset('storage/' . $post->doodle_path) }}" 
                            alt="Doodle" 
                            class="detail-media detail-media-doodle"
                        >
                    </div>
                @elseif($post->screenshot_path)
                    <!-- Screenshot only -->
                    <div class="post-image-container">
                        <img 
                            src="{{ asset('storage/' . $post->screenshot_path) }}" 
                            alt="Screenshot" 
                            class="detail-image"
                        >
                    </div>
                @elseif($post->doodle_path)
                    <!-- Doodle only -->
                    <div class="post-image-container">
                        <img 
                            src="{{ asset('storage/' . $post->doodle_path) }}" 
                            alt="Doodle" 
                            class="detail-image doodle"
                        >
                    </div>
                @endif
                <!-- Text only: No media -->
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
        <!-- Comments List -->
        <div class="comments-container" id="commentsList">
            @foreach($comments as $comment)
                @include('posts.partials.reply', ['comment' => $comment, 'post' => $post])
                @if($comment->allReplies && $comment->allReplies->count() > 0)
                    <div class="replies-container">
                        @foreach($comment->allReplies as $nestedReply)
                            @include('posts.partials.reply', [
                                'comment' => $nestedReply, 
                                'post' => $post, 
                                'isReply' => true,
                                'topParentId' => $comment->id
                            ])
                        @endforeach
                    </div>
                @endif
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
<script nonce="{{ md5(now()) }}">
    // Optimistic UI for Likes (Reused)
    function optimisticToggle(btn, delta, isComment = false) {
        const span = btn.querySelector('span');
        const svgs = btn.querySelectorAll('svg');
        const count = parseInt(span.textContent.trim() || '0', 10);
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
        // 2. Background Request using fetch
        fetch("{{ route('create.comment') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                post_id: form.querySelector('input[name="post_id"]').value,
                body: body
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Server response:', data);
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
                            <button 
                                class="action-btn" 
                                style="padding: 0; font-size: 0.85rem; color: var(--neon-purple);"
                                onclick="toggleReplyForm(${data.comment.id})"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                Reply
                            </button>
                        </div>
                        <div id="reply-form-${data.comment.id}" class="reply-form" style="display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                            <form onsubmit="submitReply(event, ${data.comment.id})">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="hidden" name="parent_id" value="${data.comment.id}">
                                <div style="margin-bottom: 0.5rem;">
                                    <textarea name="body" id="replyBody-${data.comment.id}" placeholder="Write a reply..." oninput="autoResize(this)" required style="min-height: 2.5rem; display: block; width: 100%; resize: none; overflow: hidden; height: auto; line-height: 1.4rem; padding: 0.6rem 0.8rem; border-radius: 10px; font-size: 0.95rem; border: none; outline: none; box-sizing: border-box; background: transparent; color: var(--text-main); margin-bottom: 0rem;"></textarea>
                                </div>
                                <div style="text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <button type="button" class="btn btn-flat" onclick="toggleReplyForm(${data.comment.id})" style="padding: 0.5rem 1rem;">Cancel</button>
                                    <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;">Reply</button>
                                </div>
                            </form>
                        </div>
                    `;
                    realElement.querySelector('.comment-body').nextElementSibling.outerHTML = actionsHTML;
                    
                    // Update count
                    let currentCount = parseInt(countSpan.textContent);
                    countSpan.textContent = currentCount + 1;
                }
            } else {
                // Handle validation errors or other failure
                console.error('Comment failed:', data.errors);
                throw new Error(data.errors ? Object.values(data.errors).join(', ') : 'Failed to post comment');
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
    
    // Toggle reply form visibility
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        if (form.style.display === 'none') {
            form.style.display = 'block';
            // Focus the textarea
            const textarea = document.getElementById(`replyBody-${commentId}`);
            if (textarea) {
                setTimeout(() => textarea.focus(), 100);
            }
        } else {
            form.style.display = 'none';
            // Clear the textarea
            const textarea = document.getElementById(`replyBody-${commentId}`);
            if (textarea) {
                textarea.value = '';
                autoResize(textarea);
            }
        }
    }
    
    // Submit reply to a comment
    function submitReply(event, parentCommentId) {
        event.preventDefault();
        const form = event.target;
        const body = form.body.value;
        const countSpan = document.getElementById('comment-count-display');
        const parentComment = document.getElementById(`comment-${parentCommentId}`);
        const topParentId = form.querySelector('input[name="top_parent_id"]') ? form.querySelector('input[name="top_parent_id"]').value : parentCommentId;
        const topParentComment = document.getElementById(`comment-${topParentId}`);
        
        if (!parentComment || !topParentComment) return;
        
        // 1. Create optimistic reply element
        const tempId = 'reply-temp-' + Date.now();
        const userName = "{{ Auth::user()->name }}";
        const userInitial = userName.charAt(0);
        const parentUserName = parentComment.querySelector('.comment-meta span:first-child').textContent;
        
        // Find or create direct replies container under TOP parent
        let repliesContainer = topParentComment.nextElementSibling;
        if (!repliesContainer || !repliesContainer.classList.contains('replies-container')) {
            repliesContainer = document.createElement('div');
            repliesContainer.className = 'replies-container';
            topParentComment.after(repliesContainer);
        }
        
        const optimisticHTML = `
            <div class="comment-card reply" id="${tempId}" style="opacity: 0.7;">
                <div class="comment-header">
                    <div class="comment-meta">
                        <div class="user-avatar comment-avatar">${userInitial}</div>
                        <div>
                            <span style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">${userName}</span>
                            <span style="font-size: 0.8rem; color: var(--neon-purple); margin-left: 0.5rem;">→ ${parentUserName}</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); margin-left: 0.5rem;">• just now</span>
                        </div>
                    </div>
                </div>
                <div class="comment-body">${body}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">Posting...</div>
            </div>
        `;
        
        // Add reply to container
        repliesContainer.insertAdjacentHTML('beforeend', optimisticHTML);
        
        // Clear form and hide it
        form.body.value = '';
        autoResize(form.body);
        toggleReplyForm(parentCommentId);
        
        // 2. Submit to server
        fetch("{{ route('create.comment') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                post_id: form.querySelector('input[name="post_id"]').value,
                parent_id: form.querySelector('input[name="parent_id"]').value,
                body: body
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // 3. Update optimistic element with real data
                const realElement = document.getElementById(tempId);
                if(realElement) {
                    realElement.style.opacity = '1';
                    realElement.id = 'comment-' + data.comment.id;
                    
                    // Replace "Posting..." with like button
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
                            <button 
                                class="action-btn" 
                                style="padding: 0; font-size: 0.85rem; color: var(--neon-purple);"
                                onclick="toggleReplyForm(${data.comment.id})"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                Reply
                            </button>
                        </div>
                        <div id="reply-form-${data.comment.id}" class="reply-form" style="display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                            <form onsubmit="submitReply(event, ${data.comment.id})">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="hidden" name="parent_id" value="${data.comment.id}">
                                <input type="hidden" name="top_parent_id" value="${topParentId}">
                                <div style="margin-bottom: 0.5rem;">
                                    <textarea name="body" id="replyBody-${data.comment.id}" placeholder="Write a reply..." oninput="autoResize(this)" required style="min-height: 2.5rem; display: block; width: 100%; resize: none; overflow: hidden; height: auto; line-height: 1.4rem; padding: 0.6rem 0.8rem; border-radius: 10px; font-size: 0.95rem; border: none; outline: none; box-sizing: border-box; background: transparent; color: var(--text-main); margin-bottom: 0rem;"></textarea>
                                </div>
                                <div style="text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <button type="button" class="btn btn-flat" onclick="toggleReplyForm(${data.comment.id})" style="padding: 0.5rem 1rem;">Cancel</button>
                                    <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;">Reply</button>
                                </div>
                            </form>
                        </div>
                    `;
                    realElement.querySelector('.comment-body').nextElementSibling.outerHTML = actionsHTML;
                    
                    // Update comment count
                    let currentCount = parseInt(countSpan.textContent);
                    countSpan.textContent = currentCount + 1;
                }
            } else {
                // Handle validation errors or other failure
                console.error('Reply failed:', data.errors);
                throw new Error(data.errors ? Object.values(data.errors).join(', ') : 'Failed to post reply');
            }
        })
        .catch(error => {
            console.error('Reply Error:', error);
            // 4. Remove optimistic element on error
            const el = document.getElementById(tempId);
            if(el) {
                el.remove();
                alert('Failed to post reply. Please try again.');
            }
        });
    }

    // Switch media tabs (screenshot ↔ doodle)
    function switchMediaTab(btn, tabName) {
        const tabsContainer = btn.parentElement;
        const contentContainer = tabsContainer.nextElementSibling;
        
        // Update tab buttons
        const tabs = tabsContainer.querySelectorAll('.media-tab');
        tabs.forEach(tab => {
            tab.classList.remove('active');
            if (tab.dataset.tab === tabName) {
                tab.classList.add('active');
            }
        });
        
        // Update media visibility
        const screenshot = contentContainer.querySelector('.detail-media-screenshot');
        const doodle = contentContainer.querySelector('.detail-media-doodle');
        
        if (!screenshot || !doodle) return;
        
        // Fade out current
        const activeMedia = contentContainer.querySelector('.detail-media.active');
        if (activeMedia) {
            activeMedia.classList.remove('active');
            setTimeout(() => {
                activeMedia.style.display = 'none';
            }, 300);
        }
        
        // Fade in new
        const newMedia = tabName === 'screenshot' ? screenshot : doodle;
        newMedia.style.display = 'block';
        setTimeout(() => {
            newMedia.classList.add('active');
        }, 50);
    }

</script>
@endpush
@endsection
