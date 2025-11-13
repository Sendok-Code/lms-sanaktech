<x-student.master>
    <x-slot name="title">Sertifikat - {{ $course->title }}</x-slot>
    <x-slot name="heading">🎉 Selamat!</x-slot>
    <x-slot name="subheading">
        Anda telah berhasil menyelesaikan kursus <strong class="text-orange-600">{{ $course->title }}</strong>
    </x-slot>

@push('head')
<!-- Open Graph Meta Tags for Facebook -->
<meta property="og:title" content="🎓 Saya telah menyelesaikan {{ $course->title }}!">
<meta property="og:description" content="Bangga telah menyelesaikan kursus {{ $course->title }} di {{ config('app.name') }}. Sertifikat No: {{ $certificate->certificate_number }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@if($course->thumbnail)
<meta property="og:image" content="{{ asset('storage/' . $course->thumbnail) }}">
@endif

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="🎓 Saya telah menyelesaikan {{ $course->title }}!">
<meta name="twitter:description" content="Bangga telah menyelesaikan kursus {{ $course->title }} di {{ config('app.name') }}">
@if($course->thumbnail)
<meta name="twitter:image" content="{{ asset('storage/' . $course->thumbnail) }}">
@endif
@endpush

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

    @keyframes confetti {
        0% { transform: translateY(-100vh) rotate(0deg); }
        100% { transform: translateY(100vh) rotate(720deg); }
    }

    @keyframes glow {
        0%, 100% { box-shadow: 0 0 20px rgba(249, 115, 22, 0.4), 0 0 40px rgba(249, 115, 22, 0.2); }
        50% { box-shadow: 0 0 30px rgba(249, 115, 22, 0.6), 0 0 60px rgba(249, 115, 22, 0.3); }
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    .certificate-glow {
        animation: glow 2s ease-in-out infinite;
    }

    .confetti {
        position: fixed;
        width: 10px;
        height: 10px;
        top: -10px;
        z-index: 9999;
        animation: confetti 3s linear infinite;
    }
</style>

<!-- Confetti Effect -->
<div id="confetti-container"></div>

<!-- Main Certificate Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden certificate-glow fade-in-up" style="animation-delay: 0.2s;">
            <!-- Decorative Top Border -->
            <div class="h-2 bg-gradient-to-r from-orange-500 via-pink-500 to-purple-500"></div>

            <!-- Certificate Content -->
            <div class="p-8 md:p-12">
                <!-- Course Title & Badge -->
                <div class="flex items-start gap-6 mb-8">
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 bg-gradient-to-br from-orange-400 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 transition-transform">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ $course->title }}</h2>
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nomor Sertifikat</p>
                                    <p class="text-base font-bold text-gray-900">{{ $certificate->certificate_number }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Diterbitkan</p>
                                    <p class="text-base font-bold text-gray-900">{{ $certificate->issued_at->format('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Achievement Stats -->
                <div class="grid grid-cols-3 gap-4 mb-8 p-6 bg-gradient-to-r from-orange-50 to-pink-50 rounded-2xl">
                    <div class="text-center">
                        <div class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-pink-600 bg-clip-text text-transparent">
                            {{ $course->videos->count() }}
                        </div>
                        <div class="text-sm text-gray-600 mt-1">Video Selesai</div>
                    </div>
                    <div class="text-center border-x border-orange-200">
                        <div class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                            100%
                        </div>
                        <div class="text-sm text-gray-600 mt-1">Progres</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-orange-600 bg-clip-text text-transparent">
                            🏆
                        </div>
                        <div class="text-sm text-gray-600 mt-1">Sertifikat</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid md:grid-cols-3 gap-4 mb-8">
                    <a href="{{ route('student.certificates.download', $course) }}"
                       class="group relative overflow-hidden px-6 py-4 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-2xl hover:scale-105 flex items-center justify-center gap-2">
                        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span>Download PDF</span>
                    </a>

                    <a href="{{ route('student.certificates.preview', $course) }}"
                       target="_blank"
                       class="group px-6 py-4 bg-white border-2 border-orange-500 text-orange-600 hover:bg-orange-500 hover:text-white font-bold rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Preview</span>
                    </a>

                    <a href="{{ route('student.courses.show', $course) }}"
                       class="group px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>

                <!-- Share Section -->
                <div class="pt-8 border-t-2 border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span>🌟</span>
                        <span>Bagikan Pencapaian Anda</span>
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        <button onclick="shareToFacebook()"
                           class="group flex-1 min-w-[140px] px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </button>

                        <button onclick="shareToTwitter()"
                           class="group flex-1 min-w-[140px] px-5 py-3 bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter
                        </button>

                        <button onclick="shareToLinkedIn()"
                           class="group flex-1 min-w-[140px] px-5 py-3 bg-blue-700 hover:bg-blue-800 text-white font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </button>

                        <button onclick="shareToWhatsApp()"
                           class="group flex-1 min-w-[140px] px-5 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            WhatsApp
                        </button>

                        <button onclick="copyLink()" id="copyBtn"
                           class="group flex-1 min-w-[140px] px-5 py-3 bg-gray-700 hover:bg-gray-800 text-white font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <span id="copyText">Copy Link</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

<!-- Motivational Quote -->
<div class="mt-8 text-center fade-in-up" style="animation-delay: 0.4s;">
    <p class="text-lg text-gray-600 italic">"Setiap pencapaian dimulai dengan keputusan untuk mencoba"</p>
    <p class="text-sm text-gray-400 mt-2">Terus belajar dan berkembang! 🚀</p>
</div>

<script>
    // Share data
    const shareData = {
        title: '🎓 Saya telah menyelesaikan {{ $course->title }}!',
        text: 'Bangga telah menyelesaikan kursus "{{ $course->title }}" di {{ config('app.name') }}. Sertifikat No: {{ $certificate->certificate_number }}',
        url: '{{ url()->current() }}'
    };

    // Facebook Share
    function shareToFacebook() {
        const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareData.url)}&quote=${encodeURIComponent(shareData.text)}`;
        window.open(url, 'facebook-share', 'width=580,height=400');
    }

    // Twitter Share
    function shareToTwitter() {
        const text = `${shareData.title}\n\n${shareData.text}\n\n`;
        const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(shareData.url)}`;
        window.open(url, 'twitter-share', 'width=550,height=420');
    }

    // LinkedIn Share
    function shareToLinkedIn() {
        const url = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareData.url)}`;
        window.open(url, 'linkedin-share', 'width=550,height=470');
    }

    // WhatsApp Share
    function shareToWhatsApp() {
        const text = `${shareData.title}\n\n${shareData.text}\n\n${shareData.url}`;
        const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
        window.open(url, 'whatsapp-share');
    }

    // Copy Link
    async function copyLink() {
        try {
            await navigator.clipboard.writeText(shareData.url);
            const btn = document.getElementById('copyBtn');
            const text = document.getElementById('copyText');

            text.textContent = '✓ Copied!';
            btn.classList.add('bg-green-600', 'hover:bg-green-700');
            btn.classList.remove('bg-gray-700', 'hover:bg-gray-800');

            setTimeout(() => {
                text.textContent = 'Copy Link';
                btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                btn.classList.add('bg-gray-700', 'hover:bg-gray-800');
            }, 2000);
        } catch (err) {
            alert('Gagal menyalin link. Silakan copy manual: ' + shareData.url);
        }
    }

    // Generate confetti on page load
    window.addEventListener('load', function() {
        const container = document.getElementById('confetti-container');
        const colors = ['#F97316', '#EC4899', '#8B5CF6', '#3B82F6', '#10B981'];

        for (let i = 0; i < 50; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 3 + 's';
            confetti.style.animationDuration = (Math.random() * 2 + 3) + 's';
            container.appendChild(confetti);

            // Remove after animation
            setTimeout(() => confetti.remove(), 6000);
        }
    });
</script>
</x-student.master>
