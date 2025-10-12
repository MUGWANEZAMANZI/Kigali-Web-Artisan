<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kigali Web Artisans</title>
        
         <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="icon" href="{{ asset('logo/logo.jpg') }}" type="image/x-icon">
        <!-- Styles / Scripts -->
         @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="relative h-screen overflow-y-scroll snap-y snap-mandatory bg-slate-950">
    <!-- Blueprint-Inspired Radial Gradient Background -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <img src="logo/back.jpg" class="w-full h-full object-cover scale-105 blur-[2px] brightness-90 opacity-80 transition-all duration-700" alt="Background">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/90 via-blue-900/70 to-cyan-900/60"></div>
        <div class="absolute inset-0" style="background:
            radial-gradient(ellipse at 30% 40%,rgba(34,211,238,0.13) 0%,rgba(59,130,246,0.10) 40%,rgba(30,41,59,0.85) 100%),
            radial-gradient(ellipse at 80% 70%,rgba(250,204,21,0.07) 0%,rgba(59,130,246,0.07) 60%,rgba(30,41,59,0.80) 100%)
        ;"></div>
    </div>

    <!-- Navbar -->
    <header class="relative z-10 flex justify-between items-center px-6 py-4 w-full bg-transparent">
        <!-- Logo -->
        <div class="flex items-center">
            <img src="logo/logo-transparent.png" class="w-32 h-32" alt="Logo">
        </div>

        <!-- Links -->
        <nav class="hidden md:flex space-x-6 text-blue-800 font-bold text-lg">
            <a href="#home" class="hover:text-gray-600">Home</a>
            <a href="#products" class="hover:text-gray-600">Products</a>
            <a href="#about" class="hover:text-gray-600">About</a>
            <a href="#careers" class="hover:text-gray-600">Careers</a>
        </nav>

        <!-- Mobile Hamburger -->
        <div class="md:hidden">
            <button id="mobile-menu-btn">
                <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Mobile Menu -->
    <nav id="mobile-menu" class="hidden flex-col space-y-4 px-6 md:hidden text-blue-800 font-semibold">
        <a href="#home">Home</a>
        <a href="#products">Products</a>
        <a href="#about">About</a>
        <a href="#careers">Careers</a>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="snap-start h-screen flex flex-col items-center justify-center relative z-10 px-6 text-center section-fade-in">
        <h1 class="text-6xl md:text-7xl font-bold text-white">
            We craft digital experiences that <span class="text-yellow-400">empower</span> innovation
        </h1>
        <p class="mt-8 text-xl md:text-2xl text-white max-w-4xl">
            We are a team of developers, designers, and innovators who transform ideas into intelligent, scalable software solutions.
        </p>
        <livewire:customer />
    </section>

    <!-- Products Section -->
    <section id="products" class="snap-start h-screen flex flex-col items-center justify-center px-6 section-fade-in bg-gradient-to-br from-slate-900/80 via-blue-900/60 to-cyan-900/40">
        <h2 class="text-5xl font-bold mb-12 text-blue-800">Our Products</h2>

        <div class="flex flex-wrap justify-center gap-8">
            <!-- Product Card -->
            <div class="bg-white rounded-3xl shadow-lg p-6 flex flex-col items-center w-64 hover:scale-105 transform transition">
                <img src="products/mbaza_ai.png" class="w-32 h-32 object-cover rounded-full mb-4" alt="Mbaza AI">
                <h3 class="text-2xl font-bold text-center mb-2">Mbaza AI</h3>
                <p class="text-center text-gray-700 mb-4">
                    Rwanda-based AI serving legal professionals in courts, law firms, and students.
                </p>
                <a href="https://play.google.com/store/apps/details?id=com.kigaliwebartisans.dormlink"><img src="logo/play.png" class="w-32 h-16" alt="Play Store"></a>
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6 flex flex-col items-center w-64 hover:scale-105 transform transition">
                <img src="products/dorm_link.jpg" class="w-32 h-32 object-cover rounded-full mb-4" alt="DormLink">
                <h3 class="text-2xl font-bold text-center mb-2">Dorm Link</h3>
                <p class="text-center text-gray-700 mb-4">
                    Students can easily find, compare, and book affordable accommodation near their campuses.
                </p>
                <a href="https://play.google.com/store/apps/details?id=com.kigaliwebartisans.dormlink"><img src="logo/play.png" class="w-32 h-16" alt="Play Store"></a>
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6 flex flex-col items-center w-64 hover:scale-105 transform transition">
                <img src="products/site_pay.png" class="w-32 h-32 object-cover rounded-full mb-4" alt="SitePay">
                <h3 class="text-2xl font-bold text-center mb-2">SitePay</h3>
                <p class="text-center text-gray-700 mb-4">
                    All HR and Payroll needs in one place.
                </p>
                <a href="https://play.google.com/store/apps/details?id=com.kigaliwebartisans.dormlink"><img src="logo/play.png" class="w-32 h-16" alt="Play Store"></a>
            </div>
        </div>
    </section>

    <section id="about" class="snap-start h-screen flex flex-col items-center justify-center px-6 section-fade-in bg-gradient-to-br from-slate-900/80 via-blue-900/60 to-cyan-900/40">
        <p class="text-4xl">
            At <span class="text-8xl text-blue-600">Kigali Web Artisans</span>,
            we are a multidisciplinary team of passionate engineers — experts in software, construction, and law — united by a single purpose: to build solutions that make life better.

            We believe that true innovation happens when technology meets culture. Our diverse backgrounds give us a deep understanding of people, their values, and the environments they live in. Whether we are designing digital tools, developing infrastructure, or shaping fair systems, we approach every project with empathy and precision.

            At the heart of our work is a simple belief — everyone has a gift. We are driven to create opportunities that help individuals and communities discover and share those gifts with the world.

            Together, we’re not just building products — we’re building possibilities.
        </p>
    </section>


    <section id="careers" class="snap-start h-screen flex flex-col items-center justify-center px-6 section-fade-in bg-[url('logo/career.jpg')] bg-cover bg-center relative" style="background-image:
        radial-gradient(ellipse at 60% 20%,rgba(59,130,246,0.10) 0%,rgba(34,211,238,0.08) 60%,rgba(30,41,59,0.60) 100%),
        url('logo/career.jpg') !important;
        background-blend-mode: overlay, normal;">

        <!-- Optional content at top/middle of section -->
        <div class="text-center text-white mb-auto">

        </div>

        <!-- Email at the bottom -->
        <p class="text-white px-6 py-3 rounded-full text-xl bg-blue-700 hover:bg-blue-600 absolute bottom-6">
            Email us at <span class="text-yellow-400">careers@kwartisans.com</span>
        </p>

    </section>


    <style>
        .section-fade-in {
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            transition: opacity 0.7s cubic-bezier(.77,0,.18,1.01), transform 0.7s cubic-bezier(.77,0,.18,1.01);
        }
        .section-fade-in.section-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    </style>
    <script>
        // Section fade-in on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.section-fade-in');
            const reveal = () => {
                const trigger = window.innerHeight * 0.85;
                sections.forEach(sec => {
                    const rect = sec.getBoundingClientRect();
                    if (rect.top < trigger) {
                        sec.classList.add('section-visible');
                    } else {
                        sec.classList.remove('section-visible');
                    }
                });
            };
            window.addEventListener('scroll', reveal);
            reveal();
        });
        // Toggle mobile menu
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </body>
    </body>



</html>
