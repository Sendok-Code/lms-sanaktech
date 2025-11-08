<x-back-end.master>
    @section('content')
        <div class="modal" id="categoryModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span>Add New Category</span>
                    <button class="modal-close" onclick="closeModal('categoryModal')">✕</button>
                </div>

                {{-- FORM TAMBAH KATEGORI --}}
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-input" placeholder="Enter category name" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Add Category</button>
                </form>
            </div>
        </div>

        <!-- Category Management Module -->
        <div id="category-management" class="module p-6">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0;">Category Management</div>
                <button class="btn btn-primary" onclick="openModal('categoryModal')">+ Add Category</button>
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
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-secondary">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">Belum ada kategori</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</x-back-end.master>
