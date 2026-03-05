<div class="comment-card {{ isset($isReply) && $isReply ? 'reply' : '' }}" id="comment-{{ $comment->id }}">
    <div class="comment-header">
        <div class="comment-meta">
            <div class="user-avatar comment-avatar">
                {{ substr($comment->user->name ?? '?', 0, 1) }}
            </div>
            <div>
                <span style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">{{ $comment->user->name ?? 'User' }}</span>
                @if(isset($isReply) && $isReply && $comment->parent && $comment->parent->user)
                    <span style="font-size: 0.8rem; color: var(--neon-purple); margin-left: 0.5rem;">→ {{ $comment->parent->user->name }}</span>
                @endif
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
            data-liked-by-me="{{ $comment->liked_by_me ? '1' : '0' }}"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            <span>{{ $comment->likes_count ?? 0 }}</span>
        </button>
        <button 
            class="action-btn" 
            style="padding: 0; font-size: 0.85rem; color: var(--neon-purple);"
            onclick="toggleReplyForm({{ $comment->id }})"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
            Reply
        </button>
    </div>
    
    <!-- Reply Form (Hidden by default) -->
    <div id="reply-form-{{ $comment->id }}" class="reply-form" style="display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);">
        <form onsubmit="submitReply(event, {{ $comment->id }})">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <input type="hidden" name="top_parent_id" value="{{ isset($topParentId) ? $topParentId : $comment->id }}">
            <div style="margin-bottom: 0.5rem;">
                <textarea name="body" id="replyBody-{{ $comment->id }}" placeholder="Write a reply..." oninput="autoResize(this)" required style="min-height: 2.5rem; display: block; width: 100%; resize: none; overflow: hidden; height: auto; line-height: 1.4rem; padding: 0.6rem 0.8rem; border-radius: 10px; font-size: 0.95rem; border: none; outline: none; box-sizing: border-box; background: transparent; color: var(--text-main); margin-bottom: 0rem;"></textarea>
            </div>
            <div style="text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                <button type="button" class="btn btn-flat" onclick="toggleReplyForm({{ $comment->id }})" style="padding: 0.5rem 1rem;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;">Reply</button>
            </div>
        </form>
    </div>
</div>


