<?php
// Koneksi ke database menggunakan MySQLi
$host = 'localhost';
$dbname = 'siswa';
$username = 'root';
$password = '';

$mysqli = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Proses delete jika ada request POST untuk menghapus data
if (isset($_POST['delete'])) {
    $kodjur = $_POST['kodjur'];

    // Menjalankan stored procedure DeleteJurusan
    $deleteQuery = "CALL DeleteJurusan('$kodjur')";
    if ($mysqli->query($deleteQuery)) {
        echo "Jurusan dengan Kode: $kodjur berhasil dihapus!";
    } else {
        echo "Error: " . $mysqli->error;
    }
}

// Inisialisasi variabel jurusan
$jurusan = [];

// Proses pencarian jika ada request GET dengan input pencarian
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $kodjurSearch = $_GET['search'];

    // Menjalankan stored procedure TampilDataPerjurusan untuk pencarian
    $searchQuery = "CALL search_jurusan('$kodjurSearch')";
    $result = $mysqli->query($searchQuery);

    // Cek apakah ada hasil
    if ($result && $result->num_rows > 0) {
        $jurusan = $result->fetch_all(MYSQLI_ASSOC);
    }
    $result->free();
} else {
    // Jika tidak ada pencarian, jalankan stored procedure TAMPIL_JURUSAN1
    $query = "CALL TAMPIL_JURUSAN1()";
    $result = $mysqli->query($query);

    // Cek apakah ada hasil
    if ($result->num_rows > 0) {
        $jurusan = $result->fetch_all(MYSQLI_ASSOC);
    }
    $result->free();
}

// Tutup koneksi
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jurusan</title>
</head>
<body>

    <!-- Form Pencarian -->
    <form action="" method="get">
        <input type="text" id="search" name="search" placeholder="Input KodJur" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
        <button type="submit">Cari</button>
    </form>

    <button><a href="tambahjurusan.php">Tambah Data</a></button>
    
    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Kode Jurusan</th>
            <th>Nama Jurusan</th>
            <th>Ketua Jurusan</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($jurusan)): ?>
            <?php foreach ($jurusan as $index => $row): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $row['KodJur'] ?></td>
                    <td><?= $row['NamaJur'] ?></td>
                    <td><?= $row['ketua_jurusan'] ?></td>
                    <td>
                        <!-- Form untuk menghapus jurusan -->
                        <form method="POST" action="">
                            <input type="hidden" name="kodjur" value="<?= $row['KodJur'] ?>">
                            <button type="submit" name="delete" onclick="return confirm('Yakin ingin menghapus jurusan ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Tidak ada data jurusan ditemukan</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
