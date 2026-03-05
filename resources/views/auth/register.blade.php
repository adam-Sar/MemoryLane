<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MemoryLane - Register</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/modern.css'])
</head>
<body class="auth-wrapper">
    <!-- Background Effects -->
    <div class="auth-bg-effects">
        <div class="bg-glow glow-1"></div>
        <div class="bg-glow glow-2"></div>
        <div class="bg-glow glow-3"></div>
    </div>

    <div class="auth-container">
        <!-- Logo -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 3rem; font-weight: 900; background: linear-gradient(90deg, var(--neon-cyan), var(--neon-purple), var(--neon-pink)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: block; margin: 0 auto 1rem; color: var(--neon-cyan); filter: drop-shadow(0 0 15px var(--neon-cyan));">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                MemoryLane
            </h1>
            <p style="color: var(--text-muted); font-size: 1rem; letter-spacing: 0.5px;">Find Your Forgotten Games</p>
        </div>

        <!-- Register Card -->
        <div class="auth-card">
            <div style="text-align: center; margin-bottom: 2rem; position: relative; z-index: 1;">
                <h2 style="font-size: 1.8rem; font-weight: 800; color: var(--text-main); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">
                    Join the Quest
                </h2>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Create your account and start finding games</p>
            </div>

            <form action="{{ route('register') }}" method="POST" style="position: relative; z-index: 1;">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="name">Player Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control" 
                        required 
                        autofocus 
                        placeholder="Gamer123"
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <span style="color: var(--accent-danger); font-size: 0.8rem; display: block; margin-top: 0.5rem; animation: shake 0.5s;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        required 
                        placeholder="player@example.com"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <span style="color: var(--accent-danger); font-size: 0.8rem; display: block; margin-top: 0.5rem; animation: shake 0.5s;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        required 
                        placeholder="•••••••"
                    >
                    @error('password')
                        <span style="color: var(--accent-danger); font-size: 0.8rem; display: block; margin-top: 0.5rem; animation: shake 0.5s;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-control" 
                        required 
                        placeholder="•••••••"
                    >
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px;">
                    Create Account
                </button>
            </form>

            <div style="text-align: center; margin-top: 2rem; position: relative; z-index: 1;">
                <p style="color: var(--text-muted); font-size: 0.9rem;">
                    Already have an account? 
                    <a href="{{ route('login') }}" style="color: var(--neon-cyan); font-weight: 700; text-decoration: none; transition: all 0.3s;">
                        Sign In →
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer Links -->
        <div style="text-align: center; margin-top: 2rem; position: relative; z-index: 1;">
            <div style="display: flex; justify-content: center; gap: 2rem; margin-bottom: 1rem;">
                <a href="{{ route('home') }}" style="color: var(--text-muted); font-size: 0.85rem; text-decoration: none; transition: all 0.3s;">
                    Home
                </a>
                <a href="#" style="color: var(--text-muted); font-size: 0.85rem; text-decoration: none; transition: all 0.3s;">
                    About
                </a>
                <a href="#" style="color: var(--text-muted); font-size: 0.85rem; text-decoration: none; transition: all 0.3s;">
                    Help
                </a>
            </div>
            <p style="color: var(--text-muted); font-size: 0.75rem;">
                © 2026 MemoryLane. All rights reserved.
            </p>
        </div>
    </div>

    <style>
        .auth-bg-effects {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .bg-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            animation: float 8s ease-in-out infinite;
        }

        .glow-1 {
            width: 400px;
            height: 400px;
            background: var(--neon-purple);
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .glow-2 {
            width: 500px;
            height: 500px;
            background: var(--neon-pink);
            bottom: -250px;
            right: -250px;
            animation-delay: -4s;
        }

        .glow-3 {
            width: 300px;
            height: 300px;
            background: var(--neon-cyan);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -2s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-30px) scale(1.1);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .auth-container {
            max-width: 450px;
            width: 100%;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .auth-card {
            background: linear-gradient(145deg, var(--bg-card), var(--bg-darker));
            border: 2px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--neon-purple), var(--neon-pink), var(--neon-cyan));
        }

        .auth-card::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(176, 38, 255, 0.03) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }
    </style>
</body>
</html>