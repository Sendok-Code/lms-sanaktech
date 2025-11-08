<x-student.master>
    <x-slot name="title">Jelajahi Kursus</x-slot>
    <x-slot name="heading">Jelajahi Kursus</x-slot>
    <x-slot name="subheading">Temukan kursus yang tepat untuk meningkatkan keterampilan Anda</x-slot>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-12">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Filter Kursus</h3>
        <form method="GET" action="{{ route('student.courses.index') }}" class="space-y-4">
            <!-- Keep search parameter if it exists -->
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                            onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->courses_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                    <select name="sort"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                            onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </div>
            </div>

            @if(request()->hasAny(['search', 'category', 'sort']))
            <div class="flex justify-end">
                <a href="{{ route('student.courses.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                    Reset Filter
                </a>
            </div>
            @endif
        </form>
    </div>

    <!-- Courses Grid Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            @if(request('search') || request('category'))
                Hasil Pencarian
            @else
                Semua Kursus
            @endif
            <span class="text-gray-500 font-normal text-lg">({{ $courses->total() }} kursus)</span>
        </h2>
    </div>

    @if($courses->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($courses as $course)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
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
                        $randomImage = $images[($course->id - 1) % count($images)];
                    @endphp
                    <img src="{{ $randomImage }}"
                         alt="{{ $course->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @endif

                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                <!-- Enrolled Badge -->
                @if(in_array($course->id, $enrolledCourseIds))
                    <div class="absolute top-3 right-3 z-10">
                        <span class="px-3 py-1.5 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Terdaftar
                        </span>
                    </div>
                @endif

                <!-- Play Button Overlay (on hover) -->
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

                <a href="{{ route('student.courses.show', $course) }}"
                   class="block w-full px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white text-center font-semibold rounded-lg transition">
                    Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $courses->withQueryString()->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 text-center py-16">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Kursus Ditemukan</h3>
        <p class="text-gray-600 mb-6">Coba ubah filter pencarian Anda atau reset filter</p>
        <a href="{{ route('student.courses.index') }}" class="inline-block px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
            Reset Filter
        </a>
    </div>
    @endif

    <style>
        /* Custom pagination styles */
        nav[role="navigation"] {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        nav[role="navigation"] a,
        nav[role="navigation"] span {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            background: white;
            border: 1px solid #E5E7EB;
            color: #6B7280;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 600;
        }

        nav[role="navigation"] a:hover {
            background: #FFF7ED;
            border-color: #F97316;
            color: #F97316;
        }

        nav[role="navigation"] span[aria-current="page"] {
            background: #F97316;
            border-color: #F97316;
            color: white;
        }

        nav[role="navigation"] span[aria-disabled="true"] {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-student.master>
