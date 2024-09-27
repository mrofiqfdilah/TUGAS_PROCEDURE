-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Sep 2024 pada 04.03
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siswa`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteBiodataByNIS` (IN `inputNIS` INT)   BEGIN
    DELETE FROM biodata
    WHERE NIS = inputNIS;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteJurusan` (IN `InputJurusan` VARCHAR(10))   BEGIN
    DELETE FROM jurusan
    WHERE KodJur = InputJurusan;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TambahBiodata` (IN `NIS` INT(11), IN `KodJur` VARCHAR(10), IN `Nama` VARCHAR(50), IN `Alamat` VARCHAR(100), IN `Nilai_Akhir` DOUBLE)   BEGIN
    INSERT INTO biodata (NIS, KodJur, Nama, Alamat, Nilai_Akhir)
    VALUES (NIS, KodJur, Nama, Alamat, Nilai_Akhir);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TambahJurusan` (IN `KodJur` VARCHAR(10), IN `NamaJur` VARCHAR(50), IN `ketua_jurusan` VARCHAR(50))  NO SQL BEGIN
    INSERT INTO jurusan (KodJur, NamaJur, ketua_jurusan)
    VALUES (KodJur, NamaJur, ketua_jurusan);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TampilDataPerjurusan` (IN `InputKodJur` VARCHAR(10))   BEGIN
    SELECT * FROM biodata
    WHERE KodJur = InputKodJur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampil_akl` ()  NO SQL BEGIN
SELECT * FROM biodata WHERE KodJur = 'AK01';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TAMPIL_BIODATA1` ()  NO SQL BEGIN
SELECT * FROM biodata;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TAMPIL_JURUSAN1` ()  NO SQL BEGIN 
SELECT * FROM `jurusan`;
END$$

--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `keterangan` (`nilai_akhir` INT(50)) RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci NO SQL BEGIN 
DECLARE keterangan varchar(50);
IF nilai_akhir > 8.5 THEN
SET keterangan:= 'baik sekali';
ELSEIF nilai_akhir >= 7.0 THEN
set keterangan:='baik';
ELSEIF nilai_akhir >= 6 THEN
SET keterangan := 'cukup';
ELSE
SET keterangan:='kurang';
END IF;
RETURN keterangan;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `biodata`
--

CREATE TABLE `biodata` (
  `NIS` int(11) NOT NULL,
  `KodJur` varchar(10) NOT NULL,
  `Nama` varchar(50) DEFAULT NULL,
  `Alamat` varchar(100) DEFAULT NULL,
  `Nilai_Akhir` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `biodata`
--

INSERT INTO `biodata` (`NIS`, `KodJur`, `Nama`, `Alamat`, `Nilai_Akhir`) VALUES
(12328, 'AK01', 'Nurul Ramadhani', 'Sampit', 7),
(12367, 'DKV01', 'Alexander', 'Palangka Raya', 7.6),
(12390, 'AK01', 'Hamzah', 'sampit', 7.7),
(12421, 'DKV01', 'Nadine', 'Sampit', 7.5),
(12425, 'DKV01', 'Rina Gunawan Astuti', 'Denpasar', 8.5),
(12553, 'RPL01', 'Rizal Samurai', 'Palangka Raya', 8.5),
(18982, 'AK01', 'Joan', 'Batu suli', 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `KodJur` varchar(10) NOT NULL,
  `NamaJur` varchar(50) DEFAULT NULL,
  `ketua_jurusan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`KodJur`, `NamaJur`, `ketua_jurusan`) VALUES
('AK01', 'Akuntansi', 'Lili ernawati S.pd'),
('DKV01', 'Desain Komunikasi Visual', 'Toyib S.Kom'),
('MLG', 'Manajemen Logistik', 'Pak Suwandi'),
('PM01', 'Pemasaran', 'Pak Roy'),
('RPL01', 'Rekayasa Perangkat Lunak', 'Juwariah, S.Pd');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `biodata`
--
ALTER TABLE `biodata`
  ADD PRIMARY KEY (`NIS`),
  ADD KEY `KodJur` (`KodJur`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`KodJur`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `biodata`
--
ALTER TABLE `biodata`
  ADD CONSTRAINT `biodata_ibfk_1` FOREIGN KEY (`KodJur`) REFERENCES `jurusan` (`KodJur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
