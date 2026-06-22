<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport"/>
    <title>Privacy Policy - LajuPesan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="max-w-3xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Kebijakan Privasi (Privacy Policy)</h1>
        <p class="mb-4 text-sm text-gray-500">Terakhir diperbarui: {{ date('d F Y') }}</p>

        <div class="prose prose-blue">
            <p>Selamat datang di LajuPesan. Kami menghargai privasi Anda dan berkomitmen untuk melindungi data Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan membagikan informasi Anda saat Anda menggunakan aplikasi kami.</p>

            <h2 class="text-xl font-semibold mt-8 mb-4">1. Informasi yang Kami Kumpulkan</h2>
            <p class="font-semibold mt-4 mb-2">a. Data Pemilik Toko (saat mendaftar akun):</p>
            <ul class="list-disc pl-5 mb-4">
                <li>Logo toko</li>
                <li>Nama toko</li>
                <li>Username</li>
                <li>Alamat email</li>
                <li>Nomor telepon toko</li>
                <li>Alamat toko dan tautan Google Maps</li>
                <li>Jam operasional toko (jam buka dan tutup)</li>
                <li>Data produk (nama produk, harga, foto, kategori)</li>
            </ul>
            <p class="font-semibold mt-4 mb-2">b. Data Pelanggan Toko (saat melakukan pemesanan):</p>
            <ul class="list-disc pl-5 mb-4">
                <li>Nama pelanggan</li>
                <li>Nomor HP pelanggan</li>
                <li>Nomor meja</li>
                <li>Detail pesanan dan metode pembayaran</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8 mb-4">2. Bagaimana Kami Menggunakan Informasi Anda</h2>
            <p>Informasi yang kami kumpulkan digunakan untuk:</p>
            <ul class="list-disc pl-5 mb-4">
                <li>Menyediakan, memelihara, dan meningkatkan layanan platform menu digital kami.</li>
                <li>Membuat halaman toko dan menu digital yang dapat diakses oleh pelanggan Anda melalui QR code.</li>
                <li>Memproses transaksi pembayaran dan mengirimkan pemberitahuan terkait pesanan.</li>
                <li>Mengelola akun pengguna dan menyediakan dukungan pelanggan.</li>
                <li>Mengirimkan kode OTP untuk verifikasi email.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8 mb-4">3. Pembagian Informasi</h2>
            <p>Kami tidak menjual atau menyewakan informasi Anda kepada pihak ketiga. Kami hanya membagikan informasi jika diperlukan untuk:</p>
            <ul class="list-disc pl-5 mb-4">
                <li>Memproses pembayaran melalui payment gateway (Midtrans).</li>
                <li>Menampilkan informasi toko Anda (nama toko, logo, alamat, menu, dan jam operasional) secara publik pada halaman menu digital yang Anda buat.</li>
                <li>Mematuhi kewajiban hukum atau peraturan yang berlaku.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8 mb-4">4. Penyimpanan dan Keamanan Data</h2>
            <p>Kami mengambil langkah-langkah keamanan yang wajar untuk melindungi informasi Anda dari akses yang tidak sah, perubahan, pengungkapan, atau penghancuran. Kata sandi Anda disimpan dalam bentuk terenkripsi (hashed) dan tidak dapat dibaca oleh siapa pun termasuk tim kami.</p>

            <h2 class="text-xl font-semibold mt-8 mb-4">5. Hak Pengguna</h2>
            <p>Anda memiliki hak untuk:</p>
            <ul class="list-disc pl-5 mb-4">
                <li>Mengakses dan memperbarui informasi toko Anda kapan saja melalui dashboard.</li>
                <li>Meminta penghapusan akun dan data Anda dengan menghubungi kami.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8 mb-4">6. Cookie dan Teknologi Pelacakan</h2>
            <p>Kami menggunakan cookie untuk menjaga sesi login Anda dan menyimpan preferensi pengguna. Cookie ini diperlukan agar layanan dapat berfungsi dengan baik.</p>

            <h2 class="text-xl font-semibold mt-8 mb-4">7. Perubahan pada Kebijakan Ini</h2>
            <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Kami akan memberi tahu Anda tentang perubahan signifikan melalui email atau pemberitahuan di dalam aplikasi. Penggunaan layanan secara berkelanjutan setelah perubahan merupakan persetujuan Anda terhadap kebijakan yang diperbarui.</p>

            <h2 class="text-xl font-semibold mt-8 mb-4">8. Hubungi Kami</h2>
            <p>Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami:</p>
            <ul class="list-disc pl-5 mb-4">
                <li>Email: lajupesan@gmail.com</li>
                <li>Website: <a href="https://lajupesan.com" class="text-blue-600 hover:underline">https://lajupesan.com</a></li>
            </ul>
        </div>

        <div class="mt-12">
            <a href="{{ url('/') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
