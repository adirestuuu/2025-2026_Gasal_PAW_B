<?php
require "koneksi.php";


$sql_create_transaksi = "
CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nama_pelanggan` varchar(100) NOT NULL,
  `total_bayar` int NOT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB;
";

if (mysqli_query($conn, $sql_create_transaksi)) {
    echo "sukses";
} else {
    echo "error: " . mysqli_error($conn);
}

$sql_create_detail = "
CREATE TABLE `detail_transaksi` (
  `id_detail` int NOT NULL AUTO_INCREMENT,
  `id_transaksi` int NOT NULL,
  `id_buku` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga_saat_transaksi` int NOT NULL,
  PRIMARY KEY (`id_detail`)
) ENGINE=InnoDB;
";

if (mysqli_query($conn, $sql_create_detail)) {
    echo "sukses";
} else {
    echo "error: " . mysqli_error($conn);
}

mysqli_close($conn);

?>