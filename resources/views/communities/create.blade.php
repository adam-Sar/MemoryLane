@extends('layouts.app')

@section('content')
<style>
    .create-page {
        max-width: 700px;
        margin: 0 auto;
        padding: 2rem 0;
    }

    .page-header {
        text-align: center;
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
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .form-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--neon-cyan), var(--neon-purple), var(--neon-pink));
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        background: var(--bg-input);
        border: 2px solid var(--border);
        border-radius: var(--radius-md);
        color: var(--text-main);
        font-size: 1rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--neon-cyan);
        box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.1);
    }

    .form-control::placeholder {
        color: var(--text-muted);
    }

    .textarea {
        min-height: 150px;
        resize: vertical;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border);
    }

    @media (max-width: 768px) {
        .create-page {
            padding: 1rem 0;
        }

        .form-card {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .button-group {
            flex-direction: column;
        }
    }
</style>

<div class="create-page">
    <div class="page-header">
        <h1 class="page-title">Create Community</h1>
        <p class="page-subtitle">Build a community around your favorite games!</p>
    </div>

    <form action="{{ route('communities.store') }}" method="POST" class="form-card">
        @csrf
        
        <!-- Community Name -->
        <div class="form-group">
            <label class="form-label" for="name">Community Name</label>
            <input 
                type="text" 
                name="name" 
                id="name"
                class="form-control" 
                required 
                placeholder="e.g. Retro Gaming Lovers"
                maxlength="50"
            >
            <div style="margin-top: 0.5rem; color: var(--text-muted); font-size: 0.85rem;">
                3-50 characters
            </div>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label class="form-label" for="description">Description (Optional)</label>
            <textarea 
                name="description" 
                id="description"
                class="form-control textarea" 
                placeholder="What is this community about? What kind of posts are welcome?"
                maxlength="500"
            ></textarea>
            <div style="margin-top: 0.5rem; color: var(--text-muted); font-size: 0.85rem;">
                Describe your community (max 500 characters)
            </div>
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <a href="{{ route('communities.index') }}" class="btn btn-flat">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Community</button>
        </div>
    </form>
</div>
@endsection