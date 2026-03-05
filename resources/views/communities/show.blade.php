@extends('layouts.app')

@section('content')
<style>
    .community-show-page {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem 0;
    }

    .community-header {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .community-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--neon-cyan), var(--neon-purple), var(--neon-pink));
    }

    .community-title {
        font-size: 2.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .community-description {
        color: var(--text-muted);
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 1.5rem;
        max-width: 800px;
    }

    .community-meta {
        display: flex;
        gap: 2rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .meta-item svg {
        color: var(--neon-purple);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .empty-posts {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--bg-card);
        border: 2px dashed var(--border);
        border-radius: var(--radius-lg);
    }

    .empty-posts svg {
        width: 64px;
        height: 64px;
        margin-bottom: 1rem;
        color: var(--neon-cyan);
    }

    .empty-posts h3 {
        font-size: 1.5rem;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }

    .empty-posts p {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .posts-section {
        display: grid;
        gap: 1.5rem;
    }

    @media (max-width: 768px) {
        .community-show-page {
            padding: 1rem 0;
        }

        .community-header {
            padding: 1.5rem;
        }

        .community-title {
            font-size: 1.8rem;
        }

        .community-meta {
            flex-direction: column;
            gap: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="community-show-page">
    <!-- Community Header -->
    <div class="community-header">
        <h1 class="community-title">{{ $community->name }}</h1>
        
        @if($community->description)
            <p class="community-description">{{ $community->description }}</p>
        @endif
        
        <div class="community-meta">
            <div class="meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                {{ $community->posts_count }} {{ $community->posts_count == 1 ? 'post' : 'posts' }}
            </div>
            <div class="meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                {{ $community->members_count }} {{ $community->members_count == 1 ? 'member' : 'members' }}
            </div>
            <div class="meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Created by {{ $community->user->name ?? 'Unknown' }}
            </div>
        </div>

        <div class="action-buttons">
            @if($isMember)
                <form action="{{ route('communities.leave', $community->slug) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-flat" onclick="return confirm('Are you sure you want to leave this community?')">
                        Leave Community
                    </button>
                </form>
            @else
                <form action="{{ route('communities.join', $community->slug) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                        Join Community
                    </button>
                </form>
            @endif
            
            @if($isMember)
                <a href="{{ route('posts.create') }}?community={{ $community->id }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Create Post
                </a>
            @endif
        </div>
    </div>

    <!-- Posts -->
    @if($posts->count() > 0)
        <div class="posts-section">
            @foreach($posts as $post)
                @include('partials.post-card', ['post' => $post])
            @endforeach
        </div>
        
        <div style="margin-top: 2rem;">
            {{ $posts->links() }}
        </div>
    @else
        <div class="empty-posts">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="17 8 12 3 7 8"/>
                <line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
            <h3>No posts yet</h3>
            <p>Be the first to share something in {{ $community->name }}!</p>
            @if($isMember)
                <a href="{{ route('posts.create') }}?community={{ $community->id }}" class="btn btn-primary">Create Post</a>
            @else
                <p><strong>Join the community to start posting!</strong></p>
            @endif
        </div>
    @endif
</div>
@endsection