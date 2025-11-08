<!DOCTYPE html>
<html>
<head>
    <title>Test Simple Form</title>
    <style>
        body {
            background: #0f172a;
            color: white;
            font-family: Arial, sans-serif;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #1e293b;
            padding: 30px;
            border-radius: 12px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background: #334155;
            border: 1px solid #475569;
            color: white;
            border-radius: 6px;
            font-size: 16px;
        }
        button {
            padding: 12px 24px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        button:hover {
            background: #2563eb;
        }
        .success {
            background: #10b981;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test Simple Form</h1>
        <p style="color: #94a3b8;">Form super simple untuk test apakah form submission bekerja.</p>

        @if (session('success'))
            <div class="success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <label>Nama Website:</label>
            <input type="text" name="site_name" value="{{ \App\Models\Setting::get('site_name', 'MyLMS') }}" required>

            <label>Deskripsi:</label>
            <textarea name="site_description" rows="3">{{ \App\Models\Setting::get('site_description', '') }}</textarea>

            <button type="submit">💾 Simpan</button>
        </form>

        <hr style="margin: 30px 0; border-color: #334155;">

        <p style="font-size: 14px; color: #94a3b8;">
            <strong>Instruksi:</strong><br>
            1. Ubah nama website<br>
            2. Klik tombol "Simpan"<br>
            3. Jika muncul pesan sukses hijau, berarti form berhasil submit!
        </p>

        <a href="{{ route('admin.settings.index') }}" style="color: #3b82f6;">← Kembali ke Settings Normal</a>
    </div>
</body>
</html>
