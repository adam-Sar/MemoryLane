<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MemoryLane - Rediscover Forgotten Gems</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container nav-container">
            
            <a href="/" class="logo">MemoryLane</a> 
            <div style="display: flex; gap: 2rem; color: var(--text-muted); font-size: 0.9rem;">
                <a href="#" class="hover:text-white">Home</a>
                <a href="#" class="hover:text-white">Games</a>
                <a href="#" class="hover:text-white">Movies</a>
                <a href="#" class="hover:text-white">Series</a>
            </div>

            <div style="display: flex; gap: 1rem; margin-left: 800px;">
                <button onclick="document.getElementById('loginModal').classList.add('active')" class="btn btn-flat">Login</button>
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.5rem 1.25rem; font-size: 0.9rem;width: 100px;">Signup</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container">
        <section class="landing-hero">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Can't remember the name of that game?</h1>
                    <p>Describe the gameplay, art style, or characters you remember. Our community is here to help you find the title you've been searching for.</p>
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 1rem 2.5rem; border-radius: 99px;">Ask the Community</a>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('assets/img/hero.png') }}" alt="Memory Lane Hero">
                </div>
            </div>
        </section>

        <!-- Explore Popular Titles -->
        <section style="padding: 4rem 0;">
            <h2 class="section-title">Explore Popular Titles</h2>
            <div class="feature-grid">
                <!-- Card 1 -->
                <div class="card feature-card">
                    <img src="{{ asset('assets/img/card1.png') }}" alt="Forgotten Adventures">
                    <h3>Forgotten Adventures</h3>
                    <p>Synonyms and legends</p>
                </div>
                <!-- Card 2 -->
                <div class="card feature-card">
                    <img src="{{ asset('assets/img/card2.png') }}" alt="Classic Cinema">
                    <h3>Classic Cinema</h3>
                    <p>Timeless film studio</p>
                </div>
                <!-- Card 3 -->
                <div class="card feature-card">
                    <img src="{{ asset('assets/img/card3.png') }}" alt="Laugh Out Loud">
                    <h3>Laugh Out Loud</h3>
                    <p>Comedy Channel Access</p>
                </div>
                <!-- Card 4 -->
                <div class="card feature-card">
                    <img src="{{ asset('assets/img/card4.png') }}" alt="Mind-Bending Series">
                    <h3>Mind-Bending Series</h3>
                    <p>Thrilling Plot Twists</p>
                </div>
                <!-- Card 5 (Reuse 1) -->
                <div class="card feature-card">
                    <img src="{{ asset('assets/img/card1.png') }}" alt="Remember the Good">
                    <h3>Remember the Good</h3>
                    <p>Community Contributions</p>
                </div>
            </div>
        </section>

        <!-- Explore Categories -->
        <section style="text-align: center; margin-bottom: 6rem;">
            <button class="btn btn-flat btn-sm" style="background: white; color: black; font-weight: bold; margin-bottom: 1rem; border-radius: 4px;">UPGRADE PLAN</button>
            <h2 style="margin-bottom: 2rem;">Explore Categories</h2>
            
            <div class="category-container">
                <button class="category-pill active">All</button>
                <button class="category-pill">Top Picks</button>
                <button class="category-pill">Trending</button>
                <button class="category-pill" style="background: #fecaca; color: #7f1d1d; border: none;">New Releases</button>
                <button class="category-pill">Old Games</button>
                <button class="category-pill" style="background: #fed7aa; color: #7c2d12; border: none;">Hidden Gems</button>
                <button class="category-pill">User Favorites</button>
                <button class="category-pill">To be Seen</button>
                <button class="category-pill">Search</button>
            </div>
            <div class="category-container">
                <button class="category-pill">Help</button>
                <button class="category-pill">Support</button>
                <button class="category-pill" style="background: #fbcfe8; color: #831843; border: none;">Policy</button>
                <button class="category-pill">Contests</button>
                <button class="category-pill" style="background: #fed7aa; color: #7c2d12; border: none;">Community</button>
                <button class="category-pill">Feedback</button>
                <button class="category-pill">Events</button>
                <button class="category-pill" style="background: #fbcfe8; color: #831843; border: none;">Contacts</button>
            </div>
        </section>

        <!-- Choose Membership -->
        <section class="pricing-section">
            <h2>Choose Your Membership</h2>
            
            <div class="pricing-grid">
                <!-- Basic -->
                <div class="pricing-card">
                    <h4>Basic</h4>
                    <div class="price">FREE</div>
                    
                    <ul class="pricing-features">
                        <li><span class="check-icon">✔</span> Access to all video games</li>
                        <li><span class="check-icon">✔</span> Featured voice on titles</li>
                        <li><span class="check-icon">✔</span> Community interactions</li>
                    </ul>
                    
                    <button class="btn" style="width: 100%; background: white; color: black; margin-top: auto;">Join Free</button>
                </div>

                <!-- Pro -->
                <div class="pricing-card pro" style="border: 1px solid var(--secondary);">
                    <h4>Pro</h4>
                    <div class="price">$30</div>
                    
                    <ul class="pricing-features">
                        <li><span class="check-icon">✔</span> Exclusive masterclasses</li>
                        <li><span class="check-icon">✔</span> Ad-free experience</li>
                        <li><span class="check-icon">✔</span> Premium features</li>
                    </ul>
                    
                    <button class="btn btn-primary" style="width: 100%; margin-top: auto; background: linear-gradient(to right, #fbcfe8, #f472b6); color: #831843; border: none;">Upgrade</button>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="landing-footer">
        <div class="container footer-grid">
            <div>
                <h4 class="logo" style="margin-bottom: 1rem;">MemoryLane</h4>
                <div class="social-links">
                    <a href="#" class="btn-icon" style="background: rgba(255,255,255,0.1);">IG</a>
                    <a href="#" class="btn-icon" style="background: rgba(255,255,255,0.1);">TW</a>
                    <a href="#" class="btn-icon" style="background: rgba(255,255,255,0.1);">FB</a>
                </div>
            </div>
            <div>
                <h4>Community</h4>
                <ul style="opacity: 0.7; line-height: 2;">
                    <li>About Us / Careers</li>
                </ul>
            </div>
            <div>
                <h4>Engage with us</h4>
                <ul style="opacity: 0.7; line-height: 2;">
                    <li>For Contributors</li>
                    <li>Advertising</li>
                    <li>Partnerships</li>
                </ul>
            </div>
            <div>
                <h4>Help</h4>
                <ul style="opacity: 0.7; line-height: 2;">
                    <li>Support Mobile App</li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div id="loginModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h2>Welcome Back</h2>
                <button onclick="document.getElementById('loginModal').classList.remove('active')" class="close-modal">✕</button>
            </div>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="name@example.com">
                    @error('email')
                        <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                    @error('password')
                        <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">
                    Sign In
                </button>

                <div style="text-align: center; margin-top: 1rem;">
                    <a href="#" style="font-size: 0.9rem; color: var(--text-muted);">Forgot your password?</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Simple close on click outside
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    </script>
</body>
</html>