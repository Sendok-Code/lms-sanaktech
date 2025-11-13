// Video Learning Enhancement
// Auto-next video and certificate redirect

// Override loadNextVideo function
function loadNextVideo(currentVideoId) {
    const allVideos = document.querySelectorAll('.video-item');
    let foundCurrent = false;
    let nextVideo = null;

    for (let video of allVideos) {
        if (foundCurrent && !video.classList.contains('completed')) {
            nextVideo = video;
            break;
        }
        if (video.getAttribute('data-video-id') == currentVideoId) {
            foundCurrent = true;
        }
    }

    if (nextVideo) {
        // Click the next video
        nextVideo.click();
    } else {
        // All videos completed - check if all are really done
        const totalVideos = allVideos.length;
        const completedVideos = document.querySelectorAll('.video-item.completed').length;

        if (completedVideos === totalVideos && totalVideos > 0) {
            // Show congratulations modal
            showCongratulations();
        }
    }
}

// Show congratulations modal and redirect to certificate
function showCongratulations() {
    // Get certificate URL from meta tag
    const certificateUrl = document.querySelector('meta[name="certificate-url"]')?.content || '/student/dashboard';

    // Create modal overlay
    const modal = document.createElement('div');
    modal.id = 'congratulations-modal';
    modal.style.cssText = 'position: fixed; inset: 0; background: rgba(0,0,0,0.85); display: flex; align-items: center; justify-center; z-index: 9999; animation: fadeIn 0.3s ease-out;';

    modal.innerHTML = `
        <div style="background: white; border-radius: 24px; padding: 48px; max-width: 500px; width: 90%; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: scaleIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
            <!-- Success Icon -->
            <div style="width: 96px; height: 96px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);">
                <svg style="width: 56px; height: 56px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>

            <!-- Celebration Emoji -->
            <div style="font-size: 48px; margin-bottom: 8px;">🎉</div>

            <!-- Title -->
            <h2 style="font-size: 32px; font-weight: 800; color: #111827; margin-bottom: 16px; line-height: 1.2;">
                Selamat!
            </h2>

            <!-- Message -->
            <p style="font-size: 18px; color: #6b7280; margin-bottom: 8px; line-height: 1.6;">
                Anda telah menyelesaikan <strong style="color: #111827;">semua materi</strong> dalam kursus ini!
            </p>
            <p style="font-size: 16px; color: #10b981; font-weight: 600; margin-bottom: 32px;">
                Saatnya mengambil sertifikat Anda! 🎓
            </p>

            <!-- Countdown -->
            <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 12px; border-radius: 12px; margin-bottom: 24px;">
                <p style="font-size: 14px; color: #92400e; margin-bottom: 4px;">Auto-redirect dalam</p>
                <p id="countdown-timer" style="font-size: 28px; font-weight: 800; color: #78350f;">10</p>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <button onclick="window.location.href='${certificateUrl}'"
                        style="padding: 16px 32px; background: linear-gradient(135deg, #f97316, #ec4899); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4); flex: 1; min-width: 200px;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(249, 115, 22, 0.5)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(249, 115, 22, 0.4)'">
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        🎓 Dapatkan Sertifikat
                    </span>
                </button>
                <button onclick="closeCongratulationsModal()"
                        style="padding: 16px 32px; background: #f3f4f6; color: #374151; border: none; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s;"
                        onmouseover="this.style.background='#e5e7eb'"
                        onmouseout="this.style.background='#f3f4f6'">
                    Nanti Saja
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    // Countdown timer
    let countdown = 10;
    const countdownElement = document.getElementById('countdown-timer');

    const countdownInterval = setInterval(() => {
        countdown--;
        if (countdownElement) {
            countdownElement.textContent = countdown;
        }
        if (countdown <= 0) {
            clearInterval(countdownInterval);
            window.location.href = certificateUrl;
        }
    }, 1000);

    // Store interval ID for cleanup
    modal.dataset.countdownInterval = countdownInterval;
}

// Close congratulations modal
function closeCongratulationsModal() {
    const modal = document.getElementById('congratulations-modal');
    if (modal) {
        const intervalId = modal.dataset.countdownInterval;
        if (intervalId) {
            clearInterval(parseInt(intervalId));
        }
        modal.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => modal.remove(), 300);
    }
}

// Add animation styles
if (!document.getElementById('video-learning-styles')) {
    const style = document.createElement('style');
    style.id = 'video-learning-styles';
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
}

console.log('✅ Video Learning Enhancement loaded');
