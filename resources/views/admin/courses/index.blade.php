<x-back-end.master>
    @section('content')
        <!-- Add Course Modal -->
        <div class="modal" id="courseModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span>Add New Course</span>
                    <button class="modal-close" onclick="closeModal('courseModal')">✕</button>
                </div>

                <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Course Title</label>
                        <input
                            type="text"
                            name="title"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            placeholder="Enter course title"
                            required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Description</label>
                        <textarea
                            name="description"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            rows="3"
                            placeholder="Enter course description..."></textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Thumbnail Image</label>
                        <input
                            type="file"
                            name="thumbnail"
                            accept="image/jpeg,image/jpg,image/png,image/webp"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100">
                        <small class="text-gray-400">Upload gambar untuk thumbnail course (max 2MB)</small>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Preview Video URL (YouTube)</label>
                        <input
                            type="url"
                            name="preview_video_url"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            placeholder="https://www.youtube.com/watch?v=...">
                        <small class="text-gray-400">URL video YouTube untuk preview sebelum membeli</small>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Resource File (Materi Tambahan)</label>
                        <input
                            type="file"
                            name="resource_file"
                            accept=".zip,.rar,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100">
                        <small class="text-gray-400">Upload file materi (ZIP, PDF, DOC, dll) max 50MB - hanya bisa didownload student yang sudah membeli</small>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Price (Rp)</label>
                        <input
                            type="number"
                            name="price"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            placeholder="e.g., 150000"
                            min="0"
                            required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Category</label>
                        <select
                            name="category_id"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(Auth::user()->role === 'admin' && isset($instructors))
                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Instructor</label>
                        <select
                            name="instructor_id"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            required>
                            <option value="">-- Select Instructor --</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <button
                        type="submit"
                        class="btn bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-lg flex items-center justify-center font-semibold"
                        style="margin-top: 1rem;">
                        Add Course
                    </button>
                </form>
            </div>
        </div>

        <!-- Edit Course Modal -->
        <div class="modal" id="editCourseModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span>Edit Course</span>
                    <button class="modal-close" onclick="closeModal('editCourseModal')">✕</button>
                </div>

                <form id="editCourseForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Course Title</label>
                        <input
                            type="text"
                            name="title"
                            id="edit_title"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Description</label>
                        <textarea
                            name="description"
                            id="edit_description"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            rows="3"></textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Thumbnail Image</label>
                        <div id="current_thumbnail_preview" class="mb-2"></div>
                        <input
                            type="file"
                            name="thumbnail"
                            accept="image/jpeg,image/jpg,image/png,image/webp"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100">
                        <small class="text-gray-400">Upload gambar baru untuk mengganti thumbnail (max 2MB)</small>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Preview Video URL (YouTube)</label>
                        <input
                            type="url"
                            name="preview_video_url"
                            id="edit_preview_video_url"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            placeholder="https://www.youtube.com/watch?v=...">
                        <small class="text-gray-400">URL video YouTube untuk preview sebelum membeli</small>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Resource File (Materi Tambahan)</label>
                        <div id="current_resource_file_info" class="mb-2"></div>
                        <input
                            type="file"
                            name="resource_file"
                            accept=".zip,.rar,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100">
                        <small class="text-gray-400">Upload file baru untuk mengganti materi (ZIP, PDF, DOC, dll) max 50MB</small>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Price (Rp)</label>
                        <input
                            type="number"
                            name="price"
                            id="edit_price"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            min="0"
                            required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Category</label>
                        <select
                            name="category_id"
                            id="edit_category_id"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(Auth::user()->role === 'admin' && isset($instructors))
                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Instructor</label>
                        <select
                            name="instructor_id"
                            id="edit_instructor_id"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            required>
                            <option value="">-- Select Instructor --</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="form-group mb-4">
                        <label class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                name="published"
                                id="edit_published"
                                value="1"
                                class="rounded border-gray-600 bg-slate-700">
                            <span class="text-sm text-gray-300">Published</span>
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="btn bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-lg flex items-center justify-center font-semibold"
                        style="margin-top: 1rem;">
                        Update Course
                    </button>
                </form>
            </div>
        </div>

        <!-- Course Management Module -->
        <div id="course-management" class="module p-6">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0;">Course Management</div>
                <button class="btn btn-primary" onclick="openModal('courseModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add Course
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
                    }, 2000);
                </script>
            @endif

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Instructor</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Students</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $item)
                            <tr>
                                <td>{{ ($courses->currentPage() - 1) * $courses->perPage() + $loop->iteration }}</td>
                                <td>
                                    <div style="font-weight: 600;">{{ $item->title }}</div>
                                    @if($item->description)
                                    <div style="font-size: 0.875rem; color: #94a3b8; margin-top: 0.25rem;">
                                        {{ Str::limit($item->description, 50) }}
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    @if($item->instructor && $item->instructor->user)
                                        {{ $item->instructor->user->name }}
                                    @else
                                        <span style="color: #94a3b8;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->category)
                                        <span class="badge bg-primary">{{ $item->category->name }}</span>
                                    @else
                                        <span style="color: #94a3b8;">-</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        <span style="font-weight: 600; color: #3b82f6;">{{ $item->enrollments_count ?? 0 }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div style="flex: 1; background: #334155; height: 8px; border-radius: 4px; overflow: hidden; min-width: 60px;">
                                            <div style="height: 100%; background: linear-gradient(90deg, #10b981 0%, #059669 100%); width: {{ $item->average_progress }}%;"></div>
                                        </div>
                                        <span style="font-size: 0.875rem; color: #94a3b8; min-width: 35px;">{{ $item->average_progress }}%</span>
                                    </div>
                                </td>
                                <td>
                                    @if($item->published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button
                                            onclick="editCourse({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->description) }}', {{ $item->price }}, {{ $item->category_id ?? 'null' }}, {{ $item->instructor_id ?? 'null' }}, {{ $item->published ? 'true' : 'false' }}, '{{ $item->thumbnail ?? '' }}', '{{ $item->preview_video_url ?? '' }}', '{{ $item->resource_file_name ?? '' }}')"
                                            class="btn btn-sm btn-primary">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.courses.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-secondary">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-gray-500">No courses available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($courses->hasPages())
            <div style="margin-top: 1.5rem;">
                {{ $courses->links() }}
            </div>
            @endif
        </div>

        <script>
            function editCourse(id, title, description, price, categoryId, instructorId, published, thumbnail, previewVideoUrl, resourceFileName) {
                const form = document.getElementById('editCourseForm');
                form.action = `/courses/${id}`;

                document.getElementById('edit_title').value = title;
                document.getElementById('edit_description').value = description || '';
                document.getElementById('edit_price').value = price;
                document.getElementById('edit_category_id').value = categoryId || '';
                document.getElementById('edit_preview_video_url').value = previewVideoUrl || '';

                // Show current thumbnail if exists
                const thumbnailPreview = document.getElementById('current_thumbnail_preview');
                if (thumbnail) {
                    thumbnailPreview.innerHTML = `<img src="/storage/${thumbnail}" alt="Current thumbnail" style="max-width: 200px; border-radius: 8px;">`;
                } else {
                    thumbnailPreview.innerHTML = '<span style="color: #94a3b8;">No thumbnail</span>';
                }

                // Show current resource file if exists
                const resourceFileInfo = document.getElementById('current_resource_file_info');
                if (resourceFileName) {
                    resourceFileInfo.innerHTML = `
                        <div style="padding: 0.75rem; background: #1e293b; border-radius: 8px; display: flex; align-items: center; gap: 0.5rem;">
                            <svg style="width: 20px; height: 20px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span style="color: #94a3b8; font-size: 0.875rem;">Current file: <strong style="color: #10b981;">${resourceFileName}</strong></span>
                        </div>
                    `;
                } else {
                    resourceFileInfo.innerHTML = '<span style="color: #94a3b8;">No resource file uploaded</span>';
                }

                // Hanya set instructor jika field ada (admin only)
                const instructorField = document.getElementById('edit_instructor_id');
                if (instructorField) {
                    instructorField.value = instructorId || '';
                }

                document.getElementById('edit_published').checked = published;

                openModal('editCourseModal');
            }
        </script>
    @endsection
</x-back-end.master>
