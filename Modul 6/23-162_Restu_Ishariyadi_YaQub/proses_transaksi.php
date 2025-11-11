<?php
require "koneksi.php";

$pesan_sukses = "";
$pesan_error = "";
$total_keseluruhan_bayar = 0;

if (isset($_POST['submit'])) {
    
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $id_buku_array  = $_POST['id_buku'];
    $jumlah_array   = $_POST['jumlah'];

    $semua_query_berhasil = true;
    
    mysqli_begin_transaction($conn);

    $sql_master = "INSERT INTO transaksi (nama_pelanggan, total_bayar) 
                   VALUES ('$nama_pelanggan', 0)";
    
    $query_master = mysqli_query($conn, $sql_master);

    if (!$query_master) {
        $semua_query_berhasil = false;
        $pesan_error = "Gagal menyimpan data master: " . mysqli_error($conn);
    } else {
        
        $id_transaksi_baru = mysqli_insert_id($conn);

        for ($i = 0; $i < count($id_buku_array); $i++) {
            
            $id_buku = $id_buku_array[$i];
            $jumlah  = $jumlah_array[$i];

            $sql_ambil_harga = "SELECT harga FROM buku WHERE id_buku = $id_buku";
            $query_harga = mysqli_query($conn, $sql_ambil_harga);
            
            if (!$query_harga || mysqli_num_rows($query_harga) == 0) {
                $semua_query_berhasil = false;
                $pesan_error = "Gagal mengambil harga buku (ID: $id_buku): " . mysqli_error($conn);
                break; 
            }
            
            $data_buku = mysqli_fetch_assoc($query_harga);
            $harga_satuan = $data_buku['harga'];
            
            $total_keseluruhan_bayar += ($harga_satuan * $jumlah);

            $sql_detail = "INSERT INTO detail_transaksi (id_transaksi, id_buku, jumlah, harga_saat_transaksi) 
                           VALUES ($id_transaksi_baru, $id_buku, $jumlah, $harga_satuan)";
            
            $query_detail = mysqli_query($conn, $sql_detail);

            if (!$query_detail) {
                $semua_query_berhasil = false;
                $pesan_error = "Gagal menyimpan data detail: " . mysqli_error($conn);
                break;
            }
        }
    }

    if ($semua_query_berhasil) {
        
        $sql_update_total = "UPDATE transaksi SET total_bayar = $total_keseluruhan_bayar 
                             WHERE id_transaksi = $id_transaksi_baru";
        
        $query_update_total = mysqli_query($conn, $sql_update_total);

        if (!$query_update_total) {
            $semua_query_berhasil = false;
            $pesan_error = "Gagal update total bayar: " . mysqli_error($conn);
        }
    }

    if ($semua_query_berhasil) {
        mysqli_commit($conn);
        $pesan_sukses = "Transaksi sukses disimpan";
    } else {
        mysqli_rollback($conn);
        $pesan_error = "Transaksi gagal karena: " . $pesan_error;
    }

} else {
    header("Location: form_transaksi.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Transaksi</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .pesan {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid;
        }
        .sukses {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .gagal {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <nav>
        <a href="tabel_buku.php">Lihat Tabel Buku</a> 
        <a href="tabel_series.php">Lihat Tabel Series</a>
        <a href="form_tambah_buku.php">Tambah Buku</a>
        <a href="form_tambah_series.php">Tambah Series</a>
        <a href="form_transaksi.php" class="active">Tambah Transaksi</a>
    </nav>

    <div class="container">
        <h2>Status Transaksi</h2>

        <?php if (!empty($pesan_sukses)): ?>
            <div class="pesan sukses">
                <?php echo $pesan_sukses; ?>
            </div>
            <p>Total Bayar: Rp <?php echo number_format($total_keseluruhan_bayar); ?></p>

        <?php elseif (!empty($pesan_error)): ?>
            <div class="pesan gagal">
                <?php echo $pesan_error; ?>
            </div>
        <?php endif; ?>

        <a href="form_transaksi.php" class="btn-tambah" style="margin-right:10px; background-color: #3498db;">Tambah Transaksi Lagi</a>
    </div>
</body>
</html>