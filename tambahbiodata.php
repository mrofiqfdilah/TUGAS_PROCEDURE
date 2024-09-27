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

// Ambil daftar jurusan dari tabel `jurusan`
$query = "SELECT KodJur, NamaJur FROM jurusan";
$result = $mysqli->query($query);

// Simpan daftar jurusan dalam array
$jurusanList = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jurusanList[] = $row;
    }
}

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = $_POST['nis'];
    $kodjur = $_POST['KodJur'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nilai_akhir = $_POST['nilai_akhir'];

    // Menjalankan stored procedure TambahBiodata
    $query = "CALL TambahBiodata('$nis', '$kodjur', '$nama', '$alamat', '$nilai_akhir')";
    
    if ($mysqli->query($query)) {
        header('location: databiodata.php');
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
    <title>Tambah Biodata</title>
</head>
<body>
   <form action="" method="post">
    <input type="number" name="nis" placeholder="NIS" required><br>

    <select name="KodJur" required>
        <option value="">Pilih Jurusan</option>
        <?php foreach ($jurusanList as $jurusan): ?>
            <option value="<?= $jurusan['KodJur'] ?>"><?= $jurusan['NamaJur'] ?></option>
        <?php endforeach; ?>
    </select><br>

    <input type="text" name="nama" placeholder="Nama" required><br>
    <textarea name="alamat" placeholder="Alamat" required></textarea><br>
    <input type="number" name="nilai_akhir" placeholder="Nilai Akhir" required><br>
    <button type="submit">Submit</button>
   </form>
</body>
</html>
