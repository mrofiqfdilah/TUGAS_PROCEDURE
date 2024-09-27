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

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kodjur = $_POST['KodJur'];
    $namajur = $_POST['NamaJur'];
    $ketua = $_POST['ketua_jurusan'];

    // Menjalankan stored procedure TambahBiodata
    $query = "CALL TambahJurusan('$kodjur', '$namajur', '$ketua')";
    
    if ($mysqli->query($query)) {
        header('location: datajurusan.php');
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
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="KodJur" placeholder="Kode Jurusan" id="text"><br>
        <input type="text" name="NamaJur" placeholder="Nama Jurusan" id=""><br>
        <input type="text" name="ketua_jurusan" placeholder="Ketua Jurusan" id="">
        <button type="submit">Submit</button>
    </form>
</body>
</html>