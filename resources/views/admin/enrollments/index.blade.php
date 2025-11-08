<x-back-end.master>
    @section('content')
        <!-- Enrollment Management -->
        <div id="enrollment-management" class="module p-6">
            <div style="margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0.5rem;">Enrollment Management</div>
                <p style="color: #94a3b8; font-size: 0.875rem;">Manage student enrollments and course access</p>
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

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Enrolled Date</th>
                            <th>Status</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $enrollment->user->name }}</div>
                                    <div style="font-size: 0.875rem; color: #94a3b8;">{{ $enrollment->user->email }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $enrollment->course->title }}</span>
                                </td>
                                <td>
                                    {{ $enrollment->created_at->format('d M Y') }}
                                </td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div style="flex: 1; height: 8px; background: #334155; border-radius: 4px; overflow: hidden;">
                                            <div style="height: 100%; background: #3b82f6; width: {{ $enrollment->progress_percentage }}%;"></div>
                                        </div>
                                        <span style="font-size: 0.875rem; font-weight: 600;">{{ $enrollment->progress_percentage }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No enrollments available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($enrollments->hasPages())
            <div style="margin-top: 1.5rem;">
                {{ $enrollments->links() }}
            </div>
            @endif
        </div>
    @endsection
</x-back-end.master>
