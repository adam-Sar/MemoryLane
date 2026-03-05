<article class="post-card">
    <!-- Post Header -->
    <div class="post-header">
        <div class="user-avatar">
            {{ substr($post->user->name ?? '?', 0, 1) }}
        </div>
        <div class="post-meta">
            <span class="post-author">{{ $post->user->name ?? 'Anonymous' }}</span>
            @if($post->community)
                <a href="{{ route('communities.show', $post->community->slug) }}" class="post-community-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.3rem;">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    {{ $post->community->name }}
                </a>
            @endif
            <span class="post-date">
                @if($post->tag)
                    <span class="post-tag-sm">{{ $post->tag }}</span>
                @endif
                {{ \Carbon\Carbon::parse($post->inserted_at)->diffForHumans() }}
            </span>
        </div>
    </div>

    <!-- Post Content -->
    <div class="post-content">
        <a href="{{ route('post.show', $post) }}" class="post-title" style="display:block; text-decoration:none; color:var(--text-main);">
            {{ $post->title }}
        <div class="post-body">{{ Str::limit($post->body, 300) }}</div>
        </a>
        <!-- Media Display -->
        @if($post->screenshot_path && $post->doodle_path)
            <!-- Case D: Both Screenshot and Doodle -->
            <div class="post-media-container" data-post-id="{{ $post->id }}">
                <img 
                    src="{{ asset('storage/' . $post->screenshot_path) }}" 
                    alt="Screenshot" 
                    class="post-media post-media-screenshot active"
                >
                <img 
                    src="{{ asset('storage/' . $post->doodle_path) }}" 
                    alt="Doodle" 
                    class="post-media post-media-doodle"
                >
                <button type="button" class="media-toggle-btn" onclick="togglePostMedia(this, {{ $post->id }})">
                    View Doodle 🎨
                </button>
            </div>
        @elseif($post->screenshot_path)
            <!-- Case B: Screenshot Only -->
            <div class="post-image-container">
                <a href="{{ route('post.show', $post) }}">
                    <img 
                        src="{{ asset('storage/' . $post->screenshot_path) }}" 
                        alt="Screenshot" 
                        class="post-image"
                    >
                </a>
            </div>
        @elseif($post->doodle_path)
            <!-- Case C: Doodle Only -->
            <div class="post-image-container">
                <a href="{{ route('post.show', $post) }}">
                    <img 
                        src="{{ asset('storage/' . $post->doodle_path) }}" 
                        alt="Doodle" 
                        class="post-image doodle"
                    >
                </a>
            </div>
        @endif
        <!-- Case A: Text Only - No media container -->
    </div>

    <!-- Post Actions -->
    <div class="post-actions">
        <button 
            class="action-btn {{ $post->liked_by_me ? 'liked' : '' }}" 
            onclick="likePost(this, {{ $post->id }})"
            data-liked-by-me="{{ $post->liked_by_me }}"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            <span>{{ $post->likes_count }}</span>
        </button>
        
        <a href="{{ route('post.show', $post) }}" class="action-btn" style="text-decoration: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span>{{ $post->comments_count }}</span>
        </a>
        
        <button class="action-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
            Share
        </button>
        
        <button class="action-btn" style="margin-left:auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
        </button>
    </div>
</article>

<style>
    .post-community-link {
        display: inline-flex;
        align-items: center;
        padding: 0.2rem 0.6rem;
        background: linear-gradient(135deg, rgba(176, 38, 255, 0.15), rgba(255, 0, 128, 0.15));
        color: var(--neon-purple);
        border: 1px solid var(--neon-purple);
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        margin: 0.3rem 0.5rem 0.3rem 0;
        transition: all 0.2s;
        box-shadow: 0 0 8px rgba(176, 38, 255, 0.2);
    }
    
    .post-community-link:hover {
        background: linear-gradient(135deg, var(--neon-purple), var(--neon-pink));
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 0 12px rgba(176, 38, 255, 0.4);
    }
    
    .post-tag-sm {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(176, 38, 255, 0.15));
        color: var(--neon-cyan);
        border: 1px solid var(--neon-cyan);
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-right: 0.5rem;
        box-shadow: 0 0 8px rgba(0, 255, 255, 0.2);
    }
    
    .post-image-container {
        margin-top: 1rem;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 2px solid var(--border);
        transition: all 0.3s;
    }
    
    .post-image-container:hover {
        border-color: var(--neon-cyan);
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
    }
    
    .post-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        display: block;
    }
    
    .post-image.doodle {
        max-height: 300px;
        border: 3px dashed var(--neon-purple);
    }
    
    /* Media Container for Toggle */
    .post-media-container {
        position: relative;
        margin-top: 1rem;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 2px solid var(--border);
    }
    
    .post-media-container:hover {
        border-color: var(--neon-cyan);
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
    }
    
    .post-media {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        display: none;
        transition: opacity 0.3s ease-in-out;
    }
    
    .post-media.active {
        display: block;
        opacity: 1;
    }
    
    .post-media-doodle {
        max-height: 300px;
        border: 3px dashed var(--neon-purple);
    }
    
    .media-toggle-btn {
        position: absolute;
        bottom: 0.75rem;
        right: 0.75rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, var(--neon-purple), var(--neon-pink));
        color: #fff;
        border: 2px solid var(--neon-purple);
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 10;
        box-shadow: 0 0 15px rgba(176, 38, 255, 0.4);
    }
    
    .media-toggle-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(176, 38, 255, 0.6);
    }
    
    .media-toggle-btn.showing-doodle {
        background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
        border-color: var(--neon-cyan);
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.4);
    }
</style>
