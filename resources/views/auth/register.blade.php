<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name', 'Laravel Notes') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/modern.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrapper">
        <div class="card auth-card">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">Create Account</h1>
                <p>Start organizing your thoughts today</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" required autofocus placeholder="John Doe">
                    @error('name')
                        <span style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="name@example.com">
                    @error('email')
                        <span style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                    @error('password')
                        <span style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password if standard Laravel auth expects it, usually password_confirmation -->
                <!-- The user didn't show the Register Controller, but standard is 'password_confirmation' -->
                <!-- I'll add it to be safe, standard Laravel Register logic usually validates 'confirmed' -->
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">
                    Sign Up
                </button>

                <div style="text-align: center; margin-top: 1.5rem;">
                    <p style="font-size: 0.9rem;">
                        Already have an account? 
                        <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600;">Log in</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>