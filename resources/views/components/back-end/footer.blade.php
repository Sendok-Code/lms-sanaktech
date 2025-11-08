
    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }

        // Toggle Submenu
        function toggleSubmenu(id) {
            const submenu = document.getElementById(id + '-submenu');
            const parentItem = event.currentTarget;

            // Prevent event bubbling to avoid closing when clicking submenu items
            event.stopPropagation();

            // Check if this submenu is already open
            const isCurrentlyOpen = submenu.classList.contains('show');

            // Don't close other submenus - allow multiple submenus to be open
            // This allows better navigation experience

            // Toggle current submenu
            if (isCurrentlyOpen) {
                submenu.classList.remove('show');
                parentItem.classList.remove('active');
                // Save state to localStorage
                localStorage.removeItem('submenu-' + id);
            } else {
                submenu.classList.add('show');
                parentItem.classList.add('active');
                // Save state to localStorage
                localStorage.setItem('submenu-' + id, 'open');
            }
        }

        // Prevent submenu from closing when clicking submenu items
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent event bubbling on submenu items
            document.querySelectorAll('.submenu-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    // Let the link navigate normally, but keep submenu open
                    e.stopPropagation();
                });
            });

            // Restore submenu states from localStorage
            ['users', 'courses', 'learning', 'payments'].forEach(function(menuId) {
                if (localStorage.getItem('submenu-' + menuId) === 'open') {
                    const submenu = document.getElementById(menuId + '-submenu');
                    const parentToggle = submenu ? submenu.previousElementSibling : null;
                    if (submenu) {
                        submenu.classList.add('show');
                        if (parentToggle) {
                            parentToggle.classList.add('active');
                        }
                    }
                }
            });

            // Keep submenu open after page navigation if we're on a submenu page
            const currentPath = window.location.pathname;
            document.querySelectorAll('.submenu-item').forEach(item => {
                if (item.href && currentPath.includes(item.getAttribute('href'))) {
                    const submenu = item.closest('.submenu');
                    if (submenu) {
                        submenu.classList.add('show');
                        const parentToggle = submenu.previousElementSibling;
                        if (parentToggle) {
                            parentToggle.classList.add('active');
                        }
                        // Save to localStorage
                        const submenuId = submenu.id.replace('-submenu', '');
                        localStorage.setItem('submenu-' + submenuId, 'open');
                    }
                }
            });
        });

        // Show Module
        function showModule(moduleId) {
            // Hide all modules
            const modules = document.querySelectorAll('.module');
            modules.forEach(module => {
                module.style.display = 'none';
            });

            // Show selected module
            const selectedModule = document.getElementById(moduleId);
            if (selectedModule) {
                selectedModule.style.display = 'block';
            }

            // Update active nav item (only for non-submenu items)
            if (event && event.target) {
                const navItems = document.querySelectorAll('.nav-item:not(.has-submenu)');
                navItems.forEach(item => {
                    item.classList.remove('active');
                });

                const clickedItem = event.target.closest('.nav-item');
                if (clickedItem && !clickedItem.classList.contains('has-submenu')) {
                    clickedItem.classList.add('active');
                }
            }

            // Initialize charts if needed
            if (moduleId === 'dashboard') {
                initDashboardCharts();
            } else if (moduleId === 'analytics') {
                initAnalyticsCharts();
            }
        }

        // Modal Functions
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
            }
        }

        // Initialize Dashboard Charts
        function initDashboardCharts() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx && !revenueCtx.chart) {
                revenueCtx.chart = new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Revenue',
                            data: [12000, 19000, 15000, 25000, 22000, 30000],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                labels: { color: '#f1f5f9' }
                            }
                        },
                        scales: {
                            y: {
                                ticks: { color: '#cbd5e1' },
                                grid: { color: '#334155' }
                            },
                            x: {
                                ticks: { color: '#cbd5e1' },
                                grid: { color: '#334155' }
                            }
                        }
                    }
                });
            }

            // Enrollment Chart
            const enrollmentCtx = document.getElementById('enrollmentChart');
            if (enrollmentCtx && !enrollmentCtx.chart) {
                enrollmentCtx.chart = new Chart(enrollmentCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Active', 'Completed', 'Pending'],
                        datasets: [{
                            data: [6892, 1234, 108],
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                labels: { color: '#f1f5f9' }
                            }
                        }
                    }
                });
            }

            // Course Chart
            const courseCtx = document.getElementById('courseChart');
            if (courseCtx && !courseCtx.chart) {
                courseCtx.chart = new Chart(courseCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Programming', 'Design', 'Business', 'Marketing'],
                        datasets: [{
                            label: 'Courses',
                            data: [45, 32, 28, 15],
                            backgroundColor: '#8b5cf6'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                labels: { color: '#f1f5f9' }
                            }
                        },
                        scales: {
                            y: {
                                ticks: { color: '#cbd5e1' },
                                grid: { color: '#334155' }
                            },
                            x: {
                                ticks: { color: '#cbd5e1' },
                                grid: { color: '#334155' }
                            }
                        }
                    }
                });
            }
        }

        // Initialize Analytics Charts
        function initAnalyticsCharts() {
            // User Growth Chart
            const userGrowthCtx = document.getElementById('userGrowthChart');
            if (userGrowthCtx && !userGrowthCtx.chart) {
                userGrowthCtx.chart = new Chart(userGrowthCtx, {
                    type: 'line',
                    data: {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        datasets: [{
                            label: 'New Users',
                            data: [120, 190, 150, 250],
                            borderColor: '#06b6d4',
                            backgroundColor: 'rgba(6, 182, 212, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                labels: { color: '#f1f5f9' }
                            }
                        },
                        scales: {
                            y: {
                                ticks: { color: '#cbd5e1' },
                                grid: { color: '#334155' }
                            },
                            x: {
                                ticks: { color: '#cbd5e1' },
                                grid: { color: '#334155' }
                            }
                        }
                    }
                });
            }

            // Revenue Distribution Chart
            const revenueDistributionCtx = document.getElementById('revenueDistributionChart');
            if (revenueDistributionCtx && !revenueDistributionCtx.chart) {
                revenueDistributionCtx.chart = new Chart(revenueDistributionCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Courses', 'Subscriptions', 'Bundles'],
                        datasets: [{
                            data: [45000, 25000, 15000],
                            backgroundColor: ['#3b82f6', '#8b5cf6', '#06b6d4']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                labels: { color: '#f1f5f9' }
                            }
                        }
                    }
                });
            }

            // Course Performance Chart
            const coursePerformanceCtx = document.getElementById('coursePerformanceChart');
            if (coursePerformanceCtx && !coursePerformanceCtx.chart) {
                coursePerformanceCtx.chart = new Chart(coursePerformanceCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Python Basics', 'Web Dev', 'UI/UX Design', 'Business'],
                        datasets: [
                            {
                                label: 'Enrollments',
                                data: [342, 215, 521, 189],
                                backgroundColor: '#3b82f6'
                            },
                            {
                                label: 'Completions',
                                data: [256, 156, 412, 134],
                                backgroundColor: '#10b981'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                labels: { color: '#f1f5f9' }
                            }
                        },
                        scales: {
                            y: {
                                ticks: { color: '#cbd5e1' },
                                grid: { color: '#334155' }
                            },
                            x: {
                                ticks: { color: '#cbd5e1' },
                                grid: { color: '#334155' }
                            }
                        }
                    }
                });
            }
        }

        // Set active menu based on current URL
        function setActiveMenu() {
            const currentPath = window.location.pathname;
            const navItems = document.querySelectorAll('.nav-item[href]');

            navItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href && currentPath.includes(href) && href !== '#') {
                    item.classList.add('active');

                    // Open parent submenu if exists
                    const submenu = item.closest('.submenu');
                    if (submenu) {
                        submenu.classList.add('show');
                        const parentToggle = submenu.previousElementSibling;
                        if (parentToggle) {
                            parentToggle.classList.add('active');
                        }
                    }
                }
            });
        }

        // Logout functionality
        function handleLogout() {
            const logoutButton = document.getElementById('logout-button');
            const logoutForm = document.getElementById('logout-form');

            if (logoutButton && logoutForm) {
                logoutButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Logout button clicked');

                    // Confirm before logout
                    if (confirm('Apakah Anda yakin ingin keluar?')) {
                        console.log('Submitting logout form');
                        logoutForm.submit();
                    }
                });
            } else {
                console.error('Logout button or form not found');
            }
        }

        // Initialize on page load
        window.addEventListener('load', function() {
            initDashboardCharts();
            setActiveMenu();
            handleLogout();
        });
    </script>
</body>
</html>