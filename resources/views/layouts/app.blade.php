<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MemoryLane') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Styles -->
    @vite('resources/css/modern.css')
</head>
<body>
    <div class="app-container">
        <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                MemoryLane
            </a>
            
            <!-- Search Bar -->
            <div class="search-container">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" class="search-input" placeholder="Search games, posts, or users...">
            </div>
            
            <!-- Nav Actions -->
            <div class="nav-links">
                @auth
                    <!-- Create Post Button -->
                    <a href="{{ route('posts.create') }}" class="nav-link nav-create-btn" title="Create Post">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                    </a>
                    
                    <a href="{{ route('home') }}" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </a>
                    <a href="{{ route('communities.index') }}" class="nav-link" title="Communities">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </a>
                    <a href="#" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </a>
                    
                    <!-- User Menu -->
                    <div class="user-menu">
                        <div class="user-avatar-small">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-icon" title="Logout">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                        </button>
                    </form>
                @else
                    <div style="display: flex; gap: 0.75rem;">
                        <a href="{{ route('login') }}" class="btn btn-flat">Log in</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Sign up</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
    <style>
        /* Social Media Navbar Styles */
        .search-container {
            flex: 1;
            max-width: 500px;
            margin: 0 2rem;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            color: var(--text-muted);
            pointer-events: none;
            z-index: 1;
        }
        
        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            background: var(--bg-input);
            border: 2px solid var(--border);
            border-radius: 999px;
            color: var(--text-main);
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--neon-cyan);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
        }
        
        .search-input::placeholder {
            color: var(--text-muted);
        }
        
        .user-menu {
            position: relative;
            cursor: pointer;
        }
        
        .user-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            font-size: 1rem;
            border: 2px solid var(--neon-cyan);
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
            transition: all 0.3s;
        }
        
        .user-avatar-small:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            border-radius: 50%;
            color: var(--text-muted);
            transition: all 0.3s;
            width: 45px;
            height: 45px;
        }
        
        .nav-link:hover {
            color: var(--neon-cyan);
            background: rgba(0, 255, 255, 0.1);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
        }
        
        .nav-link svg {
            stroke-width: 2;
        }
        
        .nav-create-btn {
            background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
            color: #fff;
            border: 2px solid var(--neon-cyan);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.4);
        }
        
        .nav-create-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.6);
        }
        
        .nav-create-btn svg {
            stroke: #fff;
            stroke-width: 2.5;
        }
        
        .btn-icon {
            padding: 0.75rem;
            width: 45px;
            height: 45px;
        }
    </style>

        <!-- Main Content -->
        <main class="page-wrapper">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Universal Modal Logic
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                if (modal.classList.contains('active')) {
                    modal.classList.remove('active');
                } else {
                    modal.classList.add('active');
                    // Focus first input
                    const input = modal.querySelector('input, textarea');
                    if(input) input.focus();
                }
            }
        }

        // Close modal on click outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.classList.remove('active');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
