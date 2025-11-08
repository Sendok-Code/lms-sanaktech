<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal</title>
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
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-scaleIn { animation: scaleIn 0.5s ease-out; }
        .animate-shake { animation: shake 0.5s ease-out; }
    </style>
</head>
<body class="bg-gradient-to-br from-red-50 via-rose-50 to-pink-50 min-h-screen font-['Inter'] flex items-center justify-center p-6">

    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-3xl shadow-2xl shadow-red-200/50 p-12 text-center animate-fadeInUp">

            <!-- Error Icon -->
            <div class="mx-auto w-24 h-24 bg-gradient-to-br from-red-400 to-rose-500 rounded-full flex items-center justify-center mb-6 animate-scaleIn animate-shake">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-slate-900 mb-3">Pembayaran Gagal</h1>
            <p class="text-lg text-slate-600 mb-8">
                Maaf, terjadi kesalahan saat memproses pembayaran Anda. Silakan coba lagi.
            </p>

            <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-8">
                <p class="text-red-800 font-medium mb-2">
                    Kemungkinan penyebab:
                </p>
                <ul class="text-left text-red-700 space-y-2 text-sm">
                    <li>• Saldo atau limit kartu tidak mencukupi</li>
                    <li>• Koneksi internet terputus</li>
                    <li>• Informasi pembayaran tidak valid</li>
                    <li>• Transaksi ditolak oleh bank</li>
                </ul>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-8">
                <p class="text-blue-800 text-sm">
                    <strong>Tips:</strong> Pastikan Anda memiliki saldo yang cukup dan koneksi internet yang stabil sebelum mencoba lagi.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button
                    onclick="window.history.back()"
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                    Coba Lagi
                </button>
                <a href="{{ route('student.courses.index') }}"
                   class="bg-slate-100 text-slate-700 font-semibold px-8 py-4 rounded-xl hover:bg-slate-200 transition-all duration-300">
                    Lihat Kursus Lain
                </a>
            </div>

            <p class="text-sm text-slate-500 mt-8">
                Jika masalah terus berlanjut, silakan hubungi customer service kami.
            </p>
        </div>
    </div>

</body>
</html>
