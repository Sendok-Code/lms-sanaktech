<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        @keyframes checkmark {
            0% {
                stroke-dashoffset: 100;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-scaleIn { animation: scaleIn 0.5s ease-out; }
        .checkmark-path {
            stroke-dasharray: 100;
            animation: checkmark 0.8s ease-out 0.3s forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 min-h-screen font-['Inter'] flex items-center justify-center p-6">

    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-3xl shadow-2xl shadow-green-200/50 p-12 text-center animate-fadeInUp">

            <!-- Success Icon -->
            <div class="mx-auto w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mb-6 animate-scaleIn">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path class="checkmark-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-slate-900 mb-3">Pembayaran Berhasil!</h1>
            <p class="text-lg text-slate-600 mb-8">
                Terima kasih atas pembelian Anda. Sekarang Anda dapat mengakses kursus yang telah dibeli.
            </p>

            @if($payment->status === 'paid')
                <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-8">
                    <div class="space-y-3 text-left">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Order ID</span>
                            <span class="font-mono text-slate-900">{{ $payment->order_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Status</span>
                            <span class="font-semibold text-green-600">Paid</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Metode Pembayaran</span>
                            <span class="font-semibold text-slate-900">{{ strtoupper($payment->payment_method ?? 'N/A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Total</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if($payment->metadata && isset($payment->metadata['course_id']))
                        @php
                            $course = \App\Models\Course::find($payment->metadata['course_id']);
                        @endphp
                        @if($course)
                            <a href="{{ route('student.courses.show', $course->slug) }}"
                               class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                                Mulai Belajar
                            </a>
                        @endif
                    @endif
                    <a href="{{ route('student.dashboard') }}"
                       class="bg-slate-100 text-slate-700 font-semibold px-8 py-4 rounded-xl hover:bg-slate-200 transition-all duration-300">
                        Ke Dashboard
                    </a>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 mb-8">
                    <p class="text-yellow-800">
                        Pembayaran Anda sedang diproses. Silakan tunggu konfirmasi.
                    </p>
                </div>

                <a href="{{ route('student.dashboard') }}"
                   class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                    Kembali ke Dashboard
                </a>
            @endif
        </div>
    </div>

</body>
</html>
