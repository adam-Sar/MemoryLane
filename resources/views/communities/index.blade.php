@extends('layouts.app')

@section('content')
<style>
    .communities-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem 0;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 900;
        background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .communities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .community-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .community-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--neon-cyan), var(--neon-purple), var(--neon-pink));
    }

    .community-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        border-color: var(--neon-cyan);
    }

    .community-name {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.5rem;
        text-decoration: none;
        display: block;
    }

    .community-name:hover {
        color: var(--neon-cyan);
    }

    .community-description {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .community-meta {
        display: flex;
        gap: 1.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .meta-item svg {
        color: var(--neon-purple);
    }

    .creator {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--bg-card);
        border: 2px dashed var(--border);
        border-radius: var(--radius-lg);
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        margin-bottom: 1rem;
        color: var(--neon-cyan);
    }

    .empty-state h3 {
        font-size: 1.5rem;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .communities-page {
            padding: 1rem 0;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .communities-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="communities-page">
    <div class="page-header">
        <h1 class="page-title">Communities</h1>
        <a href="{{ route('communities.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Create Community
        </a>
    </div>

    @if($communities->count() > 0)
        <div class="communities-grid">
            @foreach($communities as $community)
                <div class="community-card">
                    <a href="{{ route('communities.show', $community->slug) }}" class="community-name">
                        {{ $community->name }}
                    </a>

                    <p class="creator">Created by {{ $community->user->name ?? 'Unknown' }}</p> 
                                
                    @if($community->description)
                        <p class="community-description">{{ $community->description }}</p>
                    @endif
                    
                    <div class="community-meta">
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            {{ $community->posts_count }} {{ $community->posts_count == 1 ? 'post' : 'posts' }}
                        </div>
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            {{ $community->members_count }} {{ $community->members_count == 1 ? 'member' : 'members' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $communities->links() }}
    @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <h3>No communities yet</h3>
            <p>Be the first to create a community!</p>
            <a href="{{ route('communities.create') }}" class="btn btn-primary">Create Community</a>
        </div>
    @endif
</div>
@endsection