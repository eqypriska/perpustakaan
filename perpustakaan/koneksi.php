<!-- Menguji Koneksi Database
Nama: Eqy Priska Rahmadhani
Kelas: TI 2D
NIM: 250202105 -->

<?php
// koneksi.php - Menghubungkan PHP dengan database MySQL

$host = "localhost";
$username = "root";
$password = "";
$database = "db_perpustakaan";

// Membuat koneksi ke database
$koneksi = mysqli_connect(
    $host,
    $username,
    $password,
    $database
);

// Memeriksa kesalahan koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
