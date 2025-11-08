<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - {{ $course->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-fadeInLeft { animation: fadeInLeft 0.8s ease-out; }
        .animate-fadeInRight { animation: fadeInRight 0.8s ease-out; }
        .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen font-['Inter']">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-lg border-b border-slate-200/50 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="text-2xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    LMS Platform
                </a>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-600">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-12">
        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Left Column - Customer Form -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Back Button -->
                <a href="{{ route('student.courses.show', $course->slug) }}" class="inline-flex items-center text-slate-600 hover:text-blue-600 transition-colors animate-fadeInLeft">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Detail Kursus
                </a>

                <!-- Customer Information -->
                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-8 animate-fadeInUp">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Informasi Pembeli</h2>

                    <form id="checkoutForm" class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Lengkap
                            </label>
                            <input
                                type="text"
                                name="first_name"
                                id="first_name"
                                value="{{ auth()->user()->name }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ auth()->user()->email }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input
                                type="tel"
                                name="phone"
                                id="phone"
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all"
                                required
                            >
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-8 sticky top-24 animate-fadeInRight">
                    <h2 class="text-xl font-bold text-slate-900 mb-6">Ringkasan Pesanan</h2>

                    <!-- Course Info -->
                    <div class="space-y-4 mb-6 pb-6 border-b border-slate-200">
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Kursus</p>
                            <p class="font-semibold text-slate-900">{{ $course->title }}</p>
                        </div>

                        @if($course->instructor)
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Instruktur</p>
                            <p class="text-slate-700">{{ $course->instructor->name }}</p>
                        </div>
                        @endif

                        @if($course->category)
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Kategori</p>
                            <p class="text-slate-700">{{ $course->category->name }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Coupon Code -->
                    <div class="mb-6 pb-6 border-b border-slate-200">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Kode Kupon (Opsional)
                        </label>
                        <div class="flex gap-2">
                            <input
                                type="text"
                                id="coupon_code"
                                placeholder="Masukkan kode kupon"
                                class="flex-1 px-4 py-2 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all text-sm"
                            >
                            <button
                                onclick="applyCoupon()"
                                id="applyCouponBtn"
                                class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-all text-sm"
                            >
                                Terapkan
                            </button>
                        </div>
                        <div id="couponMessage" class="mt-2 text-sm"></div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-6 pb-6 border-b border-slate-200">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Subtotal</span>
                            <span class="font-semibold text-slate-900" id="subtotalDisplay">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                        </div>
                        <div id="discountRow" class="hidden flex justify-between text-green-600">
                            <span>Diskon</span>
                            <span class="font-semibold" id="discountDisplay">- Rp 0</span>
                        </div>
                        <div id="taxRow" class="flex justify-between">
                            <span class="text-slate-600">Pajak (<span id="taxRateDisplay">11</span>%)</span>
                            <span class="font-semibold text-slate-900" id="taxDisplay">Rp {{ number_format(($course->price * 11) / 100, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-lg font-bold text-slate-900">Total</span>
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent" id="totalDisplay">
                            Rp {{ number_format($course->price + (($course->price * 11) / 100), 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Payment Button -->
                    <button
                        onclick="processPayment()"
                        id="payButton"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-4 rounded-xl hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95"
                    >
                        Bayar Sekarang
                    </button>

                    <p class="text-xs text-center text-slate-500 mt-4">
                        Pembayaran aman dengan Midtrans
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                <p class="mt-4 text-slate-700 font-medium">Memproses pembayaran...</p>
            </div>
        </div>
    </div>

    <script>
        let appliedCoupon = null;

        function applyCoupon() {
            const couponCode = document.getElementById('coupon_code').value.trim();
            const messageDiv = document.getElementById('couponMessage');
            const applyBtn = document.getElementById('applyCouponBtn');

            if (!couponCode) {
                messageDiv.className = 'mt-2 text-sm text-red-600';
                messageDiv.textContent = 'Mohon masukkan kode kupon';
                return;
            }

            applyBtn.disabled = true;
            applyBtn.textContent = 'Memproses...';
            messageDiv.textContent = '';

            fetch('{{ route('payments.validateCoupon', $course->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ coupon_code: couponCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    appliedCoupon = couponCode;
                    messageDiv.className = 'mt-2 text-sm text-green-600 font-medium';
                    messageDiv.textContent = '✓ ' + data.message;

                    // Update price breakdown
                    document.getElementById('subtotalDisplay').textContent = 'Rp ' + formatNumber(data.pricing.subtotal);
                    document.getElementById('discountDisplay').textContent = '- Rp ' + formatNumber(data.pricing.discount);
                    document.getElementById('taxRateDisplay').textContent = data.pricing.tax_rate;
                    document.getElementById('taxDisplay').textContent = 'Rp ' + formatNumber(data.pricing.tax);
                    document.getElementById('totalDisplay').textContent = 'Rp ' + formatNumber(data.pricing.total);

                    // Show discount row
                    document.getElementById('discountRow').classList.remove('hidden');
                    document.getElementById('discountRow').classList.add('flex');

                    // Update button
                    applyBtn.textContent = 'Diterapkan';
                    applyBtn.classList.remove('bg-slate-100', 'hover:bg-slate-200');
                    applyBtn.classList.add('bg-green-100', 'text-green-700');
                    document.getElementById('coupon_code').disabled = true;
                } else {
                    messageDiv.className = 'mt-2 text-sm text-red-600';
                    messageDiv.textContent = '✗ ' + data.message;
                    applyBtn.disabled = false;
                    applyBtn.textContent = 'Terapkan';
                }
            })
            .catch(error => {
                messageDiv.className = 'mt-2 text-sm text-red-600';
                messageDiv.textContent = 'Terjadi kesalahan saat memvalidasi kupon';
                applyBtn.disabled = false;
                applyBtn.textContent = 'Terapkan';
            });
        }

        function formatNumber(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function processPayment() {
            // Validate form
            const firstName = document.getElementById('first_name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;

            if (!firstName || !email || !phone) {
                alert('Mohon lengkapi semua data');
                return;
            }

            // Show loading
            document.getElementById('loadingOverlay').classList.remove('hidden');
            document.getElementById('payButton').disabled = true;

            // Prepare data
            const data = {
                customer_details: {
                    first_name: firstName,
                    email: email,
                    phone: phone
                }
            };

            // Add coupon if applied
            if (appliedCoupon) {
                data.coupon_code = appliedCoupon;
            }

            // Send request to backend
            fetch('{{ route('payments.process', $course->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Open Midtrans Snap
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '{{ route('payments.finish') }}?order_id=' + data.order_id;
                        },
                        onPending: function(result) {
                            window.location.href = '{{ route('payments.unfinish') }}?order_id=' + data.order_id;
                        },
                        onError: function(result) {
                            window.location.href = '{{ route('payments.error') }}?order_id=' + data.order_id;
                        },
                        onClose: function() {
                            document.getElementById('loadingOverlay').classList.add('hidden');
                            document.getElementById('payButton').disabled = false;
                        }
                    });
                } else {
                    alert(data.message || 'Terjadi kesalahan');
                    document.getElementById('loadingOverlay').classList.add('hidden');
                    document.getElementById('payButton').disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses pembayaran');
                document.getElementById('loadingOverlay').classList.add('hidden');
                document.getElementById('payButton').disabled = false;
            });
        }
    </script>
</body>
</html>
