<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Tertunda</title>
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
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-scaleIn { animation: scaleIn 0.5s ease-out; }
        .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
</head>
<body class="bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-50 min-h-screen font-['Inter'] flex items-center justify-center p-6">

    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-3xl shadow-2xl shadow-yellow-200/50 p-12 text-center animate-fadeInUp">

            <!-- Warning Icon -->
            <div class="mx-auto w-24 h-24 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center mb-6 animate-scaleIn">
                <svg class="w-12 h-12 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-slate-900 mb-3">Pembayaran Tertunda</h1>
            <p class="text-lg text-slate-600 mb-8">
                Pembayaran Anda belum selesai atau sedang menunggu konfirmasi. Anda dapat melanjutkan pembayaran nanti atau mencoba lagi.
            </p>

            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 mb-8">
                <p class="text-yellow-800 font-medium mb-2">
                    Apa yang harus dilakukan?
                </p>
                <ul class="text-left text-yellow-700 space-y-2 text-sm">
                    <li>• Jika Anda menggunakan transfer bank, silakan selesaikan pembayaran sesuai instruksi</li>
                    <li>• Jika Anda membatalkan pembayaran, Anda dapat mencoba lagi kapan saja</li>
                    <li>• Cek email Anda untuk instruksi pembayaran lebih lanjut</li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('student.courses.index') }}"
                   class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 active:scale-95">
                    Lihat Kursus Lain
                </a>
                <a href="{{ route('student.dashboard') }}"
                   class="bg-slate-100 text-slate-700 font-semibold px-8 py-4 rounded-xl hover:bg-slate-200 transition-all duration-300">
                    Ke Dashboard
                </a>
            </div>
        </div>
    </div>

</body>
</html>
