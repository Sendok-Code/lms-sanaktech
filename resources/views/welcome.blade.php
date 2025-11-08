<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $siteName = \App\Models\Setting::get('site_name', 'MyLMS');
        $siteDescription = \App\Models\Setting::get('site_description', 'Platform Pembelajaran Online Terbaik');
    @endphp
    <title>{{ $siteName }} - {{ $siteDescription }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes blob {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float 6s ease-in-out 1s infinite; }
        .animate-fade-up { animation: fadeInUp 0.8s ease-out; }
        .animate-fade-left { animation: fadeInLeft 0.8s ease-out; }
        .animate-fade-right { animation: fadeInRight 0.8s ease-out; }
        .animate-scale-in { animation: scaleIn 0.8s ease-out; }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }
        .blob-animation { animation: blob 8s ease-in-out infinite; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        /* Hover Effects */
        .hover-lift {
            transition: all 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .hover-glow:hover {
            box-shadow: 0 0 30px rgba(249, 115, 22, 0.5);
        }

        /* Parallax */
        .parallax {
            transition: transform 0.3s ease-out;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="font-inter antialiased bg-white text-gray-900 overflow-x-hidden">

    <!-- Animated Background Blobs -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute top-20 -left-40 w-80 h-80 bg-gradient-to-br from-orange-300 to-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float blob-animation"></div>
        <div class="absolute top-40 -right-40 w-80 h-80 bg-gradient-to-br from-purple-300 to-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float-delayed blob-animation"></div>
        <div class="absolute -bottom-40 left-1/3 w-80 h-80 bg-gradient-to-br from-yellow-300 to-orange-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float blob-animation"></div>
    </div>

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 glass z-50 border-b border-white/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3 group">
                    @php
                        $siteLogo = \App\Models\Setting::get('site_logo');
                        $siteName = \App\Models\Setting::get('site_name', 'MyLMS');
                        $logoHeight = \App\Models\Setting::get('logo_height', '40');
                    @endphp
                    @if($siteLogo)
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" style="height: {{ $logoHeight }}px;" class="object-contain transform group-hover:scale-110 transition-all duration-300">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-pink-500 rounded-lg flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    @endif
                    <span class="text-xl font-bold text-gray-900">{{ $siteName }}</span>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#courses" class="text-gray-700 hover:text-orange-500 font-semibold transition-all duration-300 relative group">
                        Kursus
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#features" class="text-gray-700 hover:text-orange-500 font-semibold transition-all duration-300 relative group">
                        Fitur
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#testimonials" class="text-gray-700 hover:text-orange-500 font-semibold transition-all duration-300 relative group">
                        Testimoni
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ Auth::user()->role === 'admin' ? route('admin.index') : route('student.dashboard') }}"
                           class="hidden md:inline-flex items-center px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold rounded-full transition-all duration-300 hover:shadow-xl hover:scale-105">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center px-6 py-2.5 text-sm font-semibold text-gray-700 hover:text-orange-500 transition-all duration-300">
                            Masuk
                        </a>
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white text-sm font-bold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                            Daftar Gratis
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button type="button" class="md:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-white/30 glass">
            <div class="px-4 py-4 space-y-3">
                <a href="#courses" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-500 font-semibold rounded-lg transition">
                    Kursus
                </a>
                <a href="#features" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-500 font-semibold rounded-lg transition">
                    Fitur
                </a>
                <a href="#testimonials" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-500 font-semibold rounded-lg transition">
                    Testimoni
                </a>

                @auth
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.index') : route('student.dashboard') }}"
                       class="block w-full px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white text-center font-bold rounded-lg transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="block w-full px-4 py-3 text-center text-gray-700 hover:bg-gray-100 font-semibold rounded-lg transition">
                        Masuk
                    </a>
                    <a href="{{ route('login') }}"
                       class="block w-full px-4 py-3 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white text-center font-bold rounded-lg transition shadow-lg">
                        Daftar Gratis
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-20 sm:pt-28 lg:pt-32 pb-16 sm:pb-20 lg:pb-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-6 sm:space-y-8 animate-fade-left">
                    <div class="inline-flex items-center px-4 sm:px-5 py-2 bg-gradient-to-r from-orange-100 to-pink-100 rounded-full text-orange-600 font-bold text-xs sm:text-sm animate-fade-up">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        #1 Platform Kursus Online di Indonesia
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black text-gray-900 leading-tight animate-fade-up delay-100">
                        Belajar <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 via-pink-500 to-purple-500 animate-gradient">Tanpa Batas</span>
                    </h1>

                    <p class="text-base sm:text-lg lg:text-xl text-gray-600 leading-relaxed animate-fade-up delay-200">
                        Raih karir impian dengan belajar dari instruktur terbaik. Akses selamanya, belajar kapan saja dan dimana saja. 🚀
                    </p>

                    <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 animate-fade-up delay-300">
                        <a href="{{ route('login') }}" class="group inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white text-sm sm:text-base font-bold rounded-full transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                            Mulai Belajar Sekarang
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="#courses" class="group inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-white border-2 border-gray-200 hover:border-orange-500 text-gray-700 hover:text-orange-500 text-sm sm:text-base font-bold rounded-full transition-all duration-300 hover:shadow-lg">
                            Lihat Kursus
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 sm:gap-6 lg:gap-8 pt-6 sm:pt-8 border-t border-gray-200 animate-fade-up delay-400">
                        <div class="text-center lg:text-left">
                            <div class="text-2xl sm:text-3xl lg:text-4xl font-black bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent counter" data-target="50000">0</div>
                            <div class="text-xs sm:text-sm text-gray-600 mt-1 font-semibold">Student Aktif</div>
                        </div>
                        <div class="text-center lg:text-left">
                            <div class="text-2xl sm:text-3xl lg:text-4xl font-black bg-gradient-to-r from-pink-500 to-purple-500 bg-clip-text text-transparent counter" data-target="150">0</div>
                            <div class="text-xs sm:text-sm text-gray-600 mt-1 font-semibold">Kursus Premium</div>
                        </div>
                        <div class="text-center lg:text-left">
                            <div class="text-2xl sm:text-3xl lg:text-4xl font-black bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent">4.9★</div>
                            <div class="text-xs sm:text-sm text-gray-600 mt-1 font-semibold">Rating Platform</div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Hero Image with Floating Elements -->
                <div class="relative animate-fade-right hidden lg:block">
                    <!-- Main Hero Image -->
                    <div class="relative z-10">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl hover-lift">
                            <!-- Modern Illustration/Image -->
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=80"
                                 alt="Students Learning"
                                 class="w-full h-[500px] object-cover">

                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

                            <!-- Stats Overlay -->
                            <div class="absolute bottom-6 left-6 right-6">
                                <div class="bg-white/95 backdrop-blur-md rounded-2xl p-6 shadow-xl">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-pink-500 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 text-lg">Web Development</h3>
                                                <p class="text-sm text-gray-500">12 Video Lessons</p>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-black text-orange-500">85%</div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                        <div class="bg-gradient-to-r from-orange-500 to-pink-500 h-full rounded-full transition-all duration-1000" style="width: 85%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Card 1 - Top Right -->
                        <div class="absolute -top-6 -right-6 bg-gradient-to-br from-orange-500 to-pink-500 rounded-2xl p-6 shadow-xl animate-float">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <div class="text-white">
                                    <div class="text-2xl font-bold">4.9</div>
                                    <div class="text-sm opacity-80">Rating</div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Card 2 - Bottom Left -->
                        <div class="absolute -bottom-8 -left-8 bg-white rounded-2xl p-6 shadow-xl animate-float-delayed">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">50K+</div>
                                    <div class="text-sm text-gray-500">Students</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 sm:mb-16 animate-fade-up">
                <div class="inline-block px-4 py-2 bg-orange-100 rounded-full text-orange-600 font-bold text-xs sm:text-sm mb-4">
                    🚀 Kenapa Memilih Kami?
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-4 px-4">
                    Fitur <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-pink-500">Unggulan</span>
                </h2>
                <p class="text-base sm:text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto px-4">
                    Platform pembelajaran terlengkap dengan berbagai fitur untuk mendukung kesuksesan Anda
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-up delay-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Video HD</h3>
                    <p class="text-gray-600">Belajar dengan video berkualitas tinggi yang mudah dipahami</p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-up delay-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Akses Selamanya</h3>
                    <p class="text-gray-600">Belajar kapan saja tanpa batasan waktu dengan akses lifetime</p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-up delay-300">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Sertifikat</h3>
                    <p class="text-gray-600">Dapatkan sertifikat resmi setelah menyelesaikan kursus</p>
                </div>

                <!-- Feature 4 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-up delay-400">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Instruktur Pro</h3>
                    <p class="text-gray-600">Belajar langsung dari ahli di bidangnya masing-masing</p>
                </div>

                <!-- Feature 5 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-up delay-500">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Project Based</h3>
                    <p class="text-gray-600">Latihan dengan project nyata untuk pengalaman maksimal</p>
                </div>

                <!-- Feature 6 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-up delay-500">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Cloud Based</h3>
                    <p class="text-gray-600">Akses dari device apapun kapan saja dan dimana saja</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 sm:mb-16">
                <div class="inline-block px-4 py-2 bg-orange-100 rounded-full text-orange-600 font-bold text-xs sm:text-sm mb-4">
                    📚 Kursus Terpopuler
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-4 px-4">
                    Mulai <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-pink-500">Belajar Sekarang</span>
                </h2>
                <p class="text-base sm:text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto px-4">
                    Pilih dari ratusan kursus berkualitas tinggi yang dirancang oleh para ahli
                </p>
            </div>

            @php
                $featuredCourses = \App\Models\Course::with(['category', 'instructor.user'])
                    ->where('is_published', true)
                    ->latest()
                    ->take(6)
                    ->get();
            @endphp

            @if($featuredCourses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($featuredCourses as $index => $course)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group animate-fade-up delay-{{ ($index % 3) * 100 + 100 }}">
                    <!-- Course Image/Thumbnail -->
                    <div class="relative h-52 overflow-hidden">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                 alt="{{ $course->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            @php
                                $images = [
                                    'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=80',
                                    'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=500&auto=format&fit=crop&q=80',
                                    'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=500&auto=format&fit=crop&q=80',
                                    'https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?w=500&auto=format&fit=crop&q=80',
                                    'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=500&auto=format&fit=crop&q=80',
                                    'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=500&auto=format&fit=crop&q=80',
                                ];
                                $courseImage = $images[($course->id - 1) % count($images)];
                            @endphp
                            <img src="{{ $courseImage }}"
                                 alt="{{ $course->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @endif

                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <!-- Play Button Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center shadow-xl transform scale-75 group-hover:scale-100 transition-transform duration-300">
                                <svg class="w-8 h-8 text-orange-500 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-semibold rounded-full">
                                {{ $course->category->name ?? 'Umum' }}
                            </span>
                            <span class="text-xl font-bold text-orange-500">
                                Rp {{ number_format($course->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                            {{ $course->title }}
                        </h3>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ Str::limit($course->description, 100) }}
                        </p>

                        <!-- Course Meta -->
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4 pb-4 border-b border-gray-100">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>{{ Str::limit($course->instructor->user->name ?? 'Instructor', 15) }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $course->modules->sum(function($m) { return $m->videos->count(); }) }} Video</span>
                            </div>
                        </div>

                        @auth
                            <a href="{{ route('student.courses.show', $course) }}"
                               class="block w-full px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white text-center font-semibold rounded-lg transition">
                                Lihat Detail
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="block w-full px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white text-center font-semibold rounded-lg transition">
                                Login untuk Lihat
                            </a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>

            <!-- View All Button -->
            <div class="text-center">
                @auth
                    <a href="{{ route('student.courses.index') }}"
                       class="inline-flex items-center px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold rounded-full transition-all duration-300 hover:shadow-lg">
                        Lihat Semua Kursus
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white font-bold rounded-full transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                        Daftar untuk Melihat Semua
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                @endauth
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Kursus</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Kursus akan segera tersedia. Pantau terus untuk update terbaru!
                </p>
            </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 via-pink-500 to-purple-500 animate-gradient"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIxLTEuNzktNC00LTRzLTQgMS43OS00IDQgMS43OSA0IDQgNCA0LTEuNzkgNC00em0wLTEwYzAtMi4yMS0xLjc5LTQtNC00cy00IDEuNzktNCA0IDEuNzkgNCA0IDQgNC0xLjc5IDQtNHptMTAgMTBjMC0yLjIxLTEuNzktNC00LTRzLTQgMS43OS00IDQgMS43OSA0IDQgNCA0LTEuNzkgNC00em0wLTEwYzAtMi4yMS0xLjc5LTQtNC00cy00IDEuNzktNCA0IDEuNzkgNCA0IDQgNC0xLjc5IDQtNHptMTAgMTBjMC0yLjIxLTEuNzktNC00LTRzLTQgMS43OS00IDQgMS43OSA0IDQgNCA0LTEuNzkgNC00em0wLTEwYzAtMi4yMS0xLjc5LTQtNC00cy00IDEuNzktNCA0IDEuNzkgNCA0IDQgNC0xLjc5IDQtNHoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-20"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10 animate-scale-in">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-4 sm:mb-6 px-4">
                Siap Memulai Perjalanan Belajar Anda? 🎓
            </h2>
            <p class="text-base sm:text-lg lg:text-xl text-white/90 mb-6 sm:mb-8 max-w-2xl mx-auto px-4">
                Bergabunglah dengan 50,000+ students yang telah meningkatkan skill mereka dan raih karir impian!
            </p>
            <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 justify-center px-4">
                <a href="{{ route('login') }}" class="group inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-white text-gray-900 text-sm sm:text-base font-bold rounded-full transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                    Daftar Sekarang GRATIS
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#courses" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-white/10 backdrop-blur-sm border-2 border-white text-white text-sm sm:text-base font-bold rounded-full transition-all duration-300 hover:bg-white/20">
                    Lihat Kursus
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-pink-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">LMS Platform</span>
                    </div>
                    <p class="text-gray-400">Platform pembelajaran online terpercaya untuk meningkatkan skill Anda.</p>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Platform</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-orange-500 transition">Kursus</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Instruktur</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Sertifikat</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Perusahaan</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-orange-500 transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Karir</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Legal</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-orange-500 transition">Privasi</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 LMS Platform. Made with ❤️ in Indonesia</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Counter Animation
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    if (target >= 1000) {
                        counter.textContent = Math.ceil(current / 1000) + 'K+';
                    } else {
                        counter.textContent = Math.ceil(current) + '+';
                    }
                    requestAnimationFrame(updateCounter);
                } else {
                    if (target >= 1000) {
                        counter.textContent = (target / 1000) + 'K+';
                    } else {
                        counter.textContent = target + '+';
                    }
                }
            };

            // Start animation when element is in view
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    updateCounter();
                    observer.disconnect();
                }
            });
            observer.observe(counter);
        });

        // Parallax Effect on Mouse Move
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.parallax');
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;

            cards.forEach(card => {
                const depth = card.dataset.depth || 20;
                const moveX = (mouseX - 0.5) * depth;
                const moveY = (mouseY - 0.5) * depth;
                card.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Scroll Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('[class*="animate-"]').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
