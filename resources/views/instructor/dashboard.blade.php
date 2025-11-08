<x-back-end.master>
    @section('content')
        <!-- Instructor Dashboard -->
        <div id="dashboard" class="module p-6">
            <div class="section-title">Instructor Dashboard</div>

            <!-- Statistics Cards -->
            <div class="grid-4">
                <div class="stat-card">
                    <div class="stat-label">My Courses</div>
                    <div class="stat-value">{{ $stats['total_courses'] }}</div>
                    <div class="stat-change {{ $stats['published_courses'] > 0 ? 'positive' : '' }}">
                        {{ $stats['published_courses'] }} published
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Students</div>
                    <div class="stat-value">{{ $stats['total_students'] }}</div>
                    <div class="stat-change positive">Across all courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Avg Progress</div>
                    <div class="stat-value">{{ $stats['avg_progress'] }}%</div>
                    <div class="stat-change {{ $stats['avg_progress'] >= 50 ? 'positive' : '' }}">
                        Student completion rate
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Videos</div>
                    <div class="stat-value">{{ $stats['total_videos'] }}</div>
                    <div class="stat-change positive">Content uploaded</div>
                </div>
            </div>

            <!-- My Courses Performance -->
            <div class="chart-container" style="margin-top: 2rem;">
                <h3 style="margin-bottom: 1rem; font-weight: 600;">My Courses Performance</h3>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Students</th>
                                <th>Avg Progress</th>
                                <th>Modules</th>
                                <th>Videos</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $course->title }}</div>
                                    <div style="font-size: 0.875rem; color: #94a3b8;">
                                        {{ $course->category->name ?? 'Uncategorized' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        <span style="font-weight: 600;">{{ $course->enrollments_count }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div style="flex: 1; background: #334155; height: 8px; border-radius: 4px; overflow: hidden; min-width: 80px;">
                                            <div style="height: 100%; background: linear-gradient(90deg, #10b981 0%, #059669 100%); width: {{ $course->average_progress }}%;"></div>
                                        </div>
                                        <span style="font-size: 0.875rem; font-weight: 600;">{{ $course->average_progress }}%</span>
                                    </div>
                                </td>
                                <td>{{ $course->modules_count }}</td>
                                <td>{{ $course->videos_count }}</td>
                                <td>
                                    @if($course->published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning">Draft</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">
                                    You haven't created any courses yet.
                                    <a href="{{ route('admin.courses.index') }}" style="color: #3b82f6; text-decoration: underline;">Create your first course</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Enrollments -->
            <div class="chart-container" style="margin-top: 2rem;">
                <h3 style="margin-bottom: 1rem; font-weight: 600;">Recent Student Enrollments</h3>
                <div style="space-y: 1rem;">
                    @forelse($recent_enrollments as $enrollment)
                    <div style="padding: 1rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-weight: 600;">{{ $enrollment->user->name }}</div>
                            <div style="font-size: 0.875rem; color: var(--text-secondary);">
                                Enrolled in {{ $enrollment->course->title }}
                            </div>
                        </div>
                        <div style="font-size: 0.875rem; color: var(--text-secondary);">
                            {{ $enrollment->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @empty
                    <div style="padding: 2rem; text-align: center; color: var(--text-secondary);">
                        No enrollments yet
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid-3" style="margin-top: 2rem;">
                <a href="{{ route('admin.courses.index') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: transform 0.2s;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="padding: 1rem; background: #3b82f6; border-radius: 12px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight: 600; color: #fff;">Manage Courses</div>
                            <div style="font-size: 0.875rem; color: #94a3b8;">Create & edit courses</div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.modules.index') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: transform 0.2s;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="padding: 1rem; background: #10b981; border-radius: 12px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight: 600; color: #fff;">Manage Modules</div>
                            <div style="font-size: 0.875rem; color: #94a3b8;">Organize content</div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.videos.index') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: transform 0.2s;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="padding: 1rem; background: #f59e0b; border-radius: 12px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight: 600; color: #fff;">Manage Videos</div>
                            <div style="font-size: 0.875rem; color: #94a3b8;">Upload video lessons</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endsection
</x-back-end.master>
