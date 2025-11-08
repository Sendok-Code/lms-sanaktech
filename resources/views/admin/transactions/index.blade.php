<x-back-end.master>
    @section('content')
        <!-- Transaction Management -->
        <div id="transaction-management" class="module p-6">
            <div style="margin-bottom: 1.5rem;">
                <div class="section-title" style="margin-bottom: 0.5rem;">Payment Transactions</div>
                <p style="color: #94a3b8; font-size: 0.875rem;">View all payment transactions and order history</p>
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
                            <th>Order ID</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary" style="font-family: monospace;">{{ $payment->order_id }}</span>
                                </td>
                                <td>
                                    <div style="font-weight: 600;">{{ $payment->user->name }}</div>
                                    <div style="font-size: 0.875rem; color: #94a3b8;">{{ $payment->user->email }}</div>
                                </td>
                                <td>
                                    @if($payment->enrollment && $payment->enrollment->course)
                                        <span class="badge bg-primary">{{ $payment->enrollment->course->title }}</span>
                                    @else
                                        <span class="badge bg-secondary">No Course</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if($payment->status === 'paid' || $payment->status === 'settlement')
                                        <span class="badge bg-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 0.25rem;">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                            </svg>
                                            Success
                                        </span>
                                    @elseif($payment->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($payment->status === 'failed' || $payment->status === 'expire')
                                        <span class="badge" style="background: #dc2626;">Failed</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $payment->payment_type ?? '-' }}
                                </td>
                                <td>
                                    {{ $payment->created_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">No transactions available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
            <div style="margin-top: 1.5rem;">
                {{ $payments->links() }}
            </div>
            @endif
        </div>
    @endsection
</x-back-end.master>
