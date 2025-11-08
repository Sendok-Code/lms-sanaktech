<x-back-end.master>
    @section('content')
        <!-- Add Video Modal -->
        <div class="modal" id="videoModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span>Add New Video</span>
                    <button class="modal-close" onclick="closeModal('videoModal')">✕</button>
                </div>

                <form action="{{ route('admin.videos.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Select Course</label>
                        <select name="course_id" id="courseSelect"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100" required>
                            <option value="">-- Select Course --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Select Module</label>
                        <select name="module_id" id="moduleSelect"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100" required>
                            <option value="">-- Select Module --</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Video Title</label>
                        <input type="text" name="title"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            placeholder="Enter video title" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Video URL</label>
                        <input type="url" name="video_url"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            placeholder="Enter video URL (YouTube, Vimeo, etc.)" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Duration (seconds)</label>
                        <input type="number" name="duration_seconds"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            placeholder="e.g., 300">
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Sort Order (Optional)</label>
                        <input type="number" name="sort_order"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            placeholder="e.g., 1, 2, 3">
                    </div>

                    <button
                        type="submit"
                        class="btn bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-lg flex items-center justify-center font-semibold"
                        style="margin-top: 1rem;">
                        Add Video
                    </button>
                </form>
            </div>
        </div>

        <!-- Edit Video Modal -->
        <div class="modal" id="editVideoModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span>Edit Video</span>
                    <button class="modal-close" onclick="closeModal('editVideoModal')">✕</button>
                </div>

                <form id="editVideoForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Video Title</label>
                        <input
                            type="text"
                            name="title"
                            id="edit_title"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Video URL</label>
                        <input
                            type="url"
                            name="video_url"
                            id="edit_video_url"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Duration (seconds)</label>
                        <input
                            type="number"
                            name="duration_seconds"
                            id="edit_duration_seconds"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100">
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Sort Order</label>
                        <input
                            type="number"
                            name="sort_order"
                            id="edit_sort_order"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100">
                    </div>

                    <button
                        type="submit"
                        class="btn bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-lg flex items-center justify-center font-semibold"
                        style="margin-top: 1rem;">
                        Update Video
                    </button>
                </form>
            </div>
        </div>

        <!-- Video Management -->
        <div id="video-management" class="module p-6">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0;">Video Management</div>
                <button class="btn btn-primary" onclick="openModal('videoModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add Video
                </button>
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
                            <th>No.</th>
                            <th>Title</th>
                            <th>Course</th>
                            <th>Module</th>
                            <th>Duration</th>
                            <th>Sort</th>
                            <th>URL</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($videos as $video)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div style="font-weight: 600;">{{ $video->title }}</div>
                                </td>
                                <td>
                                    @if($video->course)
                                        <span class="badge bg-primary">{{ $video->course->title }}</span>
                                    @else
                                        <span style="color: #94a3b8;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($video->module)
                                        <span class="badge bg-secondary">{{ $video->module->title }}</span>
                                    @else
                                        <span style="color: #94a3b8;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($video->duration_seconds)
                                        {{ floor($video->duration_seconds / 60) }}:{{ str_pad($video->duration_seconds % 60, 2, '0', STR_PAD_LEFT) }}
                                    @else
                                        <span style="color: #94a3b8;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $video->sort_order ?? '-' }}</span>
                                </td>
                                <td>
                                    <a href="{{ $video->video_url }}" target="_blank" class="text-blue-500 hover:text-blue-600" style="text-decoration: underline;">
                                        View
                                    </a>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button
                                            onclick="editVideo({{ $video->id }}, '{{ addslashes($video->title) }}', '{{ $video->video_url }}', {{ $video->duration_seconds ?? 'null' }}, {{ $video->sort_order ?? 'null' }})"
                                            class="btn btn-sm btn-primary">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.videos.destroy', $video) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this video?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-secondary">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-500">No videos available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            // Course-Module Selection for Add Modal
            const courseData = @json($courses);
            document.getElementById('courseSelect').addEventListener('change', function() {
                const selectedId = this.value;
                const moduleSelect = document.getElementById('moduleSelect');
                moduleSelect.innerHTML = '<option value="">-- Select Module --</option>';

                const selectedCourse = courseData.find(c => c.id == selectedId);
                if (selectedCourse && selectedCourse.modules) {
                    selectedCourse.modules.forEach(m => {
                        const opt = document.createElement('option');
                        opt.value = m.id;
                        opt.textContent = m.title;
                        moduleSelect.appendChild(opt);
                    });
                }
            });

            // Edit Video Function
            function editVideo(id, title, videoUrl, duration, sortOrder) {
                const form = document.getElementById('editVideoForm');
                form.action = `/videos/${id}`;

                document.getElementById('edit_title').value = title;
                document.getElementById('edit_video_url').value = videoUrl;
                document.getElementById('edit_duration_seconds').value = duration || '';
                document.getElementById('edit_sort_order').value = sortOrder || '';

                openModal('editVideoModal');
            }
        </script>
    @endsection
</x-back-end.master>
