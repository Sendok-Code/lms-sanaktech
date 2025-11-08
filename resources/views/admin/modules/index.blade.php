<x-back-end.master>
    @section('content')
        <!-- Add Module Modal -->
        <div class="modal" id="moduleModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span>Add New Module</span>
                    <button class="modal-close" onclick="closeModal('moduleModal')">✕</button>
                </div>

                <form action="{{ route('admin.modules.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Select Course</label>
                        <select name="course_id" class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100" required>
                            <option value="">-- Select Course --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Module Title</label>
                        <input type="text" name="title" class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100" placeholder="Enter module title" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Sort Order (Optional)</label>
                        <input type="number" name="sort_order" class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100" placeholder="e.g., 1, 2, 3">
                    </div>

                    <button
                        type="submit"
                        class="btn bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-lg flex items-center justify-center font-semibold"
                        style="margin-top: 1rem;">
                        Add Module
                    </button>
                </form>
            </div>
        </div>

        <!-- Edit Module Modal -->
        <div class="modal" id="editModuleModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span>Edit Module</span>
                    <button class="modal-close" onclick="closeModal('editModuleModal')">✕</button>
                </div>

                <form id="editModuleForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-300">Module Title</label>
                        <input
                            type="text"
                            name="title"
                            id="edit_title"
                            class="form-input mt-1 block w-full border-gray-600 rounded-md shadow-sm bg-slate-700 text-gray-100"
                            required>
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
                        Update Module
                    </button>
                </form>
            </div>
        </div>

        <!-- Module Management -->
        <div id="module-management" class="module p-6">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0;">Module Management</div>
                <button class="btn btn-primary" onclick="openModal('moduleModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add Module
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
                            <th>Course</th>
                            <th>Module Title</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($modules as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $item->course->title }}</span>
                                </td>
                                <td>
                                    <div style="font-weight: 600;">{{ $item->title }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $item->sort_order ?? '-' }}</span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button
                                            onclick="editModule({{ $item->id }}, '{{ $item->title }}', {{ $item->sort_order ?? 'null' }})"
                                            class="btn btn-sm btn-primary">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.modules.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this module?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-secondary">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No modules available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            function editModule(id, title, sortOrder) {
                const form = document.getElementById('editModuleForm');
                form.action = `/modules/${id}`;

                document.getElementById('edit_title').value = title;
                document.getElementById('edit_sort_order').value = sortOrder || '';

                openModal('editModuleModal');
            }
        </script>
    @endsection
</x-back-end.master>
