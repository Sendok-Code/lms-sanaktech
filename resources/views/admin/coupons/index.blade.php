<x-back-end.master>
    @section('content')
        <!-- Add Coupon Modal -->
        <div class="modal" id="couponModal">
            <div class="modal-content" style="max-width: 600px;">
                <div class="modal-header">
                    <span>Add New Coupon</span>
                    <button class="modal-close" onclick="closeModal('couponModal')">✕</button>
                </div>

                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf
                    <div class="settings-grid">
                        <div class="form-group">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="code"
                                class="form-input"
                                placeholder="e.g., DISC20" required style="text-transform: uppercase;">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Coupon Name</label>
                            <input type="text" name="name"
                                class="form-input"
                                placeholder="Discount 20%" required>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="2" class="form-input"
                                placeholder="Enter coupon description"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Discount Type</label>
                            <select name="type" class="form-input" required>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (Rp)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Discount Value</label>
                            <input type="number" name="value" class="form-input"
                                placeholder="20" min="0" step="0.01" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Max Uses</label>
                            <input type="number" name="max_uses" class="form-input"
                                placeholder="100" min="1">
                            <small style="color: #94a3b8; font-size: 0.75rem;">Leave empty for unlimited</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Min Purchase (Rp)</label>
                            <input type="number" name="min_purchase" class="form-input"
                                placeholder="100000" min="0">
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Expires At</label>
                            <input type="datetime-local" name="expires_at" class="form-input">
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" value="1" checked
                                    class="rounded border-gray-600 bg-slate-700">
                                <span class="text-sm text-gray-300">Active</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="btn bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-lg flex items-center justify-center font-semibold"
                        style="margin-top: 1rem;">
                        Add Coupon
                    </button>
                </form>
            </div>
        </div>

        <!-- Edit Coupon Modal -->
        <div class="modal" id="editCouponModal">
            <div class="modal-content" style="max-width: 600px;">
                <div class="modal-header">
                    <span>Edit Coupon</span>
                    <button class="modal-close" onclick="closeModal('editCouponModal')">✕</button>
                </div>

                <form id="editCouponForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="settings-grid">
                        <div class="form-group">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="code" id="edit_code"
                                class="form-input" required style="text-transform: uppercase;">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Coupon Name</label>
                            <input type="text" name="name" id="edit_name"
                                class="form-input" required>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="edit_description" rows="2" class="form-input"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Discount Type</label>
                            <select name="type" id="edit_type" class="form-input" required>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (Rp)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Discount Value</label>
                            <input type="number" name="value" id="edit_value" class="form-input"
                                min="0" step="0.01" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Max Uses</label>
                            <input type="number" name="max_uses" id="edit_max_uses" class="form-input" min="1">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Min Purchase (Rp)</label>
                            <input type="number" name="min_purchase" id="edit_min_purchase" class="form-input" min="0">
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Expires At</label>
                            <input type="datetime-local" name="expires_at" id="edit_expires_at" class="form-input">
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" id="edit_is_active" value="1"
                                    class="rounded border-gray-600 bg-slate-700">
                                <span class="text-sm text-gray-300">Active</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="btn bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-lg flex items-center justify-center font-semibold"
                        style="margin-top: 1rem;">
                        Update Coupon
                    </button>
                </form>
            </div>
        </div>

        <!-- Coupon Management -->
        <div id="coupon-management" class="module p-6">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div>
                    <div class="section-title" style="margin-bottom: 0.5rem;">Coupon Management</div>
                    <p style="color: #94a3b8; font-size: 0.875rem;">Manage discount coupons and promotional codes</p>
                </div>
                <button class="btn btn-primary" onclick="openModal('couponModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add Coupon
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
                            <th>Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Used</th>
                            <th>Expires</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coupons as $coupon)
                            <tr>
                                <td>
                                    <span class="badge bg-primary" style="font-family: monospace; font-weight: 700;">
                                        {{ $coupon->code }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight: 600;">{{ $coupon->name }}</div>
                                    @if($coupon->description)
                                    <div style="font-size: 0.875rem; color: #94a3b8;">{{ Str::limit($coupon->description, 40) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge" style="background: #6366f1;">
                                        {{ $coupon->type === 'percentage' ? 'Percentage' : 'Fixed' }}
                                    </span>
                                </td>
                                <td>
                                    <strong>
                                        @if($coupon->type === 'percentage')
                                            {{ $coupon->value }}%
                                        @else
                                            Rp {{ number_format($coupon->value, 0, ',', '.') }}
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    {{ $coupon->used_count ?? 0 }} / {{ $coupon->max_uses ?? '∞' }}
                                </td>
                                <td>
                                    @if($coupon->expires_at)
                                        {{ \Carbon\Carbon::parse($coupon->expires_at)->format('d M Y') }}
                                    @else
                                        <span style="color: #94a3b8;">No expiry</span>
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button
                                            onclick="editCoupon({{ $coupon->id }}, '{{ $coupon->code }}', '{{ addslashes($coupon->name) }}', '{{ addslashes($coupon->description ?? '') }}', '{{ $coupon->type }}', {{ $coupon->value }}, {{ $coupon->max_uses ?? 'null' }}, {{ $coupon->min_purchase ?? 0 }}, '{{ $coupon->expires_at }}', {{ $coupon->is_active ? 'true' : 'false' }})"
                                            class="btn btn-sm btn-primary">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this coupon?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-secondary">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-500">No coupons available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($coupons->hasPages())
            <div style="margin-top: 1.5rem;">
                {{ $coupons->links() }}
            </div>
            @endif
        </div>

        <style>
            .settings-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            @media (max-width: 768px) {
                .settings-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <script>
            function editCoupon(id, code, name, description, type, value, maxUses, minPurchase, expiresAt, isActive) {
                const form = document.getElementById('editCouponForm');
                form.action = `/admin/coupons/${id}`;

                document.getElementById('edit_code').value = code;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_description').value = description || '';
                document.getElementById('edit_type').value = type;
                document.getElementById('edit_value').value = value;
                document.getElementById('edit_max_uses').value = maxUses || '';
                document.getElementById('edit_min_purchase').value = minPurchase || '';

                if (expiresAt) {
                    const date = new Date(expiresAt);
                    document.getElementById('edit_expires_at').value = date.toISOString().slice(0, 16);
                }

                document.getElementById('edit_is_active').checked = isActive;

                openModal('editCouponModal');
            }
        </script>
    @endsection
</x-back-end.master>
