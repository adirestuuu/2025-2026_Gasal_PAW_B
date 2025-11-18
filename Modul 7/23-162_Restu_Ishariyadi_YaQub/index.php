<?php 
    require 'koneksi.php';

    $tgl_awal = '2025-01-01'; 
    $tgl_akhir = '2025-01-31'; 

    if(isset($_GET['tampilkan'])){
        $tgl_awal = $_GET['tgl_awal'];
        $tgl_akhir = $_GET['tgl_akhir'];
    }

    $query = "SELECT tanggal, COUNT(*) as jum_pelanggan, SUM(jumlah) as jumlah_pendapatan 
              FROM penjualan 
              WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' 
              GROUP BY tanggal 
              ORDER BY tanggal ASC";

    $hasil = mysqli_query($conn, $query);

    if (!$hasil) {
        die("error: " . mysqli_error($conn));
    }

    $labels = [];
    $totals = []; 
    $data_tabel = [];
    
    $pendapatan_keseluruhan = 0; 
    $pelanggan_keseluruhan = 0;  

    while ($row = mysqli_fetch_assoc($hasil)) {
        $labels[] = $row['tanggal'];
        $totals[] = $row['jumlah_pendapatan'];
        $data_tabel[] = $row;

        $pendapatan_keseluruhan += $row['jumlah_pendapatan'];
        $pelanggan_keseluruhan += $row['jum_pelanggan'];
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .filter-box { background: #f0f0f0; padding: 15px; margin-bottom: 20px; border-radius: 5px;}
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { background-color: #e0e0e0; font-weight: bold; }
        .btn { padding: 8px 15px; cursor: pointer; background: #4CAF50; color: white; border: none; text-decoration:none; display:inline-block; margin-right:5px;}
        .btn-blue { background: #008CBA; }
        .btn-red { background: #f44336; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>

    <div class="filter-box no-print">
        <form method="GET">
            <label>Dari:</label>
            <input type="date" name="tgl_awal" value="<?= $tgl_awal ?>">
            <label>Sampai:</label>
            <input type="date" name="tgl_akhir" value="<?= $tgl_akhir ?>">
            <button type="submit" name="tampilkan" class="btn">Tampilkan</button>
        </form>
    </div>

    <div class="no-print" style="margin-bottom: 10px;">
        <button onclick="window.print()" class="btn btn-red">Cetak / Print</button> 
        <a href="excel.php?tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>" class="btn btn-blue">Excel</a>
    </div>

    <h3>Grafik Penjualan</h3>
    <div style="width: 80%; margin: auto;">
        <canvas id="myChart"></canvas>
    </div>

    <h3>Rekap Laporan Penjualan</h3>
    <p>Periode: <?= $tgl_awal ?> sampai <?= $tgl_akhir ?></p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Total (Rp)</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if(count($data_tabel) > 0):
                foreach($data_tabel as $dat): 
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>Rp. <?= number_format($dat['jumlah_pendapatan']) ?></td> 
                        <td><?= date('d M Y', strtotime($dat['tanggal'])) ?></td> 
                    </tr>
                <?php endforeach; 
            else: ?>
                <tr><td colspan="3" align="center">Tidak ada data di tanggal ini</td></tr>
            <?php endif; ?>
            
            <tr class="total-row">
                <td colspan="3">Ringkasan</td>
            </tr>
            <tr>
                <td><b>Jumlah Pelanggan</b></td>
                <td colspan="2"><b>Jumlah Pendapatan</b></td>
            </tr>
            <tr>
                <td><?= $pelanggan_keseluruhan ?> Orang</td> 
                <td colspan="2">Rp. <?= number_format($pendapatan_keseluruhan) ?></td> 
            </tr>
        </tbody>
    </table>

    <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels); ?>,
                datasets: [{
                    label: 'Total Pendapatan (Rp)',
                    data: <?= json_encode($totals); ?>,
                    borderWidth: 1,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)'
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</body>
</html>