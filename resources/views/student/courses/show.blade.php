<x-student.master>
    <x-slot name="title">{{ $course->title }}</x-slot>
    <x-slot name="heading">Detail Kursus</x-slot>
    <x-slot name="subheading">
        <a href="{{ route('student.courses.index') }}" class="text-orange-500 hover:text-orange-600 font-semibold transition">
            ← Kembali ke Daftar Kursus
        </a>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Course Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <!-- Course Preview Video or Thumbnail -->
                <div class="mb-6 rounded-xl overflow-hidden">
                    @if($course->preview_video_url && $course->youtube_embed_url)
                        <!-- YouTube Preview Video -->
                        <div class="relative" style="padding-bottom: 56.25%; height: 0;">
                            <iframe
                                src="{{ $course->youtube_embed_url }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                class="absolute top-0 left-0 w-full h-full rounded-xl"
                                style="border-radius: 0.75rem;">
                            </iframe>
                        </div>
                        <p class="mt-3 text-sm text-gray-600 font-medium">
                            <svg class="w-4 h-4 inline-block text-orange-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            Tonton video preview sebelum membeli
                        </p>
                    @elseif($course->thumbnail)
                        <!-- Course Thumbnail -->
                        <img src="{{ asset('storage/' . $course->thumbnail) }}"
                             alt="{{ $course->title }}"
                             class="w-full h-64 object-cover rounded-xl">
                    @else
                        <!-- Fallback Placeholder -->
                        <div class="h-64 bg-gradient-to-br from-orange-400 via-pink-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-24 h-24 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <span class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-sm font-semibold rounded-full">{{ $course->category->name ?? 'Umum' }}</span>
                </div>

                <h1 class="text-3xl font-black text-gray-900 mb-4">{{ $course->title }}</h1>

                <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600 mb-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-medium">{{ $course->instructor->user->name ?? 'Instructor' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <span class="font-medium">{{ number_format($averageRating, 1) }} ({{ $totalReviews }} ulasan)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="font-medium">{{ $course->enrollments->count() }} siswa</span>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>
                </div>
            </div>

            <!-- Course Curriculum -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kurikulum Kursus</h2>

                @if($course->modules->count() > 0)
                <div class="space-y-3">
                    @foreach($course->modules as $module)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button onclick="toggleModule({{ $module->id }})"
                                class="w-full px-5 py-4 bg-gray-50 hover:bg-gray-100 flex items-center justify-between transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="font-semibold text-gray-900 text-left">{{ $module->title }}</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-sm text-gray-600 font-medium">{{ $module->videos->count() }} video</span>
                                <svg id="arrow-{{ $module->id }}" class="w-5 h-5 transform transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        <div id="module-{{ $module->id }}" class="hidden bg-white">
                            @foreach($module->videos as $video)
                            <div class="px-5 py-3 border-t border-gray-100 hover:bg-gray-50 transition-colors flex items-center gap-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-700 text-sm flex-1">{{ $video->title }}</span>
                                @if($video->duration_seconds)
                                <span class="text-xs text-gray-500 font-medium">{{ gmdate('i:s', $video->duration_seconds) }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <p>Belum ada modul untuk kursus ini</p>
                </div>
                @endif
            </div>

            <!-- Reviews Section -->
            @if($course->reviews->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Siswa</h2>
                <div class="space-y-5">
                    @foreach($course->reviews->take(5) as $review)
                    <div class="border-b border-gray-100 pb-5 last:border-0 last:pb-0">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-pink-500 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $review->user->name }}</h4>
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 sticky top-24">
                <div class="text-center mb-6 pb-6 border-b border-gray-200">
                    <div class="text-4xl font-black text-orange-500 mb-2">
                        Rp {{ number_format($course->price, 0, ',', '.') }}
                    </div>
                    <p class="text-gray-600 text-sm font-medium">Akses selamanya</p>
                </div>

                @if($isEnrolled)
                    <a href="{{ route('student.courses.learn', $course) }}" class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Lanjutkan Belajar
                    </a>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-center text-sm font-medium">
                        ✓ Anda sudah terdaftar di kursus ini
                    </div>
                @else
                    <a href="{{ route('payments.checkout', $course->id) }}" class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Daftar Sekarang
                    </a>
                @endif

                <div class="space-y-4 pt-6 border-t border-gray-200">
                    <h3 class="font-bold text-gray-900 mb-4">Yang Anda Dapatkan:</h3>
                    <div class="flex items-start gap-3 text-sm">
                        <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-700 font-medium">{{ $totalVideos }} video pembelajaran</span>
                    </div>
                    <div class="flex items-start gap-3 text-sm">
                        <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700 font-medium">{{ gmdate('H:i', $totalDuration) }} total durasi</span>
                    </div>
                    <div class="flex items-start gap-3 text-sm">
                        <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="text-gray-700 font-medium">Akses selamanya</span>
                    </div>
                    <div class="flex items-start gap-3 text-sm">
                        <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        <span class="text-gray-700 font-medium">Sertifikat penyelesaian</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleModule(moduleId) {
            const content = document.getElementById('module-' + moduleId);
            const arrow = document.getElementById('arrow-' + moduleId);

            content.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    </script>
</x-student.master>
