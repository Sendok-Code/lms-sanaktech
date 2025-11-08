<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NextVision Marketing Consulting</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-50 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow-md fixed w-full z-10 top-0">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-blue-700">NextVision</h1>
      <ul class="hidden md:flex space-x-8">
        <li><a href="#about" class="hover:text-blue-600">Tentang</a></li>
        <li><a href="#services" class="hover:text-blue-600">Layanan</a></li>
        <li><a href="#testimonials" class="hover:text-blue-600">Testimoni</a></li>
        <li><a href="#contact" class="hover:text-blue-600">Kontak</a></li>
      </ul>
      <a href="#contact" class="hidden md:block bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">Hubungi Kami</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-gradient-to-r from-blue-700 to-green-500 text-white min-h-screen flex items-center justify-center text-center px-6">
    <div>
      <h2 class="text-4xl md:text-6xl font-bold mb-4">Tingkatkan Bisnis Anda Bersama Ahli Marketing</h2>
      <p class="text-lg md:text-xl mb-6">Kami bantu bisnis Anda tumbuh melalui strategi pemasaran berbasis data dan inovasi digital.</p>
      <a href="#contact" class="bg-white text-blue-700 font-semibold px-6 py-3 rounded-full hover:bg-gray-200 transition">Konsultasi Gratis</a>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-20 max-w-7xl mx-auto px-6">
    <div class="text-center mb-12">
      <h3 class="text-3xl font-bold mb-2">Tentang Kami</h3>
      <p class="text-gray-600 max-w-2xl mx-auto">NextVision adalah perusahaan konsultan marketing yang berfokus membantu bisnis tumbuh dengan strategi digital yang tepat sasaran dan efisien.</p>
    </div>
    <div class="grid md:grid-cols-2 gap-12 items-center">
      <img src="https://images.unsplash.com/photo-1600880292089-90e6a1a0b8c9?auto=format&fit=crop&w=800&q=80" alt="Marketing Team" class="rounded-2xl shadow-lg">
      <div>
        <h4 class="text-2xl font-bold mb-4 text-blue-700">Kami Fokus pada Hasil Nyata</h4>
        <p class="text-gray-700 mb-4">Kami percaya setiap bisnis unik. Itulah sebabnya strategi kami selalu disesuaikan agar sesuai dengan kebutuhan dan tujuan spesifik klien.</p>
        <p class="text-gray-700">Dengan tim ahli di bidang digital marketing, brand strategy, dan analisis pasar, kami siap membawa bisnis Anda ke level berikutnya.</p>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section id="services" class="bg-gray-100 py-20">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h3 class="text-3xl font-bold mb-12">Layanan Kami</h3>
      <div class="grid md:grid-cols-3 gap-10">
        <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
          <h4 class="text-xl font-semibold mb-3 text-blue-700">Digital Marketing</h4>
          <p class="text-gray-600">Strategi pemasaran digital untuk meningkatkan visibilitas dan penjualan bisnis Anda.</p>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
          <h4 class="text-xl font-semibold mb-3 text-blue-700">Brand Strategy</h4>
          <p class="text-gray-600">Membangun identitas merek yang kuat dan berkesan bagi target pasar Anda.</p>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
          <h4 class="text-xl font-semibold mb-3 text-blue-700">SEO & Analytics</h4>
          <p class="text-gray-600">Optimasi website dan analisis data untuk mengukur dan meningkatkan performa bisnis Anda.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimonials" class="py-20 max-w-7xl mx-auto px-6 text-center">
    <h3 class="text-3xl font-bold mb-12">Apa Kata Klien Kami</h3>
    <div class="grid md:grid-cols-3 gap-10">
      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="italic text-gray-600 mb-4">"NextVision membantu kami meningkatkan penjualan online hingga 300%! Timnya profesional dan komunikatif."</p>
        <h5 class="font-semibold text-blue-700">– PT Sinar Abadi</h5>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="italic text-gray-600 mb-4">"Strateginya luar biasa. Kami jadi lebih memahami perilaku konsumen dan bisa mengoptimalkan iklan digital."</p>
        <h5 class="font-semibold text-blue-700">– CV Global Indo</h5>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow">
        <p class="italic text-gray-600 mb-4">"Tim mereka sangat responsif dan hasilnya nyata. Trafik website kami meningkat drastis."</p>
        <h5 class="font-semibold text-blue-700">– BrightTech</h5>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section id="contact" class="bg-gradient-to-r from-green-500 to-blue-700 text-white py-20">
    <div class="max-w-5xl mx-auto text-center px-6">
      <h3 class="text-3xl font-bold mb-6">Hubungi Kami</h3>
      <p class="mb-8">Ingin konsultasi gratis? Kirim pesan Anda sekarang.</p>
      <form class="grid md:grid-cols-2 gap-6 text-left max-w-3xl mx-auto">
        <input type="text" placeholder="Nama" class="p-3 rounded text-gray-800">
        <input type="email" placeholder="Email" class="p-3 rounded text-gray-800">
        <textarea placeholder="Pesan Anda" rows="4" class="md:col-span-2 p-3 rounded text-gray-800"></textarea>
        <button class="md:col-span-2 bg-white text-blue-700 font-semibold px-6 py-3 rounded-lg hover:bg-gray-200 transition">Kirim Pesan</button>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white text-center py-6">
    <p>© 2025 NextVision Marketing Consulting. All rights reserved.</p>
  </footer>

</body>
</html>
