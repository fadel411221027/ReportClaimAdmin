<!DOCTYPE html>
<html data-theme="" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png"/>
    <title>RCA</title>

    <!-- Fonts -->

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="">

    <main data-theme="" class="rounded-md border-accent">
        {{ $slot }}
    </main>

</body>
<script>
    const themeSelector = document.getElementById('theme-selector');

// Load theme on page load
document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') ||
    'autumn'); // 'default' is the fallback

themeSelector.addEventListener('change', function() {
    const selectedTheme = this.value;
    document.documentElement.setAttribute('data-theme', selectedTheme);
    localStorage.setItem('theme', selectedTheme);
});
 // Auto dismiss error alert after 5 seconds
setTimeout(function() {
    const alert = document.querySelector('.bg-red-50');
    if (alert) {
        alert.style.transition = 'opacity 0.5s ease-out';
        alert.style.opacity = '0';
        setTimeout(function() {
            alert.style.display = 'none';
        }, 500);
    }
}, 5000);

// Fungsi untuk menentukan salam berdasarkan waktu
function getGreeting() {
    const hour = new Date().getHours();
    if (hour < 12) {
        return "Selamat Pagi!";
    } else if (hour < 15) {
        return "Selamat Siang!";
    } else if (hour < 18) {
        return "Selamat Sore!";
    } else {
        return "Selamat Malam!";
    }
}

// Daftar kutipan yang berbeda dengan <br> untuk pemisahan
const quotes = [
   "Jangan pernah ragu untuk bermimpi besar.",
    "Setiap hari adalah kesempatan baru untuk jadi lebih baik.",
    "Kalo bukan kita yang mulai, siapa lagi?.",
    "Hidup ini tentang perjalanan, bukan hanya tujuan.",
    "Jangan biarkan orang lain mendefinisikan batasanmu.",
    "Kegagalan itu hanya batu loncatan menuju kesuksesan.",
    "Bersyukur itu kunci, meski dalam keadaan sulit.",
    "Jadilah orang yang menginspirasi, bukan yang mengeluh.",
    "Kreativitas itu kekuatan, jangan takut untuk berinovasi.",
    "Temukan passionmu dan kejar tanpa henti.",
    "Sahabat sejati itu yang selalu mendukungmu.",
    "Jangan lupa untuk menikmati prosesnya.",
    "Setiap detik berharga, jangan sia-siakan.",
    "Berani keluar dari zona nyaman, itu langkah awal.",
    "Kita semua punya cerita, tulislah yang terbaik.",
    "Jangan cuma jadi penonton, jadi pemain yang bikin cerita!",
    "Hidup itu kayak kopi, kadang pahit, kadang manis, tapi tetap nikmat!",
    "Jangan takut gagal, karena dari situ kita belajar untuk jadi lebih baik.",
    "Setiap langkah kecil itu berarti, yang penting terus jalan!",
    "Kita semua punya potensi, tinggal gimana kita nge-gali dan maksimalkan!",
    "Jadilah versi terbaik dari dirimu, bukan versi orang lain!",
    "Biar lambat asal selamat, yang penting konsisten!",
    "Sukses itu bukan tentang seberapa cepat, tapi seberapa kuat kita bertahan!",
    "Setiap langkah yang kita ambil adalah bagian dari perjalanan.",
    "Jangan takut untuk bermimpi, karena mimpi adalah awal dari segalanya.",
    "Hidup ini penuh warna, nikmati setiap nuansa yang ada.",
    "Kita semua punya cerita, tuliskan kisah terbaikmu.",
    "Ketika jatuh, bangkitlah lagi, karena setiap kegagalan adalah pelajaran.",
    "Jadilah dirimu sendiri, karena keunikanmu adalah kekuatanmu.",
    "Cinta dan harapan adalah bahan bakar untuk terus melangkah.",
    "Jangan biarkan keraguan menghentikan langkahmu.",
    "Setiap detik berharga, jangan sia-siakan dengan hal yang tidak berarti.",
    "Kita bisa melewati badai, asalkan kita tetap bersatu.",
    "Hidup ini seperti lagu, kadang ada nada tinggi, kadang nada rendah.",
    "Jangan lupa untuk bersyukur, meski dalam keadaan sulit.",
    "Kita adalah penulis cerita hidup kita sendiri.",
    "Jangan pernah berhenti berusaha, karena usaha tidak akan mengkhianati hasil.",
    "Setiap hari adalah kesempatan baru untuk menjadi lebih baik.",
];

// Memilih kutipan secara acak, dengan pengecualian untuk malam
function getRandomQuote(greeting) {
    if (greeting === "Selamat Malam!") {
        return "Sudah malam, kok belum pulang?";
    }
    return quotes[Math.floor(Math.random() * quotes.length)];
}

// Menampilkan salam dan kutipan
const greeting = getGreeting();
document.getElementById("greeting").innerText = greeting;
document.getElementById("quote").innerHTML = getRandomQuote(greeting);
</script>

</html>
