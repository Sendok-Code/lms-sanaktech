<x-student.master>
    <x-slot name="title">Kursus Saya</x-slot>
    <x-slot name="heading">Kursus Saya</x-slot>
    <x-slot name="subheading">Kelola dan lanjutkan pembelajaran Anda</x-slot>

    @if($enrollments->count() > 0)
    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-3 mb-8">
        <button onclick="filterCourses('all')" class="filter-tab active" data-filter="all">
            Semua ({{ $enrollments->count() }})
        </button>
        <button onclick="filterCourses('in-progress')" class="filter-tab" data-filter="in-progress">
            Sedang Belajar ({{ $enrollments->where('progress_percentage', '>', 0)->where('progress_percentage', '<', 100)->count() }})
        </button>
        <button onclick="filterCourses('completed')" class="filter-tab" data-filter="completed">
            Selesai ({{ $enrollments->where('progress_percentage', 100)->count() }})
        </button>
        <button onclick="filterCourses('not-started')" class="filter-tab" data-filter="not-started">
            Belum Dimulai ({{ $enrollments->where('progress_percentage', 0)->count() }})
        </button>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($enrollments as $enrollment)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all course-card
                    {{ $enrollment->progress_percentage == 100 ? 'completed' : '' }}
                    {{ $enrollment->progress_percentage > 0 && $enrollment->progress_percentage < 100 ? 'in-progress' : '' }}
                    {{ $enrollment->progress_percentage == 0 ? 'not-started' : '' }}">

            <!-- Course Image -->
            <div class="relative h-52 overflow-hidden cursor-pointer group"
                 onclick="window.location.href='{{ route('student.courses.learn', $enrollment->course) }}'">
                @php
                    $images = [
                        'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=80',
                        'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=500&auto=format&fit=crop&q=80',
                        'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=500&auto=format&fit=crop&q=80',
                        'https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?w=500&auto=format&fit=crop&q=80',
                        'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=500&auto=format&fit=crop&q=80',
                        'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=500&auto=format&fit=crop&q=80',
                    ];
                    $randomImage = $images[($enrollment->course->id - 1) % count($images)];
                @endphp
                <img src="{{ $randomImage }}"
                     alt="{{ $enrollment->course->title }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>

                <!-- Play Button Overlay -->
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center shadow-xl transform scale-75 group-hover:scale-100 transition-transform duration-300">
                        <svg class="w-8 h-8 text-orange-500 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="absolute top-3 right-3 z-20">
                    @if($enrollment->progress_percentage == 100)
                        <span class="px-3 py-1.5 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Selesai
                        </span>
                    @elseif($enrollment->progress_percentage > 0)
                        <span class="px-3 py-1.5 bg-blue-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1">
                            <svg class="w-3 h-3 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                            </svg>
                            Berlangsung
                        </span>
                    @else
                        <span class="px-3 py-1.5 bg-orange-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                            </svg>
                            Baru
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-5">
                <!-- Course Info -->
                <div class="mb-3">
                    <span class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-semibold rounded-full">{{ $enrollment->course->category->name ?? 'Umum' }}</span>
                </div>

                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                    {{ $enrollment->course->title }}
                </h3>

                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                    {{ Str::limit($enrollment->course->description, 100) }}
                </p>

                <!-- Instructor -->
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-medium">{{ $enrollment->course->instructor->user->name }}</span>
                </div>

                <!-- Progress -->
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600 font-medium">Progress</span>
                        <span class="font-bold {{ $enrollment->progress_percentage == 100 ? 'text-green-500' : 'text-orange-500' }}">
                            {{ $enrollment->progress_percentage }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-pink-500 h-full rounded-full transition-all" style="width: {{ $enrollment->progress_percentage }}%"></div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 mb-4">
                    <a href="{{ route('student.courses.learn', $enrollment->course) }}"
                       class="flex-1 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-center font-semibold rounded-lg transition text-sm">
                        @if($enrollment->progress_percentage > 0)
                            Lanjutkan
                        @else
                            Mulai Belajar
                        @endif
                    </a>
                    <a href="{{ route('student.courses.show', $enrollment->course) }}"
                       class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </a>
                </div>

                <!-- Enrollment Date -->
                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 font-medium">
                        Terdaftar {{ $enrollment->enrolled_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 text-center py-16">
        <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Kursus</h3>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Mulai perjalanan belajar Anda dengan mendaftar kursus pertama. Ratusan kursus berkualitas menunggu Anda!
        </p>
        <a href="{{ route('student.courses.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Jelajahi Kursus
        </a>
    </div>
    @endif

    <style>
        .filter-tab {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            background: white;
            border: 1px solid #E5E7EB;
            color: #6B7280;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 600;
        }

        .filter-tab:hover {
            background: #FFF7ED;
            border-color: #F97316;
            color: #F97316;
        }

        .filter-tab.active {
            background: #F97316;
            border-color: #F97316;
            color: white;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
        function filterCourses(filter) {
            // Update active tab
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelector(`[data-filter="${filter}"]`).classList.add('active');

            // Filter courses
            document.querySelectorAll('.course-card').forEach(card => {
                if (filter === 'all' || card.classList.contains(filter)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</x-student.master>
