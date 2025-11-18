<?php 
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=Laporan_Penjualan.xls");

    require 'koneksi.php';

    $tgl_awal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '2025-01-01';
    $tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '2025-01-31';

    $query = "SELECT tanggal, COUNT(*) as jum_pelanggan, SUM(jumlah) as jumlah_pendapatan 
              FROM penjualan 
              WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' 
              GROUP BY tanggal 
              ORDER BY tanggal ASC";

    $hasil = mysqli_query($conn, $query);
    
    if (!$hasil) {
        die("Query Error: " . mysqli_error($conn));
    }

    $data_tabel = [];
    $pendapatan_keseluruhan = 0;
    $pelanggan_keseluruhan = 0;

    while ($row = mysqli_fetch_assoc($hasil)) {
        $data_tabel[] = $row;
        $pendapatan_keseluruhan += $row['jumlah_pendapatan'];
        $pelanggan_keseluruhan += $row['jum_pelanggan'];
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan excel</title>
</head>
<body>
    <h3>Rekap laporan penjualan <?= $tgl_awal ?> - <?= $tgl_akhir ?></h3>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach($data_tabel as $dat): 
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>Rp. <?= $dat['jumlah_pendapatan'] ?></td>
                    <td><?= $dat['tanggal'] ?></td>
                </tr>
            <?php endforeach; ?>
            <tr><td></td><td></td><td></td></tr>
            <tr>
                <td><b>Jumlah Pelanggan</b></td>
                <td colspan="2"><b>Jumlah Pendapatan</b></td>
            </tr>
            <tr>
                <td><?= $pelanggan_keseluruhan ?> Orang</td>
                <td colspan="2">Rp. <?= $pendapatan_keseluruhan ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>