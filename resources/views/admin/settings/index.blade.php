<x-back-end.master>
    @section('content')
        <!-- Site Settings Management -->
        <div id="settings" class="module p-6">
            <div style="margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0.5rem;">Pengaturan Website</div>
                <p style="color: #94a3b8; font-size: 0.875rem;">Kelola logo, nama, dan deskripsi website LMS Anda</p>
            </div>

            @if (session('success'))
                <div id="alert-success"
                    class="mb-4 flex items-center gap-2 rounded-lg bg-green-100 text-green-700 px-4 py-3 shadow transition-opacity duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

            @if (session('error'))
                <div id="alert-error"
                    class="mb-4 flex items-center gap-2 rounded-lg bg-red-100 text-red-700 px-4 py-3 shadow transition-opacity duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>

                <script>
                    setTimeout(() => {
                        const el = document.getElementById('alert-error');
                        el?.classList.add('opacity-0');
                        setTimeout(() => el?.remove(), 2000);
                    }, 5000);
                </script>
            @endif

            @if ($errors->any())
                <div id="alert-validation"
                    class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 shadow">
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <strong>Terjadi kesalahan validasi:</strong>
                    </div>
                    <ul style="list-style: disc; margin-left: 2rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Debug Info -->
            <div style="background: #1e293b; padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem; border: 1px solid #334155;">
                <strong>Debug Info:</strong><br>
                Form Action: {{ route('admin.settings.update') }}<br>
                CSRF Token: {{ csrf_token() }}<br>
                Method: PUT<br><br>

                <!-- Test Button -->
                <button onclick="alert('Button WORKS! Now try the form submit button.'); return false;"
                        style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 8px; cursor: pointer; margin-top: 10px;">
                    🧪 TEST BUTTON - Click Me First!
                </button>

                <p style="color: #94a3b8; font-size: 0.875rem; margin-top: 10px;">
                    Klik test button di atas dulu. Jika muncul alert, berarti button berfungsi normal.
                </p>
            </div>

            <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="settings-container">
                    <!-- Logo Section -->
                    <div class="settings-card">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 style="font-weight: 600; color: #f1f5f9; font-size: 1.125rem;">Logo Website</h3>
                                <p style="color: #94a3b8; font-size: 0.875rem;">Upload logo untuk brand identity website Anda</p>
                            </div>
                        </div>

                        <!-- Current Logo Preview -->
                        @if($settings['site_logo'])
                            <div style="margin-bottom: 1rem; padding: 1rem; background: #1e293b; border-radius: 0.5rem; border: 1px solid #334155;">
                                <label style="display: block; color: #94a3b8; font-size: 0.875rem; margin-bottom: 0.5rem;">Logo Saat Ini:</label>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                         alt="Current Logo"
                                         style="max-height: 80px; max-width: 200px; object-fit: contain; background: white; padding: 0.5rem; border-radius: 0.5rem;">
                                    <div style="flex: 1;">
                                        <p style="color: #f1f5f9; font-size: 0.875rem; margin-bottom: 0.5rem;">
                                            <strong>{{ basename($settings['site_logo']) }}</strong>
                                        </p>
                                        <button type="button" id="delete-logo-btn" onclick="deleteLogoConfirm()"
                                                style="padding: 0.5rem 1rem; background: #dc2626; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer; transition: background 0.3s;"
                                                onmouseover="this.style.background='#b91c1c'"
                                                onmouseout="this.style.background='#dc2626'">
                                            <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus Logo
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Upload New Logo -->
                        <div class="form-group">
                            <label class="form-label">
                                @if($settings['site_logo'])
                                    Upload Logo Baru (Opsional)
                                @else
                                    Upload Logo
                                @endif
                            </label>
                            <input type="file" name="site_logo" id="site_logo" accept="image/png,image/jpg,image/jpeg,image/svg+xml"
                                   class="form-input" onchange="previewLogo(event)">
                            <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.5rem;">
                                Format: PNG, JPG, JPEG, SVG (Maks. 2MB) - Rekomendasi: background transparan, 200x60px
                            </small>
                        </div>

                        <!-- Logo Preview -->
                        <div id="logo_preview_container" style="display: none; margin-top: 1rem; padding: 1rem; background: #1e293b; border-radius: 0.5rem; border: 1px solid #334155;">
                            <label style="display: block; color: #94a3b8; font-size: 0.875rem; margin-bottom: 0.5rem;">Preview Logo Baru:</label>
                            <img id="logo_preview" src="" alt="Logo Preview" style="max-height: 80px; max-width: 200px; object-fit: contain; background: white; padding: 0.5rem; border-radius: 0.5rem;">
                        </div>

                        <!-- Logo Height Setting -->
                        <div class="form-group" style="margin-top: 1rem;">
                            <label class="form-label">Tinggi Logo (px)</label>
                            <input type="number" name="logo_height" value="{{ $settings['logo_height'] }}"
                                   min="20" max="100" step="5"
                                   class="form-input" placeholder="40">
                            <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.5rem;">
                                Atur tinggi logo yang ditampilkan di navbar (20-100px). Default: 40px
                            </small>
                            @error('logo_height')
                                <span style="color: #ef4444; font-size: 0.75rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Site Info Section -->
                    <div class="settings-card">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 style="font-weight: 600; color: #f1f5f9; font-size: 1.125rem;">Informasi Website</h3>
                                <p style="color: #94a3b8; font-size: 0.875rem;">Atur nama dan deskripsi website LMS</p>
                            </div>
                        </div>

                        <!-- Nama Website (Judul Besar) -->
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label class="form-label">Nama Website - Judul Besar <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="site_name" value="{{ $settings['site_name'] }}"
                                   class="form-input" placeholder="Contoh: MyLMS Academy" required id="site-name-input">
                            <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.5rem;">
                                Teks baris pertama (besar) yang ditampilkan di navbar
                            </small>
                            @error('site_name')
                                <span style="color: #ef4444; font-size: 0.75rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Subtitle (Teks Kecil) -->
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label class="form-label">Subtitle - Teks Kecil</label>
                            <input type="text" name="site_name_subtitle" value="{{ $settings['site_name_subtitle'] }}"
                                   class="form-input" placeholder="Contoh: Learning Management System" id="site-subtitle-input">
                            <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.5rem;">
                                Teks baris kedua (kecil) di bawah judul - opsional
                            </small>
                            @error('site_name_subtitle')
                                <span style="color: #ef4444; font-size: 0.75rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Warna Judul dan Subtitle -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Warna Judul</label>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="color" name="site_name_color" value="{{ $settings['site_name_color'] }}"
                                           id="site-name-color" style="width: 60px; height: 40px; border-radius: 0.375rem; border: 1px solid #475569; cursor: pointer;">
                                    <input type="text" value="{{ $settings['site_name_color'] }}"
                                           id="site-name-color-text" readonly class="form-input" style="flex: 1;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Warna Subtitle</label>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="color" name="site_subtitle_color" value="{{ $settings['site_subtitle_color'] }}"
                                           id="site-subtitle-color" style="width: 60px; height: 40px; border-radius: 0.375rem; border: 1px solid #475569; cursor: pointer;">
                                    <input type="text" value="{{ $settings['site_subtitle_color'] }}"
                                           id="site-subtitle-color-text" readonly class="form-input" style="flex: 1;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi Website</label>
                            <textarea name="site_description" rows="3" class="form-input" placeholder="Contoh: Platform pembelajaran online terbaik untuk meningkatkan skill Anda">{{ $settings['site_description'] }}</textarea>
                            <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.5rem;">
                                Deskripsi singkat tentang website LMS Anda (Maks. 500 karakter)
                            </small>
                            @error('site_description')
                                <span style="color: #ef4444; font-size: 0.75rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="settings-card" style="grid-column: span 2;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 style="font-weight: 600; color: #f1f5f9; font-size: 1.125rem;">Preview Navbar</h3>
                                <p style="color: #94a3b8; font-size: 0.875rem;">Lihat tampilan logo dan nama di navbar</p>
                            </div>
                        </div>

                        <div style="padding: 1.5rem; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-radius: 0.75rem; border: 1px solid #334155;">
                            <div id="navbar-preview" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: rgba(15, 23, 42, 0.8); border-radius: 0.5rem;">
                                @if($settings['site_logo'])
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" id="preview-logo-img" style="height: {{ $settings['logo_height'] }}px; object-fit: contain;">
                                @else
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 1.25rem; font-weight: 700; line-height: 1.2;" id="preview-site-name" data-color="{{ $settings['site_name_color'] }}">{{ $settings['site_name'] }}</span>
                                    <span style="font-size: 0.75rem; font-weight: 400; opacity: 0.8; line-height: 1.2;" id="preview-site-subtitle" data-color="{{ $settings['site_subtitle_color'] }}">{{ $settings['site_name_subtitle'] }}</span>
                                </div>
                            </div>
                            <p style="color: #94a3b8; font-size: 0.875rem; margin-top: 1rem; text-align: center;">
                                Preview akan update otomatis saat Anda mengubah nama, subtitle, atau warna
                            </p>
                        </div>
                    </div>

                    <!-- Certificate Settings Section -->
                    <div class="settings-card" style="grid-column: span 2;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 style="font-weight: 600; color: #f1f5f9; font-size: 1.125rem;">Pengaturan Sertifikat</h3>
                                <p style="color: #94a3b8; font-size: 0.875rem;">Kelola informasi CEO dan tanda tangan untuk sertifikat</p>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <!-- CEO Name -->
                            <div class="form-group">
                                <label class="form-label">Nama CEO & Founder</label>
                                <input type="text" name="ceo_name" value="{{ $settings['ceo_name']->value ?? 'CEO & Founder' }}"
                                       class="form-input" placeholder="Contoh: Dr. Ahmad Hidayat" required>
                                <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.5rem;">
                                    Nama yang akan muncul sebagai penanda tangan di sertifikat
                                </small>
                                @error('ceo_name')
                                    <span style="color: #ef4444; font-size: 0.75rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Platform Name -->
                            <div class="form-group">
                                <label class="form-label">Nama Platform</label>
                                <input type="text" name="platform_name" value="{{ $settings['platform_name']->value ?? 'LMS Learning Platform' }}"
                                       class="form-input" placeholder="Contoh: Excellence LMS Academy" required>
                                <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.5rem;">
                                    Nama platform yang muncul di header sertifikat
                                </small>
                                @error('platform_name')
                                    <span style="color: #ef4444; font-size: 0.75rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- CEO Signature Upload -->
                        <div class="form-group" style="margin-top: 1.5rem;">
                            <label class="form-label">Tanda Tangan CEO</label>

                            @if(isset($settings['ceo_signature']) && $settings['ceo_signature']->value)
                                <div style="margin-bottom: 1rem; padding: 1rem; background: rgba(15, 23, 42, 0.8); border-radius: 0.5rem; border: 1px solid #334155;">
                                    <p style="color: #94a3b8; font-size: 0.875rem; margin-bottom: 0.5rem;">Tanda tangan saat ini:</p>
                                    <img src="{{ asset('storage/' . $settings['ceo_signature']->value) }}"
                                         alt="CEO Signature"
                                         style="max-height: 120px; max-width: 300px; object-fit: contain; background: white; padding: 10px; border-radius: 8px;">
                                </div>
                            @endif

                            <input type="file" name="ceo_signature" accept="image/png,image/jpeg,image/jpg"
                                   class="form-input" style="padding: 0.75rem;">
                            <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 0.5rem;">
                                Upload tanda tangan CEO (PNG, JPG, JPEG | Maks. 2MB) - <strong>Rekomendasi: PNG dengan background transparan</strong>
                            </small>
                            @error('ceo_signature')
                                <span style="color: #ef4444; font-size: 0.75rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Preview Certificate Info -->
                        <div style="margin-top: 1.5rem; padding: 1rem; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 0.75rem; border: 1px solid #334155;">
                            <div style="display: flex; align-items: start; gap: 0.75rem;">
                                <svg style="width: 20px; height: 20px; color: #3b82f6; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p style="color: #f1f5f9; font-size: 0.875rem; margin-bottom: 0.5rem; font-weight: 600;">Tips Tanda Tangan:</p>
                                    <ul style="color: #94a3b8; font-size: 0.875rem; line-height: 1.6; list-style: disc; margin-left: 1.25rem;">
                                        <li>Format terbaik: <strong>PNG dengan background transparan</strong></li>
                                        <li>Size: 400x150px atau ratio 3:1 (horizontal)</li>
                                        <li>Tanda tangan harus jelas dan kontras dengan background</li>
                                        <li>Hindari background putih solid, gunakan transparan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem; position: relative; z-index: 100;">
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                        <svg style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    <button
                        type="submit"
                        id="submit-btn"
                        class="btn btn-primary"
                        style="pointer-events: auto !important; cursor: pointer !important; position: relative; z-index: 101;"
                        onmouseover="console.log('Mouse over button')"
                        onmousedown="console.log('Mouse down on button')"
                        onclick="console.log('Button CLICKED - form should submit')">
                        <svg style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>

            <!-- Hidden form for deleting logo (separate from main form) -->
            <form id="delete-logo-form" action="{{ route('admin.settings.delete-logo') }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>

        <style>
            .settings-container {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            .settings-card {
                padding: 1.5rem;
                background: linear-gradient(135deg, rgba(30, 41, 59, 0.6) 0%, rgba(15, 23, 42, 0.6) 100%);
                border-radius: 1rem;
                border: 1px solid #334155;
                backdrop-filter: blur(10px);
            }

            @media (max-width: 1024px) {
                .settings-container {
                    grid-template-columns: 1fr;
                }

                .settings-card[style*="grid-column: span 2"] {
                    grid-column: span 1 !important;
                }
            }
        </style>

        <script>
            function previewLogo(event) {
                const file = event.target.files[0];
                const previewContainer = document.getElementById('logo_preview_container');
                const previewImg = document.getElementById('logo_preview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewContainer.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.style.display = 'none';
                }
            }

            function deleteLogoConfirm() {
                if (confirm('Yakin ingin menghapus logo?')) {
                    console.log('Deleting logo...');
                    document.getElementById('delete-logo-form').submit();
                }
            }

            // Real-time preview updates - NO FORM INTERFERENCE
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Page loaded successfully');

                // Update site name preview
                const siteNameInput = document.getElementById('site-name-input');
                const previewSiteName = document.getElementById('preview-site-name');

                if (siteNameInput && previewSiteName) {
                    siteNameInput.addEventListener('input', function(e) {
                        previewSiteName.textContent = e.target.value || 'MyLMS';
                    });
                }

                // Update subtitle preview
                const siteSubtitleInput = document.getElementById('site-subtitle-input');
                const previewSubtitle = document.getElementById('preview-site-subtitle');

                if (siteSubtitleInput && previewSubtitle) {
                    siteSubtitleInput.addEventListener('input', function(e) {
                        previewSubtitle.textContent = e.target.value || 'Learning Management System';
                    });
                }

                // Update name color preview
                const nameColorInput = document.getElementById('site-name-color');
                const nameColorText = document.getElementById('site-name-color-text');

                if (nameColorInput && previewSiteName) {
                    nameColorInput.addEventListener('input', function(e) {
                        previewSiteName.style.color = e.target.value;
                        nameColorText.value = e.target.value;
                    });
                }

                // Update subtitle color preview
                const subtitleColorInput = document.getElementById('site-subtitle-color');
                const subtitleColorText = document.getElementById('site-subtitle-color-text');

                if (subtitleColorInput && previewSubtitle) {
                    subtitleColorInput.addEventListener('input', function(e) {
                        previewSubtitle.style.color = e.target.value;
                        subtitleColorText.value = e.target.value;
                    });
                }

                // Set initial colors
                if (previewSiteName && nameColorInput) {
                    previewSiteName.style.color = nameColorInput.value;
                }
                if (previewSubtitle && subtitleColorInput) {
                    previewSubtitle.style.color = subtitleColorInput.value;
                }

                // Update logo height preview
                const logoHeightInput = document.querySelector('input[name="logo_height"]');
                const previewLogoImg = document.getElementById('preview-logo-img');

                if (logoHeightInput && previewLogoImg) {
                    logoHeightInput.addEventListener('input', function(e) {
                        const height = e.target.value || '40';
                        previewLogoImg.style.height = height + 'px';
                    });
                }

                // NO FORM SUBMIT LISTENER - Let form submit naturally!
                console.log('JavaScript loaded - form will submit naturally');
            });
        </script>
        <style>
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        </style>
    @endsection
</x-back-end.master>
