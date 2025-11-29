Nama : Khoirul Rosyid Gunawan
NIM  : H1H024036
Shift Awal : B
Shift Akhir : C
Responsi Pemograman Berbasis Objek

Penjelasan Detail Kode dan Aplikasi

Aplikasi PokéCare ini dibangun menggunakan PHP Native murni dan menerapkan empat pilar Object-Oriented Programming (OOP) secara konsisten. Program ini bertujuan untuk mensimulasikan pelatihan Pokémon Nidoqueen (tipe Racun/Tanah) dan mencatat riwayat perkembangannya.

1. Class Logika Pokémon

-Pokemon.php (Class Abstrak)

File ini adalah tempat dibangunnya kerangka dasar untuk semua objek Pokémon. Di dalamnya terdapat class abstrak Pokemon yang tidak dapat langsung diinstansiasi, melainkan berfungsi sebagai blueprint (cetak biru) bagi semua Pokémon spesifik. Class ini memiliki properti dasar yang wajib dimiliki oleh semua Pokémon ($nama, $tipe, $level, $hp, $hpMaksimal) yang dilindungi (Encapsulation). Untuk berinteraksi dengan properti ini, hanya diizinkan melalui getter dan setter. Lebih lanjut, class ini memiliki dua metode abstrak yang harus diimplementasikan oleh class turunan: jurusSpesial() dan bonusTipeLatihan(). Tujuannya adalah memastikan setiap tipe Pokémon memiliki cara training dan deskripsi jurus spesial yang unik, tetapi dengan struktur pemanggilan yang seragam (Polimorfisme). Metode latihan() yang ada di sini adalah tempat logika peningkatan status utama, yang menggunakan bonus dari class turunan untuk menghitung Level dan HP baru.

-NidoQueen.php (Class Turunan)

File ini berisi class PoisonGroundPokemon yang merepresentasikan Nidoqueen, yaitu turunan langsung (Inheritance) dari class abstrak Pokemon. Constructor-nya langsung menetapkan Nidoqueen dengan status awal (Level 1, HP 90, Tipe Racun/Tanah). Nidoqueen mengimplementasikan metode jurusSpesial() dengan deskripsi "Gempa Racun (Earthquake + Poison Jab)". Yang paling penting adalah implementasi metode bonusTipeLatihan(), yang secara spesifik memberikan multiplier yang lebih besar (1.4x untuk Serangan dan 1.5x untuk Pertahanan) dan 1.0x untuk Kecepatan. Multiplier ini memastikan Nidoqueen memiliki gaya pelatihan yang didorong ke arah Serangan dan Pertahanan, sesuai dengan karakteristik tipenya.

-SessionManager.php (Manajemen Data)

File ini berfungsi sebagai utility class statis yang menerapkan Encapsulation untuk mengelola data di session PHP. Tugasnya adalah menjaga agar status Pokémon (simpanPokemon(), ambilPokemon()) dan seluruh catatan riwayat latihan (tambahRiwayatLatihan(), ambilRiwayatLatihan()) tetap tersimpan dan dapat diakses antarhalaman. Ini sangat penting karena PHP adalah stateless (tidak menyimpan status), sehingga SessionManager memastikan data Pokémon tetap ada selama trainer membuka aplikasi.

2. Halaman Antarmuka Web

-index.php (Halaman Beranda)

File ini adalah halaman utama dan entry point aplikasi. Pertama, ia memulai session dan memeriksa apakah data Nidoqueen sudah ada. Jika tidak, ia akan membuat objek Nidoqueen baru dan menyimpannya. Jika sudah ada, ia mengambil data lama dan merekonstruksi objek Nidoqueen. Halaman ini bertugas menampilkan status Pokémon secara lengkap dengan visual (Level, HP, Max HP, Tipe, dan Jurus Spesial). Dari Beranda, pengguna dapat menavigasi ke halaman Latihan atau Riwayat.

-latihan.php (Halaman Training)

Halaman ini berisi formulir interaktif di mana trainer dapat memilih Jenis Latihan (Serangan, Pertahanan, Kecepatan) dan mengisi Intensitas Latihan (1-100). Setelah formulir disubmit, kode akan memanggil metode latihan() dari objek Nidoqueen, yang kemudian memicu perhitungan peningkatan Level dan HP. Hasil latihan (Level/HP sebelum dan sesudah) dicatat ke SessionManager sebagai riwayat. Halaman ini juga berfungsi sebagai output yang menampilkan alert sukses yang jelas, menunjukkan berapa Level dan HP yang berhasil ditingkatkan Nidoqueen.

-riwayat.php (Halaman Riwayat)

Tugas utama file ini adalah mengambil seluruh data riwayat latihan dari SessionManager. Riwayat tersebut kemudian ditampilkan dalam bentuk list yang rapi dan terperinci, diurutkan dari sesi terbaru. Setiap item riwayat menyajikan detail lengkap dari satu sesi pelatihan, mencakup Jenis Latihan, Intensitas, Level sebelum dan sesudah, HP sebelum dan sesudah, serta Waktu pelaksanaan.
