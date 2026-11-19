<?php
// Memanggil file koneksi database
require_once "koneksi.php";

// Memastikan data dikirim menggunakan POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form_anggota.php");
    exit;
}

// Mengambil data dari form dan membersihkan spasi
$no_anggota = isset($_POST['no_anggota']) ? trim($_POST['no_anggota']) : "";
$nama_lengkap = isset($_POST['nama_lengkap']) ? trim($_POST['nama_lengkap']) : "";
$email = isset($_POST['email']) ? trim($_POST['email']) : "";
$no_hp = isset($_POST['no_hp']) ? trim($_POST['no_hp']) : "";
$jenis_anggota = isset($_POST['jenis_anggota']) ? trim($_POST['jenis_anggota']) : "";
$alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : "";

// Menyiapkan array untuk menampung pesan kesalahan
$errors = [];

// VALIDASI NOMOR ANGGOTA
if (empty($no_anggota)) {
    $errors[] = "Nomor anggota wajib diisi.";
} elseif (!ctype_digit($no_anggota)) {
    $errors[] = "Nomor anggota hanya boleh berisi angka.";
} elseif (strlen($no_anggota) > 15) {
    $errors[] = "Nomor anggota maksimal 15 digit.";
}

// VALIDASI NAMA LENGKAP
if (empty($nama_lengkap)) {
    $errors[] = "Nama lengkap wajib diisi.";
} elseif (strlen($nama_lengkap) > 100) {
    $errors[] = "Nama lengkap maksimal 100 karakter.";
}

// VALIDASI EMAIL
if (empty($email)) {
    $errors[] = "Email wajib diisi.";
} elseif (strlen($email) > 100) {
    $errors[] = "Email maksimal 100 karakter.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

// VALIDASI NOMOR HP
if (empty($no_hp)) {
    $errors[] = "Nomor HP wajib diisi.";
} elseif (!ctype_digit($no_hp)) {
    $errors[] = "Nomor HP hanya boleh berisi angka.";
} elseif (strlen($no_hp) < 10 || strlen($no_hp) > 13) {
    $errors[] = "Nomor HP harus terdiri dari 10 sampai 13 digit.";
}

// VALIDASI JENIS ANGGOTA
if (empty($jenis_anggota)) {
    $errors[] = "Jenis anggota wajib dipilih.";
} elseif (!in_array($jenis_anggota, [
    "Mahasiswa",
    "Dosen",
    "Tenaga Kependidikan"
])) {
    $errors[] = "Jenis anggota tidak valid.";
}

// VALIDASI ALAMAT
if (empty($alamat)) {
    $errors[] = "Alamat wajib diisi.";
}

// Jika terdapat kesalahan validasi
if (!empty($errors)) {

    $pesan = implode(" ", $errors);

    header("Location: form_anggota.php?status=gagal&pesan=" . urlencode($pesan));
    exit;
}

// QUERY INSERT MENGGUNAKAN PREPARED STATEMENT
$sql = "INSERT INTO anggota
        (no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat)
        VALUES (?, ?, ?, ?, ?, ?)";

// Menyiapkan query
$stmt = mysqli_prepare($koneksi, $sql);

// Memeriksa apakah query berhasil disiapkan
if (!$stmt) {
    $pesan = "Gagal menyiapkan query: " . mysqli_error($koneksi);

    header("Location: form_anggota.php?status=gagal&pesan=" . urlencode($pesan));
    exit;
}

// Mengikat parameter ke dalam query
mysqli_stmt_bind_param(
    $stmt,
    "ssssss",
    $no_anggota,
    $nama_lengkap,
    $email,
    $no_hp,
    $jenis_anggota,
    $alamat
);

// Menjalankan query untuk menyimpan data
if (mysqli_stmt_execute($stmt)) {

    // Jika data berhasil disimpan
    mysqli_stmt_close($stmt);

    header("Location: form_anggota.php?status=berhasil");
    exit;

} else {

    // Jika data gagal disimpan
    $pesan = "Gagal menyimpan data: " . mysqli_stmt_error($stmt);

    mysqli_stmt_close($stmt);

    header("Location: form_anggota.php?status=gagal&pesan=" . urlencode($pesan));
    exit;
}
?>
