<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="certificate-url" content="{{ route('student.certificates.show', $course) }}">
    <title>{{ $course->title }} - Belajar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #F97316;
            --primary-hover: #EA580C;
            --bg-main: #F9FAFB;
            --bg-card: #FFFFFF;
            --bg-hover: #F3F4F6;
            --text-primary: #111827;
            --text-secondary: #6B7280;
            --border: #E5E7EB;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-main);
            color: var(--text-primary);
            overflow: hidden;
        }

        .player-layout {
            display: grid;
            grid-template-columns: 1fr 400px;
            height: 100vh;
        }

        .video-section {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .video-header {
            padding: 1rem 1.5rem;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .video-container {
            flex: 1;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .video-wrapper {
            width: 100%;
            height: 100%;
            position: relative;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .video-player {
            width: 100%;
            height: 100%;
            pointer-events: auto;
        }

        /* Overlay to block right-click and hide YouTube UI elements */
        .video-overlay {
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 80px;
            background: transparent;
            z-index: 10;
            pointer-events: all;
            cursor: default;
        }

        .video-overlay:hover {
            background: rgba(0, 0, 0, 0.01);
        }

        .video-info {
            padding: 1.5rem;
            background: var(--bg-card);
            border-top: 1px solid var(--border);
        }

        .sidebar-section {
            background: var(--bg-card);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
        }

        .module-item {
            border-bottom: 1px solid var(--border);
        }

        .module-header {
            padding: 1rem 1.5rem;
            background: var(--bg-hover);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: between;
            transition: all 0.2s;
        }

        .module-header:hover {
            background: #475569;
        }

        .video-item {
            padding: 0.875rem 1.5rem 0.875rem 2.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .video-item:hover {
            background: var(--bg-hover);
        }

        .video-item.active {
            background: var(--bg-hover);
            border-left-color: var(--primary);
        }

        .video-item.completed {
            opacity: 0.7;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .progress-bar {
            height: 4px;
            background: #E5E7EB;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), #EC4899);
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        @media (max-width: 1024px) {
            .player-layout {
                grid-template-columns: 1fr;
                grid-template-rows: 1fr auto;
            }

            .sidebar-section {
                max-height: 40vh;
                border-left: none;
                border-top: 1px solid var(--border);
            }
        }

        /* Scrollbar styling */
        .sidebar-content::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: var(--bg-main);
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: var(--bg-hover);
            border-radius: 4px;
        }

        .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    </style>
</head>
<body>
    <div class="player-layout">
        <!-- Video Section -->
        <div class="video-section">
            <!-- Header -->
            <div class="video-header">
                <div class="flex items-center gap-4">
                    <a href="{{ route('student.courses.show', $course) }}" class="text-gray-500 hover:text-orange-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">{{ $course->title }}</h1>
                        <p class="text-sm text-gray-600">{{ $course->instructor->user->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-600 font-medium">Progress Kursus</p>
                        <p class="text-lg font-bold text-orange-500" id="course-progress">0%</p>
                    </div>
                </div>
            </div>

            <!-- Video Player -->
            <div class="video-container">
                @if($currentVideo)
                    @php
                        $url = $currentVideo->video_url;
                        // Convert to embed URL with youtube-nocookie.com for privacy
                        $url = str_replace('youtube.com/watch?v=', 'youtube-nocookie.com/embed/', $url);
                        $url = str_replace('www.youtube.com', 'www.youtube-nocookie.com', $url);
                        $url = str_replace('youtube.com/embed/', 'youtube-nocookie.com/embed/', $url);
                        $url = str_replace('youtu.be/', 'youtube-nocookie.com/embed/', $url);

                        // Add parameters to minimize branding and prevent external links
                        $separator = strpos($url, '?') !== false ? '&' : '?';
                        $url .= $separator . 'rel=0&modestbranding=1&showinfo=0&fs=1&controls=1&disablekb=1&iv_load_policy=3';
                    @endphp
                    <div class="video-wrapper" oncontextmenu="return false;">
                        <iframe
                            id="video-player"
                            class="video-player"
                            src="{{ $url }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                        <!-- Overlay to block YouTube share button and right-click -->
                        <div class="video-overlay" oncontextmenu="return false;"></div>
                    </div>
                @else
                    <div class="text-center text-gray-500">
                        <svg class="w-24 h-24 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Tidak ada video tersedia</p>
                    </div>
                @endif
            </div>

            <!-- Video Info -->
            @if($currentVideo)
            <div class="video-info">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-bold mb-2">{{ $currentVideo->title }}</h2>
                    </div>
                    <button onclick="handleNext()"
                            id="next-btn"
                            class="btn btn-primary">
                        <span id="btn-text">Lanjutkan</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </div>

                <!-- Progress Bar -->
                <div class="progress-bar">
                    <div class="progress-fill" id="video-progress" style="width: 0%"></div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar: Playlist -->
        <div class="sidebar-section">
            <div class="sidebar-header">
                <h3 class="font-bold text-lg mb-2">Daftar Materi</h3>
                <div class="progress-bar">
                    <div class="progress-fill" id="sidebar-progress" style="width: 0%"></div>
                </div>
            </div>

            <div class="sidebar-content">
                @foreach($course->modules as $module)
                <div class="module-item">
                    <div class="module-header" onclick="toggleModule({{ $module->id }})">
                        <div class="flex items-center gap-3 flex-1">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="font-semibold text-gray-900">{{ $module->title }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600 font-medium" id="module-count-{{ $module->id }}">
                                0/{{ $module->videos->count() }}
                            </span>
                            <svg id="arrow-{{ $module->id }}" class="w-5 h-5 transform transition-transform text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <div id="module-{{ $module->id }}">
                        @foreach($module->videos as $video)
                        <div class="video-item {{ $currentVideo && $currentVideo->id == $video->id ? 'active' : '' }} {{ isset($progress[$video->id]) && $progress[$video->id]->completed ? 'completed' : '' }}"
                             data-video-id="{{ $video->id }}"
                             data-video-url="{{ $video->video_url }}"
                             data-video-title="{{ $video->title }}"
                             data-video-duration="{{ $video->duration_seconds ?? 0 }}"
                             onclick="loadVideo({{ $video->id }}, '{{ $video->video_url }}', '{{ addslashes($video->title) }}', {{ $video->duration_seconds ?? 0 }})">
                            <div class="flex-shrink-0">
                                @if(isset($progress[$video->id]) && $progress[$video->id]->completed)
                                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm">{{ $video->title }}</p>
                                @if($video->duration_seconds)
                                <p class="text-xs text-gray-500">{{ gmdate('i:s', $video->duration_seconds) }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <!-- Resource File Download (if available) -->
                @if($course->resource_file && $course->resource_file_name)
                <div class="module-item" style="border-top: 2px solid var(--primary);">
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); border-radius: 12px; display: flex; align-items: center; justify-center;">
                                <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                            </div>
                            <div style="flex: 1;">
                                <h4 style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem;">Materi Tambahan</h4>
                                <p style="font-size: 0.875rem; color: var(--text-secondary);">File resource untuk kursus ini</p>
                            </div>
                        </div>

                        <div style="padding: 1rem; background: var(--bg-hover); border-radius: 8px; margin-bottom: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <svg style="width: 20px; height: 20px; color: var(--primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span style="font-size: 0.875rem; font-weight: 600; color: var(--text-primary);">{{ $course->resource_file_name }}</span>
                            </div>
                            <p style="font-size: 0.75rem; color: var(--text-secondary);">
                                <svg style="width: 14px; height: 14px; display: inline-block; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                File materi dapat didownload setelah Anda mendaftar di kursus ini
                            </p>
                        </div>

                        <a href="{{ asset('storage/' . $course->resource_file) }}" download="{{ $course->resource_file_name }}"
                           style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; padding: 0.875rem; background: var(--primary); color: white; font-weight: 600; font-size: 0.875rem; border-radius: 8px; text-decoration: none; transition: all 0.3s ease;"
                           onmouseover="this.style.background='var(--primary-hover)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(249, 115, 22, 0.3)'"
                           onmouseout="this.style.background='var(--primary)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download Materi
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        let currentVideoId = {{ $currentVideo ? $currentVideo->id : 'null' }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Toggle module visibility
        function toggleModule(moduleId) {
            const content = document.getElementById('module-' + moduleId);
            const arrow = document.getElementById('arrow-' + moduleId);

            if (content) {
                content.classList.toggle('hidden');
            } else {
                console.warn('Module content not found for ID:', moduleId);
            }

            if (arrow) {
                arrow.classList.toggle('rotate-180');
            } else {
                console.warn('Module arrow not found for ID:', moduleId);
            }
        }

        // Load video
        function loadVideo(videoId, videoUrl, videoTitle, duration) {
            currentVideoId = videoId;

            // Convert to youtube-nocookie.com embed URL
            let embedUrl = videoUrl;
            embedUrl = embedUrl.replace('youtube.com/watch?v=', 'youtube-nocookie.com/embed/');
            embedUrl = embedUrl.replace('www.youtube.com', 'www.youtube-nocookie.com');
            embedUrl = embedUrl.replace('youtube.com/embed/', 'youtube-nocookie.com/embed/');
            embedUrl = embedUrl.replace('youtu.be/', 'youtube-nocookie.com/embed/');

            // Add parameters to minimize branding and prevent external links
            const separator = embedUrl.includes('?') ? '&' : '?';
            embedUrl += separator + 'rel=0&modestbranding=1&showinfo=0&fs=1&controls=1&disablekb=1&iv_load_policy=3';

            // Update video player
            const videoPlayer = document.getElementById('video-player');
            if (videoPlayer) {
                videoPlayer.src = embedUrl;
            }

            // Update active state
            document.querySelectorAll('.video-item').forEach(item => item.classList.remove('active'));
            const videoItem = document.querySelector(`[data-video-id="${videoId}"]`);
            if (videoItem) {
                videoItem.classList.add('active');
            }

            // Update title
            const titleElement = document.querySelector('.video-info h2');
            if (titleElement) {
                titleElement.textContent = videoTitle;
            }

            // Update button text based on whether there's a next video
            updateNextButton(videoId);
        }

        // Update next button text
        function updateNextButton(videoId) {
            const allVideos = Array.from(document.querySelectorAll('.video-item'));
            const currentIndex = allVideos.findIndex(v => v.dataset.videoId == videoId);
            const btnText = document.getElementById('btn-text');

            if (!btnText) {
                console.warn('Button text element not found when updating button');
                return;
            }

            // Check if this is the last video
            if (currentIndex === allVideos.length - 1) {
                btnText.textContent = 'Selesai & Lihat Sertifikat';
            } else {
                btnText.textContent = 'Lanjutkan';
            }
        }

        // Handle next button click
        function handleNext() {
            const btn = document.getElementById('next-btn');
            const btnText = document.getElementById('btn-text');

            if (!btn || !btnText) {
                console.error('Button elements not found!', {btn, btnText});
                alert('Error: Button tidak ditemukan. Silakan refresh halaman.');
                return;
            }

            const originalText = btnText.textContent;

            btn.disabled = true;
            btnText.textContent = 'Memproses...';

            console.log('=== DEBUG INFO ===');
            console.log('Current video ID:', currentVideoId);
            console.log('CSRF Token:', csrfToken);
            console.log('Request URL:', `/student/progress/${currentVideoId}`);

            // Mark current video as complete
            fetch(`/student/progress/${currentVideoId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    completed: true,
                    watched_seconds: 0
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);

                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Response error text:', text);
                        throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);

                if (data.success) {
                    // Update icon to green checkmark
                    const videoItem = document.querySelector(`[data-video-id="${currentVideoId}"]`);
                    if (videoItem) {
                        videoItem.classList.add('completed');
                        const icon = videoItem.querySelector('svg');
                        if (icon) {
                            icon.outerHTML = `<svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                        }
                    }

                    // Update progress
                    updateProgress();

                    // Find next video
                    const allVideos = Array.from(document.querySelectorAll('.video-item'));
                    const currentIndex = allVideos.findIndex(v => v.dataset.videoId == currentVideoId);

                    console.log('Current index:', currentIndex, 'Total videos:', allVideos.length);

                    if (currentIndex < allVideos.length - 1) {
                        // Load next video
                        const nextVideo = allVideos[currentIndex + 1];
                        setTimeout(() => {
                            loadVideo(
                                parseInt(nextVideo.dataset.videoId),
                                nextVideo.dataset.videoUrl,
                                nextVideo.dataset.videoTitle,
                                parseInt(nextVideo.dataset.videoDuration)
                            );
                            btn.disabled = false;
                            btnText.textContent = originalText;
                        }, 300);
                    } else {
                        // Last video - redirect to certificate
                        console.log('Last video completed, redirecting to certificate...');
                        const certificateUrl = document.querySelector('meta[name="certificate-url"]')?.content;
                        console.log('Certificate URL:', certificateUrl);

                        if (certificateUrl) {
                            btnText.textContent = 'Menuju Sertifikat...';
                            setTimeout(() => {
                                window.location.href = certificateUrl;
                            }, 1000);
                        } else {
                            console.error('Certificate URL not found!');
                            alert('Error: URL sertifikat tidak ditemukan. Silakan refresh halaman.');
                            btn.disabled = false;
                            btnText.textContent = originalText;
                        }
                    }
                } else {
                    console.error('Failed to mark video as complete:', data);
                    alert('Gagal menandai video sebagai selesai: ' + (data.error || 'Unknown error'));
                    btn.disabled = false;
                    btnText.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Catch error:', error);
                console.error('Error message:', error.message);
                console.error('Error stack:', error.stack);
                alert('Terjadi kesalahan: ' + error.message);
                btn.disabled = false;
                btnText.textContent = originalText;
            });
        }



        // Update overall progress
        function updateProgress() {
            const totalVideos = document.querySelectorAll('.video-item').length;
            const completedVideos = document.querySelectorAll('.video-item.completed').length;
            const percentage = Math.round((completedVideos / totalVideos) * 100);

            const courseProgressEl = document.getElementById('course-progress');
            const sidebarProgressEl = document.getElementById('sidebar-progress');

            if (courseProgressEl) {
                courseProgressEl.textContent = percentage + '%';
            }

            if (sidebarProgressEl) {
                sidebarProgressEl.style.width = percentage + '%';
            }

            // Update module counts
            document.querySelectorAll('.module-item').forEach(module => {
                const moduleContentDiv = module.querySelector('[id^="module-"]');
                if (!moduleContentDiv) {
                    console.warn('Module content div not found for module:', module);
                    return;
                }

                const moduleId = moduleContentDiv.id.replace('module-', '');
                const moduleVideos = module.querySelectorAll('.video-item');
                const moduleCompleted = module.querySelectorAll('.video-item.completed').length;

                const moduleCountEl = document.getElementById('module-count-' + moduleId);
                if (moduleCountEl) {
                    moduleCountEl.textContent = moduleCompleted + '/' + moduleVideos.length;
                } else {
                    console.warn('Module count element not found for module ID:', moduleId);
                }
            });
        }

        // Disable right-click and keyboard shortcuts on video
        function protectVideo() {
            const videoContainer = document.querySelector('.video-container');
            const videoWrapper = document.querySelector('.video-wrapper');
            const videoOverlay = document.querySelector('.video-overlay');

            // Disable right-click on entire video container
            if (videoContainer) {
                videoContainer.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }, true);
            }

            if (videoWrapper) {
                videoWrapper.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }, true);

                // Disable drag
                videoWrapper.addEventListener('dragstart', function(e) {
                    e.preventDefault();
                    return false;
                });

                // Disable selection
                videoWrapper.addEventListener('selectstart', function(e) {
                    e.preventDefault();
                    return false;
                });
            }

            if (videoOverlay) {
                videoOverlay.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }, true);
            }

            // Disable keyboard shortcuts globally when focused on video area
            document.addEventListener('keydown', function(e) {
                const target = e.target;
                const inVideoArea = target.closest('.video-container');

                if (inVideoArea) {
                    // Disable dev tools shortcuts
                    if (
                        (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i')) ||
                        (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c')) ||
                        (e.ctrlKey && e.shiftKey && (e.key === 'J' || e.key === 'j')) ||
                        (e.ctrlKey && (e.key === 'u' || e.key === 'U')) ||
                        (e.key === 'F12')
                    ) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                }
            }, true);

            // Disable right-click on document level for extra protection
            document.addEventListener('contextmenu', function(e) {
                if (e.target.closest('.video-container') || e.target.closest('.video-wrapper')) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            }, true);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Open first module by default
            const firstModule = document.querySelector('.module-item');
            if (firstModule) {
                const moduleId = firstModule.querySelector('[id^="module-"]').id.replace('module-', '');
                toggleModule(moduleId);
            }

            // Update initial progress
            updateProgress();

            // Update button text for current video
            if (currentVideoId) {
                updateNextButton(currentVideoId);
            }

            // Protect video from copying
            protectVideo();
        });
    </script>
</body>
</html>
