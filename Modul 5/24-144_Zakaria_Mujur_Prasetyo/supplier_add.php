<?php
require __DIR__ . '/koneksi.php';

// tangani submit form penambahan supplier
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
  // ambil dan rapikan input
  $nama = trim($_POST['nama'] ?? '');
  $telp = trim($_POST['telp'] ?? '');
  $alamat = trim($_POST['alamat'] ?? '');
  // validasi nama & telp wajib
  if ($nama === '' || $telp === '') {
    flash('err', 'Nama dan Telp wajib diisi.');
  } else { 
    $nama_e   = mysqli_real_escape_string($conn, $nama);
    $telp_e   = mysqli_real_escape_string($conn, $telp);
    $alamat_e = mysqli_real_escape_string($conn, $alamat);
    mysqli_query($conn, "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama_e', '$telp_e', '$alamat_e')");
    // pesan sukses dan redirect ke supplier
    flash('ok', 'Supplier berhasil ditambah.');
    header('Location: ' . base_url() . 'supplier.php');
    exit;
  }
}
?>


<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Data Master Supplier</title>
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<!-- Navigasi sederhana -->
<nav class="navigasi bgputih garisbawah">
  <div class="wadah">
    <a class="merek" href="<?= base_url() ?>supplier.php">Kembali</a>
  </div>
</nav>
<main class="wadah jarak" style="max-width:720px;">
  <h4 class="mb-3">Tambah Data Master Supplier Baru</h4>
  <!-- pesan error jika ada -->
  <?php if ($m = flash('err')): ?><div class="pesan pesanerr"><?= htmlspecialchars($m) ?></div><?php endif; ?>
  <div class="kartu bayangan"><div class="isi">
    <!-- Form input supplier baru -->
    <form method="post">
      <div class="bawah3">
        <label class="label">Nama</label>
        <input class="input" name="nama" placeholder="Nama">
      </div>
      <div class="bawah3">
        <label class="label">Telp</label>
        <input class="input" name="telp" placeholder="telp">
      </div>
      <div class="bawah3">
        <label class="label">Alamat</label>
        <input class="input" name="alamat" placeholder="alamat">
      </div>
      <div class="flex celah2">
        <button class="tombol sukses" type="submit">Simpan</button>
        <a class="tombol bahaya" href="<?= base_url() ?>supplier.php">Batal</a>
      </div>
    </form>
  </div></div>
</main>
</body>
</html>
