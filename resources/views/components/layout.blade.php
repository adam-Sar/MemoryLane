<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'My App' }}</title>

    {{-- DaisyUI / Tailwind via CDN (no Vite) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css"
        rel="stylesheet"
        type="text/css"
    />

    {{-- Page-specific styles --}}
    {{ $styles ?? '' }}
</head>
<body class="min-h-screen bg-base-200">

    {{-- Navbar --}}
    <div class="navbar bg-base-100 shadow">
        <div class="navbar-start">
            <a href="/" class="btn btn-ghost text-xl">MyApp</a>
        </div>

        <div class="navbar-end gap-2">
            @auth
                <span class="text-sm">{{ auth()->user()->name }}</span>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">
                        Logout
                    </button>
                </form>
            @else
                <a href="/login" class="btn btn-ghost btn-sm">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                    Sign Up
                </a>
            @endauth
        </div>
    </div>

    {{-- Page Content --}}
    <main>
        {{ $slot }}
    </main>

</body>
</html>
