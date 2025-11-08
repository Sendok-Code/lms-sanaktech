<x-student.master>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="heading">Dashboard</x-slot>
    <x-slot name="subheading">Selamat datang kembali, {{ Auth::user()->name }}!</x-slot>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1 font-medium">Total Kursus</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $stats['total_courses'] }}</h3>
                </div>
                <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1 font-medium">Sedang Belajar</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $stats['in_progress'] }}</h3>
                </div>
                <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1 font-medium">Selesai</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $stats['completed_courses'] }}</h3>
                </div>
                <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1 font-medium">Sertifikat</p>
                    <h3 class="text-3xl font-black text-gray-900">{{ $stats['certificates'] }}</h3>
                </div>
                <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-12">
        <div class="bg-gradient-to-br from-orange-500 to-pink-500 rounded-xl shadow-lg p-8 text-white">
            <h2 class="text-2xl font-bold mb-3">Siap untuk Belajar?</h2>
            <p class="text-orange-50 mb-6">Jelajahi ribuan kursus atau lanjutkan pembelajaran Anda</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('student.courses.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-orange-600 font-semibold rounded-lg hover:bg-orange-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Jelajahi Kursus
                </a>
                <a href="{{ route('student.enrollments.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 text-white font-semibold rounded-lg hover:bg-white/20 border border-white/30 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Lihat Kursus Saya
                </a>
            </div>
        </div>
    </div>

    <!-- Continue Learning -->
    @if($enrollments->count() > 0)
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Lanjutkan Belajar</h2>
            <a href="{{ route('student.enrollments.index') }}" class="text-orange-500 hover:text-orange-600 text-sm font-semibold transition">
                Lihat Semua →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($enrollments as $enrollment)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-bold text-gray-900 flex-1">{{ $enrollment->course->title }}</h3>
                    @if($enrollment->progress_percentage == 100)
                        <span class="px-3 py-1 bg-green-100 text-green-600 text-xs font-semibold rounded-full">Selesai</span>
                    @elseif($enrollment->progress_percentage > 0)
                        <span class="px-3 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full">Berlangsung</span>
                    @else
                        <span class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-semibold rounded-full">Baru</span>
                    @endif
                </div>

                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                    {{ Str::limit($enrollment->course->description, 100) }}
                </p>

                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600 font-medium">Progress</span>
                        <span class="font-bold text-orange-500">{{ $enrollment->progress_percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-pink-500 h-full rounded-full transition-all" style="width: {{ $enrollment->progress_percentage }}%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $enrollment->course->instructor->user->name }}
                    </div>
                    <a href="{{ route('student.courses.learn', $enrollment->course) }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition">
                        {{ $enrollment->progress_percentage > 0 ? 'Lanjutkan' : 'Mulai Belajar' }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 text-center py-16">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Kursus</h3>
        <p class="text-gray-600 mb-6">Mulai perjalanan belajar Anda dengan mendaftar kursus pertama</p>
        <a href="{{ route('student.courses.index') }}" class="inline-block px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition">
            Jelajahi Kursus
        </a>
    </div>
    @endif

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-student.master>
