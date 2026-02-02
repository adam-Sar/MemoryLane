<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MemoryLane') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/modern.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-container">
        <!-- Navigation -->
        <nav class="navbar">
            <div class="container nav-container">
                <a href="{{ route('home') }}" class="logo">
                    MemoryLane
                </a>
                
                <div class="nav-links">
                    @auth
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <span class="text-muted" style="font-size: 0.9rem;">Welcome, {{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Logout</button>
                            </form>
                        </div>
                    @else
                        <div style="display: flex; gap: 1rem;">
                            <a href="{{ route('login') }}" class="btn btn-flat">Log in</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

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
