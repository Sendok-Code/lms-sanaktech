<x-back-end.master>
    @section('content')
        <!-- Review Management -->
        <div id="review-management" class="module p-6">
            <div style="margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0.5rem;">Review Management</div>
                <p style="color: #94a3b8; font-size: 0.875rem;">Manage course reviews and ratings from students</p>
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
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reviews as $review)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $review->user->name }}</div>
                                    <div style="font-size: 0.875rem; color: #94a3b8;">{{ $review->user->email }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $review->course->title }}</span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.25rem;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#fbbf24" stroke="#fbbf24" stroke-width="2">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg>
                                            @endif
                                        @endfor
                                        <span style="margin-left: 0.5rem; font-weight: 600;">{{ $review->rating }}/5</span>
                                    </div>
                                </td>
                                <td style="max-width: 300px;">
                                    {{ Str::limit($review->review, 100) }}
                                </td>
                                <td>
                                    {{ $review->created_at->format('d M Y') }}
                                </td>
                                <td>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this review?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-secondary">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">No reviews available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reviews->hasPages())
            <div style="margin-top: 1.5rem;">
                {{ $reviews->links() }}
            </div>
            @endif
        </div>
    @endsection
</x-back-end.master>
