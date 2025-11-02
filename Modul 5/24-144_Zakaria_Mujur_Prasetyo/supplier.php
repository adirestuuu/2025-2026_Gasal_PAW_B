<?php
// koneksi database dan helper
require __DIR__ . '/koneksi.php';

// aksi hapus data supplier
if (($_GET['action'] ?? '') === 'delete') {
  // ID menjadi integer
  $id = (int)($_GET['id'] ?? 0);
  if ($id > 0) {
    // prepared statement untuk menurut ID
    $stmt = mysqli_prepare($conn, 'DELETE FROM supplier WHERE id = ?');
    if ($stmt) {
      // Ikat parameter (i = integer), lalu eksekusi dan tutup statement
      mysqli_stmt_bind_param($stmt, 'i', $id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      // Simpan pesan sukses ke flash untuk ditampilkan setelah redirect
      flash('ok', 'Supplier dihapus.');
    }
  }
  // mencegah resubmit saat refresh
  header('Location: ' . base_url() . 'supplier.php');
  exit;
}

// ngambil data supplier untuk  jadi tabel
$rows = []; // default kosong gagal
$res = mysqli_query($conn, query: 'SELECT id, nama, telp, alamat FROM supplier ORDER BY id ASC'); // query semua supplier terurut
if ($res) {
  // ubah query menjadi array asosiatif
  $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
  mysqli_free_result($res);
}
?>


<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Master Supplier</title>
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<!-- Navigasi/header halaman -->
<nav class="navigasi bgputih garisbawah">
  <div class="wadah">
    <a class="merek" href="<?= base_url() ?>supplier.php">Data Master Supplier</a>
    <div class="kanan"></div>
  </div>
</nav>
<!-- Konten utama -->
<main class="wadah jarak">
  <div class="flex antara sejajar bawah3">
    <h4 class="bawah0"> </h4>
    <a href="<?= base_url() ?>supplier_add.php" class="tombol sukses">Tambah Data</a>
  </div>
  <!-- Tampilkan pesan flash (sukses/error) jika ada -->
  <?php if ($m = flash('ok')): ?><div class="pesan pesanok"><?= htmlspecialchars($m) ?></div><?php endif; ?>
  <?php if ($m = flash('err')): ?><div class="pesan pesanerr"><?= htmlspecialchars($m) ?></div><?php endif; ?>

  <div class="kartu bayangan">
    <div class="isi">
      <div class="tabelres">
        <!-- Tabel data supplier -->
        <table class="tabel tabelselang tengahvert">
          <thead>
            <tr>
              <th style="width:60px">No</th>
              <th>Nama</th>
              <th>Telp</th>
              <th>Alamat</th>
              <th style="width:160px">Tindakan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!$rows): ?>
              <!-- belum ada data -->
              <tr><td colspan="5" class="tengah redup">Belum ada data</td></tr>
            <?php else: ?>
              <!-- data supplier -->
              <?php $no=1; foreach ($rows as $r): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['nama']) ?></td>
                <td><?= htmlspecialchars($r['telp']) ?></td>
                <td><?= htmlspecialchars($r['alamat']) ?></td>
                <td>
                  <a class="tombol kecil awas" href="<?= base_url() ?>supplier_edit.php?id=<?= (int)$r['id'] ?>">Edit</a>
                  <a class="tombol kecil bahaya" href="<?= base_url() ?>supplier.php?action=delete&id=<?= (int)$r['id'] ?>" onclick="return confirm('Anda yakin akan menghapus supplier ini?')">Hapus</a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
</body>
</html>
