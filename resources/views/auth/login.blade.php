<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - LMS Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
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
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
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
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-fadeInLeft { animation: fadeInLeft 0.8s ease-out; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }
        .blob-animation { animation: blob 8s ease-in-out infinite; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
</head>
<body class="font-inter antialiased bg-white text-gray-900 overflow-x-hidden">

    <!-- Animated Background Blobs -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute top-20 -left-40 w-80 h-80 bg-gradient-to-br from-orange-300 to-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float blob-animation"></div>
        <div class="absolute top-40 -right-40 w-80 h-80 bg-gradient-to-br from-purple-300 to-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float blob-animation" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-40 left-1/3 w-80 h-80 bg-gradient-to-br from-yellow-300 to-orange-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float blob-animation" style="animation-delay: 4s;"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
        <div class="w-full max-w-6xl">
            <div class="grid lg:grid-cols-2 gap-0 bg-white rounded-3xl shadow-2xl overflow-hidden">

                <!-- Left Side - Hero -->
                <div class="relative bg-gradient-to-br from-orange-500 via-pink-500 to-purple-600 p-8 sm:p-12 lg:p-16 overflow-hidden animate-gradient hidden lg:block">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full blur-2xl animate-float" style="animation-delay: 2s;"></div>

                    <div class="relative z-10 h-full flex flex-col justify-between text-white">
                        <!-- Logo -->
                        <a href="/" class="flex items-center space-x-3 group animate-fadeInLeft">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold">LMS Platform</span>
                        </a>

                        <!-- Content -->
                        <div class="animate-fadeInLeft delay-100">
                            <h1 class="text-4xl lg:text-5xl font-black mb-6 leading-tight">
                                Selamat Datang Kembali! 👋
                            </h1>
                            <p class="text-lg text-white/90 mb-8 leading-relaxed">
                                Masuk untuk melanjutkan perjalanan belajar Anda dan akses ribuan kursus berkualitas tinggi.
                            </p>

                            <!-- Features -->
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-white/90 font-medium">Akses Selamanya</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-white/90 font-medium">Sertifikat Resmi</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-white/90 font-medium">Instruktur Profesional</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-6 animate-fadeInLeft delay-200">
                            <div>
                                <div class="text-3xl font-black">50K+</div>
                                <div class="text-sm text-white/80">Students</div>
                            </div>
                            <div>
                                <div class="text-3xl font-black">150+</div>
                                <div class="text-sm text-white/80">Courses</div>
                            </div>
                            <div>
                                <div class="text-3xl font-black">4.9★</div>
                                <div class="text-sm text-white/80">Rating</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Form -->
                <div class="p-8 sm:p-12 lg:p-16 animate-fadeInUp">
                    <!-- Mobile Logo -->
                    <a href="/" class="flex items-center space-x-3 mb-8 lg:hidden">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-pink-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">LMS Platform</span>
                    </a>

                    <!-- Header -->
                    <div class="mb-8">
                        <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-2">Masuk</h2>
                        <p class="text-gray-600">Masukkan email dan password Anda untuk melanjutkan</p>
                    </div>

                    <!-- Alerts -->
                    @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6 animate-fadeInUp">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6 animate-fadeInUp">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Google Login -->
                    <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 px-6 py-3.5 bg-white border-2 border-gray-200 hover:border-orange-500 hover:bg-orange-50 text-gray-700 font-semibold rounded-xl transition-all duration-300 mb-6 group">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="group-hover:text-orange-600 transition-colors">Masuk dengan Google</span>
                    </a>

                    <!-- Divider -->
                    <div class="relative flex items-center my-6">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink mx-4 text-sm text-gray-500 font-medium">atau masuk dengan email</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <!-- Login Form -->
                    <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                   placeholder="nama@email.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" id="password" required
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                   placeholder="Masukkan password Anda">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                                <span class="ml-2 text-sm text-gray-600 font-medium">Ingat saya</span>
                            </label>
                            <a href="#" class="text-sm text-orange-500 hover:text-orange-600 font-semibold transition">
                                Lupa password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full px-6 py-3.5 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-100">
                            Masuk Sekarang
                        </button>
                    </form>

                    <!-- Info -->
                    <p class="text-center text-sm text-gray-600 mt-8">
                        <span class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Belum punya akun? Login dengan Google untuk registrasi otomatis
                        </span>
                    </p>

                    <!-- Back to Home -->
                    <div class="text-center mt-6">
                        <a href="/" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
