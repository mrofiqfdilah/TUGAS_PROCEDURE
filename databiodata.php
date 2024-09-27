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

// Menjalankan stored procedure
$query = "CALL TAMPIL_BIODATA1()";
$result = $mysqli->query($query);

// Cek apakah ada hasil
if ($result->num_rows > 0) {
    $biodata = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $biodata = [];
}

// Free result set sebelum melakukan query lain
$result->free();

// Tutup prosedur saat ini untuk sinkronisasi
$mysqli->next_result();

if (isset($_POST['delete'])) {
    $nis = $_POST['nis']; // Pastikan ini sesuai dengan input name di form

    $deleteQuery = "CALL DeleteBiodataByNis('$nis')";
    if ($mysqli->query($deleteQuery)) {
        header('location: databiodata.php'); // Redirect setelah delete berhasil
    } else {
        echo "Error: " . $mysqli->error;
    }
}

// Tutup koneksi
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Biodata</title>
</head>
<body>
    <button><a href="tambahbiodata.php">Tambah Data</a></button>
    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Nis</th>
            <th>Kode Jurusan</th>
            <th>Nama Siswa</th>
            <th>Alamat</th>
            <th>Nilai Akhir</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($biodata)): ?>
            <?php foreach ($biodata as $index => $row): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $row['NIS'] ?></td>
                    <td><?= $row['KodJur'] ?></td>
                    <td><?= $row['Nama'] ?></td>
                    <td><?= $row['Alamat'] ?></td>
                    <td><?= $row['Nilai_Akhir'] ?></td>
                    <td>
                  
    <form method="POST" action="">
        <input type="hidden" name="nis" value="<?= $row['NIS'] ?>">
        <button type="submit" name="delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</button>
    </form>
</td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Tidak ada data biodata ditemukan</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
