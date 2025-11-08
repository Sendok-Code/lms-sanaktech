<x-back-end.master>
    @section('content')
        <!-- Welcome Settings Management -->
        <div id="welcome-settings" class="module p-6">
            <div style="margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0.5rem;">Welcome Page Settings</div>
                <p style="color: #94a3b8; font-size: 0.875rem;">Manage content for your landing page including hero, features, stats, and contact information</p>
            </div>

            @if (session('success'))
                <div id="alert-success"
                    class="mb-4 flex items-center gap-2 rounded-lg bg-green-100 text-green-700 px-4 py-3 shadow transition-opacity duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>

                <script>
                    setTimeout(() => {
                        const el = document.getElementById('alert-success');
                        el?.classList.add('opacity-0');
                        setTimeout(() => el?.remove(), 2000);
                    }, 2000);
                </script>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 shadow">
                    <div class="font-semibold mb-2">Terdapat kesalahan:</div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.welcome-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Tabs Navigation -->
                <div style="margin-bottom: 1.5rem; border-bottom: 2px solid #334155;">
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" onclick="switchTab('hero')" class="tab-btn active" data-tab="hero">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            Hero Section
                        </button>
                        <button type="button" onclick="switchTab('search')" class="tab-btn" data-tab="search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                            Search Section
                        </button>
                        <button type="button" onclick="switchTab('stats')" class="tab-btn" data-tab="stats">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            Statistics
                        </button>
                        <button type="button" onclick="switchTab('features')" class="tab-btn" data-tab="features">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                                <polyline points="9 11 12 14 22 4"></polyline>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                            Features
                        </button>
                        <button type="button" onclick="switchTab('cta')" class="tab-btn" data-tab="cta">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            Call to Action
                        </button>
                        <button type="button" onclick="switchTab('contact')" class="tab-btn" data-tab="contact">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            Contact & Social
                        </button>
                    </div>
                </div>

                <!-- Hero Section Tab -->
                <div class="tab-content" id="hero-tab">
                    <div class="settings-grid">
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Hero Title <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}"
                                required class="form-input" placeholder="Belajar Tanpa Batas">
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Hero Subtitle <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="hero_subtitle"
                                value="{{ old('hero_subtitle', $settings->hero_subtitle) }}" required
                                class="form-input" placeholder="Platform LMS Modern">
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Hero Description</label>
                            <textarea name="hero_description" rows="4" class="form-input"
                                placeholder="Tingkatkan skill Anda dengan ribuan kursus berkualitas dari instruktur profesional...">{{ old('hero_description', $settings->hero_description) }}</textarea>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Hero Image</label>

                            @if($settings->hero_image)
                                <div style="margin-bottom: 1rem;">
                                    <img src="{{ asset($settings->hero_image) }}" alt="Current Hero Image"
                                        style="max-width: 400px; max-height: 300px; border-radius: 8px; border: 1px solid #334155;">
                                    <div style="margin-top: 0.5rem;">
                                        <small style="color: #94a3b8; font-size: 0.75rem;">Current image</small>
                                    </div>
                                </div>
                            @endif

                            <input type="file" name="hero_image" id="hero_image" accept="image/*" class="form-input"
                                style="padding: 0.5rem;">
                            <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.25rem;">
                                Recommended size: 1920x1080px | Max: 2MB | Format: JPG, PNG, WEBP
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Search Section Tab -->
                <div class="tab-content" id="search-tab" style="display: none;">
                    <div class="settings-grid">
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Search Section Title <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="search_title" value="{{ old('search_title', $settings->search_title) }}"
                                required class="form-input" placeholder="Temukan Kursus yang Tepat">
                            <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.25rem;">
                                Title displayed above the search bar
                            </small>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Search Placeholder Text <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="search_placeholder" value="{{ old('search_placeholder', $settings->search_placeholder) }}"
                                required class="form-input" placeholder="Cari kursus, topik, atau instruktur...">
                            <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.25rem;">
                                Placeholder text inside the search input field
                            </small>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <div style="padding: 1rem; background: #1e293b; border-radius: 0.5rem; border: 1px solid #334155;">
                                <div style="font-weight: 600; margin-bottom: 0.5rem; color: #f1f5f9;">Search Features:</div>
                                <ul style="list-style: disc; padding-left: 1.5rem; color: #94a3b8; font-size: 0.875rem;">
                                    <li>Search by course title</li>
                                    <li>Search by course description</li>
                                    <li>Search by category name</li>
                                    <li>Search by instructor name</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Section Tab -->
                <div class="tab-content" id="stats-tab" style="display: none;">
                    <div class="settings-grid">
                        <div class="form-group">
                            <label class="form-label">Total Students <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="stats_students"
                                value="{{ old('stats_students', $settings->stats_students) }}" required
                                placeholder="50K+" class="form-input">
                            <small style="color: #94a3b8; font-size: 0.75rem;">Format: 50K+, 100+, 1M+</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Total Courses <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="stats_courses"
                                value="{{ old('stats_courses', $settings->stats_courses) }}" required
                                placeholder="150+" class="form-input">
                            <small style="color: #94a3b8; font-size: 0.75rem;">Format: 150+, 200+, 500+</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Platform Rating <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="stats_rating"
                                value="{{ old('stats_rating', $settings->stats_rating) }}" required
                                placeholder="4.9★" class="form-input">
                            <small style="color: #94a3b8; font-size: 0.75rem;">Format: 4.9★, 5.0★</small>
                        </div>
                    </div>
                </div>

                <!-- Features Section Tab -->
                <div class="tab-content" id="features-tab" style="display: none;">
                    @for ($i = 1; $i <= 3; $i++)
                        <div style="margin-bottom: {{ $i < 3 ? '2rem' : '0' }}; padding-bottom: {{ $i < 3 ? '2rem' : '0' }}; border-bottom: {{ $i < 3 ? '1px solid #334155' : 'none' }};">
                            <h4 style="font-weight: 600; margin-bottom: 1rem; color: #f1f5f9; font-size: 1.125rem;">
                                Feature {{ $i }}
                            </h4>

                            <div class="settings-grid">
                                <div class="form-group" style="grid-column: span 2;">
                                    <label class="form-label">Title <span style="color: #ef4444;">*</span></label>
                                    <input type="text" name="feature_{{ $i }}_title"
                                        value="{{ old('feature_' . $i . '_title', $settings->{'feature_' . $i . '_title'}) }}"
                                        required class="form-input" placeholder="Belajar Fleksibel">
                                </div>

                                <div class="form-group" style="grid-column: span 2;">
                                    <label class="form-label">Description</label>
                                    <textarea name="feature_{{ $i }}_description" rows="3" class="form-input"
                                        placeholder="Akses kapan saja, dimana saja dengan berbagai perangkat. Belajar sesuai dengan kecepatan Anda sendiri.">{{ old('feature_' . $i . '_description', $settings->{'feature_' . $i . '_description'}) }}</textarea>
                                </div>

                                <div class="form-group" style="grid-column: span 2;">
                                    <label class="form-label">Icon Name <span style="color: #ef4444;">*</span></label>
                                    <input type="text" name="feature_{{ $i }}_icon"
                                        value="{{ old('feature_' . $i . '_icon', $settings->{'feature_' . $i . '_icon'}) }}"
                                        required placeholder="clock" class="form-input">
                                    <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.25rem;">
                                        Examples: clock, certificate, users, book, shield, star, award
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- CTA Section Tab -->
                <div class="tab-content" id="cta-tab" style="display: none;">
                    <div class="settings-grid">
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">CTA Title <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="cta_title" value="{{ old('cta_title', $settings->cta_title) }}"
                                required class="form-input" placeholder="Siap Memulai Perjalanan Belajar Anda?">
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">CTA Description</label>
                            <textarea name="cta_description" rows="3" class="form-input"
                                placeholder="Bergabunglah dengan ribuan pelajar yang telah meningkatkan skill mereka dan raih karir impian Anda.">{{ old('cta_description', $settings->cta_description) }}</textarea>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Button Text <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="cta_button_text"
                                value="{{ old('cta_button_text', $settings->cta_button_text) }}" required
                                class="form-input" placeholder="Mulai Sekarang">
                        </div>
                    </div>
                </div>

                <!-- Contact & Social Section Tab -->
                <div class="tab-content" id="contact-tab" style="display: none;">
                    <h4 style="font-weight: 600; margin-bottom: 1rem; color: #f1f5f9; font-size: 1.125rem;">Contact Information</h4>

                    <div class="settings-grid" style="margin-bottom: 2rem;">
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $settings->email) }}"
                                class="form-input" placeholder="info@lms-platform.com">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $settings->phone) }}"
                                class="form-input" placeholder="+62 812-3456-7890">
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address', $settings->address) }}"
                                class="form-input" placeholder="Jakarta, Indonesia">
                        </div>
                    </div>

                    <h4 style="font-weight: 600; margin-bottom: 1rem; color: #f1f5f9; font-size: 1.125rem;">Social Media Links</h4>

                    <div class="settings-grid">
                        <div class="form-group">
                            <label class="form-label">Facebook URL</label>
                            <input type="url" name="facebook_url"
                                value="{{ old('facebook_url', $settings->facebook_url) }}"
                                class="form-input" placeholder="https://facebook.com/yourpage">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Twitter URL</label>
                            <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url) }}"
                                class="form-input" placeholder="https://twitter.com/youraccount">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Instagram URL</label>
                            <input type="url" name="instagram_url"
                                value="{{ old('instagram_url', $settings->instagram_url) }}"
                                class="form-input" placeholder="https://instagram.com/youraccount">
                        </div>

                        <div class="form-group">
                            <label class="form-label">LinkedIn URL</label>
                            <input type="url" name="linkedin_url"
                                value="{{ old('linkedin_url', $settings->linkedin_url) }}"
                                class="form-input" placeholder="https://linkedin.com/company/yourcompany">
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="reset" class="btn btn-secondary">
                        Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>

        <style>
            .tab-btn {
                padding: 0.75rem 1.5rem;
                background: transparent;
                border: none;
                color: #94a3b8;
                cursor: pointer;
                transition: all 0.3s ease;
                border-bottom: 2px solid transparent;
                font-weight: 500;
            }

            .tab-btn:hover {
                color: #3b82f6;
            }

            .tab-btn.active {
                color: #3b82f6;
                border-bottom-color: #3b82f6;
            }

            .settings-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            @media (max-width: 768px) {
                .settings-grid {
                    grid-template-columns: 1fr;
                }

                .form-group[style*="grid-column: span 2"] {
                    grid-column: span 1 !important;
                }
            }
        </style>

        <script>
            function switchTab(tabName) {
                // Hide all tabs
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.style.display = 'none';
                });

                // Remove active class from all buttons
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('active');
                });

                // Show selected tab
                document.getElementById(tabName + '-tab').style.display = 'block';

                // Add active class to clicked button
                document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
            }

            // Image preview
            document.addEventListener('DOMContentLoaded', function() {
                const heroImageInput = document.getElementById('hero_image');

                if (heroImageInput) {
                    heroImageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                // Remove old preview if exists
                                const oldPreview = document.getElementById('hero-image-preview');
                                if (oldPreview) {
                                    oldPreview.remove();
                                }

                                // Create new preview
                                const previewDiv = document.createElement('div');
                                previewDiv.id = 'hero-image-preview';
                                previewDiv.style.marginTop = '1rem';
                                previewDiv.innerHTML = `
                                    <div style="margin-bottom: 0.5rem;">
                                        <small style="color: #3b82f6; font-size: 0.75rem; font-weight: 600;">New image preview:</small>
                                    </div>
                                    <img src="${e.target.result}" alt="Preview"
                                        style="max-width: 400px; max-height: 300px; border-radius: 8px; border: 2px solid #3b82f6;">
                                `;
                                heroImageInput.parentElement.appendChild(previewDiv);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }
            });
        </script>
    @endsection
</x-back-end.master>
