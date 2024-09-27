<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'siswa';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cek apakah input kodjur ada
    if (isset($_GET['kodjur'])) {
        $kodjur = $_GET['kodjur'];

        // Prepare dan execute query untuk memanggil stored procedure
        $stmt = $pdo->prepare("CALL tampilDataPerjurusan(:kodjur)");
        $stmt->bindParam(':kodjur', $kodjur);
        $stmt->execute();

        // Ambil hasil query
        $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $hasil = [];
    }
} catch (PDOException $e) {
    echo "Koneksi atau query error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
    <li><a href="index.php">Data Perjurusan</a></li>
        <li><a href="datajurusan.php">Data Jurusan</a></li>
        <li><a href="databiodata.php">Data Biodata</a></li>
    </ul>
    <form action="" method="GET">
        <input type="text" name="kodjur" placeholder="Masukkan Kodjur"><br>
        <input type="submit" value="Cari">
    </form>

    <table border="1">
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>KodJur</th>
            <th>Nama Siswa</th>
            <th>Alamat</th>
            <th>Nilai Akhir</th>
        </tr>
        <?php if (!empty($hasil)): ?>
            <?php foreach ($hasil as $index => $row): ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= $row['NIS']; ?></td>
                    <td><?= $row['KodJur']; ?></td>
                    <td><?= $row['Nama']; ?></td>
                    <td><?= $row['Alamat']; ?></td>
                    <td><?= $row['Nilai_Akhir']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Tidak ada data ditemukan</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
