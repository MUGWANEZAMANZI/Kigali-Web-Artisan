<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Careers - Kigali Web Artisans</title>
    <link rel="icon" href="{{ asset('logo/logo.jpg') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- AOS CSS for Scroll Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Custom Game-like Animations */
        @keyframes slideUpFade {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
            50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.6), 0 0 60px rgba(59, 130, 246, 0.3); }
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .animate-slide-up {
            animation: slideUpFade 1s ease forwards;
        }
        
        .animate-glow {
            animation: glowPulse 3s ease-in-out infinite;
        }
        
        .gradient-bg {
            background: linear-gradient(-45deg, #1e3a8a, #3b82f6, #6366f1, #8b5cf6);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .neon-text {
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.8), 0 0 20px rgba(59, 130, 246, 0.6), 0 0 30px rgba(59, 130, 246, 0.4);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
        }
    </style>
</head>

<body class="text-white min-h-screen overflow-x-hidden">
    <!-- Animated Background Particles -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-400 rounded-full opacity-20 animate-ping"></div>
        <div class="absolute top-3/4 right-1/4 w-3 h-3 bg-purple-400 rounded-full opacity-30 animate-pulse"></div>
        <div class="absolute bottom-1/4 left-1/3 w-1 h-1 bg-yellow-400 rounded-full opacity-40 animate-bounce"></div>
        <div class="absolute top-1/2 right-1/3 w-2 h-2 bg-green-400 rounded-full opacity-25 animate-ping" style="animation-delay: 2s;"></div>
    </div>

    <!-- Header with Game-like Animations -->
    <header class="relative z-10 w-full text-sm mb-6 flex flex-row justify-between items-center lg:mb-12 lg:text-base gradient-bg shadow-2xl py-6 px-8" data-aos="fade-down">
        <div class="flex justify-start items-center gap-4" data-aos="fade-right" data-aos-delay="200">
            <img src="{{ asset('logo/logo.jpg') }}" alt="Kigali Web Artisans" class="h-16 rounded-full border-4 border-white shadow-2xl hover:scale-110 transition-all duration-500 animate-glow" />
            <span class="text-white text-3xl font-black tracking-tight drop-shadow-2xl neon-text">Kigali Web Artisans</span>
        </div>
        <nav class="flex gap-8 items-center" data-aos="fade-left" data-aos-delay="300">
            <a href="/" class="text-white hover:text-yellow-300 font-bold transition-all duration-300 hover:scale-110 hover:drop-shadow-lg">Home</a>
            <a href="/teams" class="text-white hover:text-yellow-300 font-bold transition-all duration-300 hover:scale-110 hover:drop-shadow-lg">Our Team</a>
            <a href="/careers" class="text-yellow-300 font-bold scale-110 neon-text">Careers</a>
            <a href="/games" class="text-white hover:text-yellow-300 font-bold transition-all duration-300 hover:scale-110 hover:drop-shadow-lg">Gisenyi Studios</a>
        </nav>
    </header>

    <!-- Main Content with Layered Animations -->
    <main class="relative z-10 max-w-6xl mx-auto px-8 pb-16">
        <!-- Hero Section -->
        <div class="text-center mb-16" data-aos="zoom-in" data-aos-duration="1000">
            <h1 class="text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-500 to-yellow-400 mb-6 tracking-tight neon-text">
                Career Opportunities
            </h1>
            <p class="text-2xl text-gray-300 font-light tracking-wide">Join our team at Kigali Web Artisans</p>
            <div class="mt-8 w-32 h-1 bg-gradient-to-r from-blue-500 to-purple-500 mx-auto rounded-full"></div>
        </div>

        <!-- Status Cards with Game-like Effects -->
        <div class="grid md:grid-cols-2 gap-8 mb-16">
            <!-- Current Status Card -->
            <div class="glass-effect rounded-3xl p-8 shadow-2xl hover:shadow-blue-500/25 transition-all duration-500 hover:scale-105 hover:-translate-y-2" data-aos="fade-right" data-aos-duration="1200">
                <div class="flex items-center mb-6">
                    <div class="w-4 h-4 bg-red-500 rounded-full mr-4 animate-pulse"></div>
                    <h3 class="text-2xl font-bold text-red-400 neon-text">No Current Vacancies</h3>
                </div>
                <p class="text-gray-300 text-lg leading-relaxed">
                    We are not hiring at this time. Our team is focused on delivering exceptional digital experiences and preparing for future expansion.
                </p>
                <div class="mt-6 h-1 bg-gradient-to-r from-red-500 to-pink-500 rounded-full opacity-60"></div>
            </div>

            <!-- Future Opportunities Card -->
            <div class="glass-effect rounded-3xl p-8 shadow-2xl hover:shadow-green-500/25 transition-all duration-500 hover:scale-105 hover:-translate-y-2" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
                <div class="flex items-center mb-6">
                    <div class="w-4 h-4 bg-green-500 rounded-full mr-4 animate-bounce"></div>
                    <h3 class="text-2xl font-bold text-green-400 neon-text">Stay Connected</h3>
                </div>
                <p class="text-gray-300 text-lg leading-relaxed mb-4">
                    We're constantly growing and may have opportunities in:
                </p>
                <div class="space-y-3">
                    <div class="flex items-center text-cyan-300">
                        <div class="w-2 h-2 bg-cyan-400 rounded-full mr-3 animate-pulse"></div>
                        <span>Web Development & Real-time 3D</span>
                    </div>
                    <div class="flex items-center text-purple-300">
                        <div class="w-2 h-2 bg-purple-400 rounded-full mr-3 animate-pulse" style="animation-delay: 0.5s;"></div>
                        <span>AI & Machine Learning</span>
                    </div>
                    <div class="flex items-center text-yellow-300">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3 animate-pulse" style="animation-delay: 1s;"></div>
                        <span>Game Development</span>
                    </div>
                </div>
                <div class="mt-6 h-1 bg-gradient-to-r from-green-500 to-cyan-500 rounded-full opacity-60"></div>
            </div>
        </div>

        <!-- Interactive Contact Section -->
        <div class="text-center mb-20" data-aos="fade-up" data-aos-duration="1500">
            <h2 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 mb-8">Get in Touch</h2>
            <p class="text-xl text-gray-300 mb-12 max-w-2xl mx-auto leading-relaxed">
                Interested in future opportunities? We'd love to hear from talented creators and innovators who share our passion for cutting-edge technology.
            </p>
            
            <!-- Interactive Contact Card -->
            <div class="max-w-md mx-auto glass-effect rounded-3xl p-8 shadow-2xl hover:shadow-cyan-500/25 transition-all duration-700 hover:scale-105" data-aos="zoom-in" data-aos-delay="300">
                <div class="mb-8">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full mx-auto mb-4 flex items-center justify-center animate-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-white">
                            <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                            <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Send Your Resume</h3>
                    <p class="text-cyan-300 font-semibold">MUGWANEZA MANZI Audace</p>
                    <p class="text-gray-400">HR & Talent Acquisition</p>
                </div>
                
                <a href="mailto:mmaudace@gmail.com" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-2xl font-bold text-lg hover:from-blue-500 hover:to-cyan-500 transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-cyan-500/50 group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 group-hover:rotate-12 transition-transform duration-300">
                        <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                    </svg>
                    Contact Us
                </a>
                
                <div class="mt-6 text-sm text-gray-400">
                    <p>We are not accepting new applications at this time.</p>
                    <p class="text-cyan-400">Check back for future opportunities!</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Futuristic Footer -->
    <footer class="relative z-10 w-full text-sm mt-20 gradient-bg py-12 shadow-2xl" data-aos="fade-up">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-cyan-500"></div>
        <div class="max-w-6xl mx-auto px-8">
            <div class="text-center space-y-4">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="w-3 h-3 bg-cyan-400 rounded-full animate-ping"></div>
                    <p class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Kigali Web Artisans</p>
                    <div class="w-3 h-3 bg-purple-400 rounded-full animate-ping" style="animation-delay: 1s;"></div>
                </div>
                
                <p class="text-xl font-bold text-white">© {{ date('Y') }} All rights reserved.</p>
                <p class="text-lg text-gray-300">Head Office: Rubavu, Gisenyi, Rwanda</p>
                
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mt-8">
                    <a href="mailto:mmaudace@gmail.com" class="flex items-center gap-2 text-yellow-300 hover:text-yellow-200 transition-colors duration-300 hover:scale-110 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                            <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                        </svg>
                        mmaudace@gmail.com
                    </a>
                    <a href="tel:+250788123456" class="flex items-center gap-2 text-cyan-300 hover:text-cyan-200 transition-colors duration-300 hover:scale-110 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z" clip-rule="evenodd" />
                        </svg>
                        +250 788 123 456
                    </a>
                </div>
                
                <div class="mt-8 flex justify-center space-x-4">
                    <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                    <div class="w-2 h-2 bg-cyan-400 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-bounce" style="animation-delay: 0.6s;"></div>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS JavaScript for Scroll Animations -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1200,
            once: true,
            easing: 'ease-in-out',
            offset: 100,
            delay: 100
        });
        
        // Additional smooth scroll behavior for page load
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                document.body.style.overflow = 'auto';
            }, 500);
        });
    </script>

</body>
</html>
