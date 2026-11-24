<?php
require_once "koneksi.php";

$query = mysqli_query($koneksi, "SELECT * FROM anggota");
$data_anggota = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Anggota</title>
</head>
<body>

    <h2>Daftar Anggota Perpustakaan</h2>
    <a href="form_anggota.php">+ Tambah Data</a>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>No Anggota</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Jenis Anggota</th>
            <th>Alamat</th>
        </tr>

        <?php
        $no = 1;
        foreach ($data_anggota as $anggota) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $anggota['no_anggota'] . "</td>";
            echo "<td>" . $anggota['nama_lengkap'] . "</td>";
            echo "<td>" . $anggota['email'] . "</td>";
            echo "<td>" . $anggota['no_hp'] . "</td>";
            echo "<td>" . $anggota['jenis_anggota'] . "</td>";
            echo "<td>" . $anggota['alamat'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>
</html>