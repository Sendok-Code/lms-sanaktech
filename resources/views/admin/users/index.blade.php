<x-back-end.master>
    @section('content')

        {{-- Modal Tambah User --}}
        <div class="modal hidden fixed inset-0 bg-black/50 z-50 items-center justify-center" id="userModal">
            <div class="modal-content">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Add New User</h2>
                    <button onclick="closeModal('userModal')" class="text-gray-500 hover:text-gray-800">✕</button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="text-sm font-medium">Full Name</label>
                        <input name="name" type="text" required class="form-input" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <input name="email" type="email" required class="form-input" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <input name="password" type="password" required class="form-input" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Role</label>
                        <select name="role" class="form-input">
                            <option value="student">Student</option>
                            <option value="instructor">Instructor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button class="btn btn-primary w-full">Add User</button>
                </form>
            </div>
        </div>

        {{-- Modal Edit User --}}
        <div class="modal hidden fixed inset-0 bg-black/50 z-50 items-center justify-center" id="editModal">
            <div class="modal-content">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Edit User</h2>
                    <button onclick="closeModal('editModal')" class="text-gray-500 hover:text-gray-800">✕</button>
                </div>
                <form id="editForm" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="text-sm font-medium">Full Name</label>
                        <input id="edit_name" name="name" type="text" required class="form-input" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <input id="edit_email" name="email" type="email" required class="form-input" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Role</label>
                        <select id="edit_role" name="role" class="form-input">
                            <option value="student">Student</option>
                            <option value="instructor">Instructor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button class="btn btn-primary w-full">Update User</button>
                </form>
            </div>
        </div>

        

        {{-- Manajemen User --}}
        <div class="p-6 module" id="user-management">
            <div class="flex justify-between items-center mb-6">
                <div class="section-title mb-0">User Management</div>
                <button class="btn btn-primary" onclick="openModal('userModal')">+ Add User</button>
            </div>

            {{-- Notifikasi sukses --}}
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
                            <th class="p-3">Name</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Role</th>
                            <th class="p-3">Joined</th>
                            <th class="p-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-t">
                                <td class="p-3">{{ $user->name }}</td>
                                <td class="p-3">{{ $user->email }}</td>
                                <td class="p-3 capitalize">{{ $user->role }}</td>
                                <td class="p-3">{{ $user->created_at->format('Y-m-d') }}</td>
                                <td class="p-3 text-center flex justify-center gap-2">
                                    <button class="btn btn-sm btn-secondary"
                                        onclick="editUser('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">Belum ada user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            function openModal(id) {
                document.getElementById(id).classList.remove('hidden');
                document.getElementById(id).classList.add('flex');
            }
            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
                document.getElementById(id).classList.remove('flex');
            }

            function editUser(id, name, email, role) {
                const form = document.getElementById('editForm');
                form.action = `/admin/users/${id}`;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_role').value = role;
                openModal('editModal');
            }
        </script>
    @endsection
</x-back-end.master>
