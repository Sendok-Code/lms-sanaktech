<x-back-end.master>
    @section('content')
        <div class="modal" id="instructorModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span>Add New Category</span>
                    <button class="modal-close" onclick="closeModal('instructorModal')">✕</button>
                </div>

                {{-- FORM TAMBAH KATEGORI --}}
                <form action="{{ route('admin.instructors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-200">Pilih User (Instructor)</label>
                        <select name="user_id" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Pilih User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-200">Bio</label>
                        <textarea name="bio" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3" placeholder="Tulis bio singkat..."></textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label block text-sm font-medium text-gray-200">Foto Profil</label>
                        <input type="file" name="profile_picture" accept="image/*" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <button type="submit" class="btn bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-lg flex items-center justify-center font-semibold" style="margin-top: 1rem;"> Tambah Instructor </button>
                </form>

            </div>
        </div>

        <!-- Category Management Module -->
        <div id="category-management" class="module p-6">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0;">Instructor Management</div>
                <button class="btn btn-primary" onclick="openModal('instructorModal')">+ Add Instructor</button>
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
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($instructors as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->user->role }}</td>
                                <td>
                                    @if ($item->profile_picture)
                                        <img src="{{ asset('storage/' . $item->profile_picture) }}" alt="Profile Picture" class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <span class="text-gray-500">No Photo</span>
                                    @endif
                                <td>
                                    <form action="{{ route('admin.instructors.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-secondary">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">Belum ada instructors</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</x-back-end.master>
