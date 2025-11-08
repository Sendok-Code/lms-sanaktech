    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Logo & Brand -->
        <div class="sidebar-header">
            <div class="logo-container">
                @php
                    $siteLogo = \App\Models\Setting::get('site_logo');
                    $siteName = \App\Models\Setting::get('site_name', 'MyLMS');
                    $siteSubtitle = \App\Models\Setting::get('site_name_subtitle', 'Learning Management System');
                    $nameColor = \App\Models\Setting::get('site_name_color', '#f1f5f9');
                    $subtitleColor = \App\Models\Setting::get('site_subtitle_color', '#94a3b8');
                    $logoHeight = \App\Models\Setting::get('logo_height', '40');
                @endphp
                @if($siteLogo)
                    <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" style="height: {{ $logoHeight }}px; object-fit: contain;">
                @else
                    <div class="logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                        </svg>
                    </div>
                @endif
                <div class="sidebar-text" style="display: flex; flex-direction: column; gap: 0.125rem;">
                    <div class="brand-name" style="color: {{ $nameColor }}; line-height: 1.2;">{{ $siteName }}</div>
                    @if($siteSubtitle)
                        <div class="brand-subtitle" style="font-size: 0.7rem; color: {{ $subtitleColor }}; opacity: 0.9; line-height: 1.2;">{{ $siteSubtitle }}</div>
                    @endif
                </div>
            </div>
            <button class="sidebar-toggle-btn" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <!-- Dashboard -->
            <a href="{{ route('admin.index') }}" class="nav-item active" data-module="dashboard">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </div>
                <span class="nav-text">Dashboard</span>
                <span class="nav-badge">3</span>
            </a>

            <!-- Users Section (Admin Only) -->
            @if(Auth::user()->role === 'admin')
            <div class="nav-item has-submenu" onclick="toggleSubmenu('users')">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <span class="nav-text">Users</span>
                <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="submenu" id="users-submenu">
                <a href="{{ route('admin.users.index') }}" class="nav-item submenu-item">
                    <span class="nav-text">All Users</span>
                </a>
                <a href="{{ route('admin.instructors.index') }}" class="nav-item submenu-item">
                    <span class="nav-text">Instructors</span>
                </a>
            </div>
            @endif

            <!-- Courses Section -->
            <div class="nav-item has-submenu" onclick="toggleSubmenu('courses')">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                </div>
                <span class="nav-text">Courses</span>
                <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="submenu" id="courses-submenu">
                <a href="{{ route('admin.courses.index') }}" class="nav-item submenu-item">
                    <span class="nav-text">All Courses</span>
                </a>
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.categories.index') }}" class="nav-item submenu-item">
                    <span class="nav-text">Categories</span>
                </a>
                @endif
                <a href="{{ route('admin.modules.index') }}" class="nav-item submenu-item">
                    <span class="nav-text">Modules</span>
                </a>
                <a href="{{ route('admin.videos.index') }}" class="nav-item submenu-item">
                    <span class="nav-text">Videos</span>
                </a>
            </div>

            <!-- Learning Section (Admin Only) -->
            @if(Auth::user()->role === 'admin')
            <div class="nav-item has-submenu" onclick="toggleSubmenu('learning')">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                    </svg>
                </div>
                <span class="nav-text">Learning</span>
                <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="submenu" id="learning-submenu">
                <a href="{{ route('admin.enrollments.index') }}" class="nav-item submenu-item">
                    <span class="nav-text">Enrollments</span>
                </a>
                <a href="{{ route('admin.progress.index') }}" class="nav-item submenu-item">
                    <span class="nav-text">Progress</span>
                </a>
            </div>
            @endif

            <!-- Payments Section (Admin Only) -->
            @if(Auth::user()->role === 'admin')
            <div class="nav-item has-submenu" onclick="toggleSubmenu('payments')">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                </div>
                <span class="nav-text">Payments</span>
                <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="submenu" id="payments-submenu">
                <a href="{{ route('admin.transactions.index') }}" class="nav-item submenu-item">
                    <span class="nav-text">Transactions</span>
                </a>
                <a href="{{ route('admin.coupons.index') }}" class="nav-item submenu-item">
                    <span class="nav-text">Coupons</span>
                </a>
            </div>
            @endif

            <!-- Reviews (Admin Only) -->
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.reviews.index') }}" class="nav-item">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                </div>
                <span class="nav-text">Reviews</span>
            </a>

            <!-- Analytics (Coming Soon) -->
            <a href="#" class="nav-item disabled" style="opacity: 0.5; cursor: not-allowed; pointer-events: none;">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="20" x2="12" y2="10"></line>
                        <line x1="18" y1="20" x2="18" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="16"></line>
                    </svg>
                </div>
                <span class="nav-text">Analytics</span>
                <span class="nav-badge" style="background: #64748b;">Soon</span>
            </a>

            <!-- Welcome Settings (Admin Only) -->
            <a href="{{ route('admin.welcome-settings.index') }}" class="nav-item">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="3" y1="9" x2="21" y2="9"></line>
                        <line x1="9" y1="21" x2="9" y2="9"></line>
                    </svg>
                </div>
                <span class="nav-text">Welcome Page</span>
            </a>

            <!-- Settings (Admin Only) -->
            <a href="{{ route('admin.settings.index') }}" class="nav-item">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M12 1v6m0 6v6m-9-9h6m6 0h6"></path>
                    </svg>
                </div>
                <span class="nav-text">Settings</span>
            </a>
            @endif
        </nav>

        <!-- User Profile at Bottom -->
        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=3b82f6&color=fff" alt="User">
                </div>
                <div class="user-info sidebar-text">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
                <div class="user-actions sidebar-text">
                    <button type="button" id="logout-button" class="logout-btn" title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <div class="header">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="mobile-toggle-btn" onclick="toggleSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                @php
                    $siteName = \App\Models\Setting::get('site_name', 'MyLMS');
                @endphp
                <h1 class="page-title">{{ $siteName }} Admin Dashboard</h1>
            </div>
            <div class="header-actions">
                <div class="search-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <input type="text" class="search-box" placeholder="Search anything...">
                </div>
                <button class="header-icon-btn notification-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="notification-dot"></span>
                </button>
            </div>
        </div>
