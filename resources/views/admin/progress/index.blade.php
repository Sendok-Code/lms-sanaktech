<x-back-end.master>
    @section('content')
        <!-- Progress Management -->
        <div id="progress-management" class="module p-6">
            <div style="margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0.5rem;">Student Progress</div>
                <p style="color: #94a3b8; font-size: 0.875rem;">Monitor student learning progress across all courses</p>
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
                            <th>Video</th>
                            <th>Status</th>
                            <th>Completed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($progresses as $progress)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $progress->enrollment->user->name }}</div>
                                    <div style="font-size: 0.875rem; color: #94a3b8;">{{ $progress->enrollment->user->email }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $progress->enrollment->course->title }}</span>
                                </td>
                                <td>
                                    {{ $progress->video->title }}
                                </td>
                                <td>
                                    @if($progress->completed)
                                        <span class="badge bg-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.25rem;">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                            </svg>
                                            Completed
                                        </span>
                                    @else
                                        <span class="badge bg-warning">In Progress</span>
                                    @endif
                                </td>
                                <td>
                                    @if($progress->completed)
                                        {{ $progress->updated_at->format('d M Y H:i') }}
                                    @else
                                        <span style="color: #94a3b8;">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No progress data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($progresses->hasPages())
            <div style="margin-top: 1.5rem;">
                {{ $progresses->links() }}
            </div>
            @endif
        </div>
    @endsection
</x-back-end.master>
