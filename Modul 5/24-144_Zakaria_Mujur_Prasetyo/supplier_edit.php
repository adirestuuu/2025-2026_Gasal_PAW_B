<?php
// nyambung koneksi database dan helper
require __DIR__ . '/koneksi.php';

// ambil ID dari query string dan validasi
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  // jika ID tidak valid, beri pesan lalu kembali ke daftar
  flash('err','ID tidak valid.');
  header('Location: ' . base_url() . 'supplier.php');
  exit;
}

// ngambil data supplier by id
$data = null;
$stmt = mysqli_prepare($conn, 'SELECT id, nama, telp, alamat FROM supplier WHERE id = ?');
if ($stmt) {
  mysqli_stmt_bind_param($stmt, 'i', $id);
  mysqli_stmt_execute($stmt);
  // gabung kolom hasil ke variabel-variabel
  mysqli_stmt_bind_result($stmt, $rid, $rnama, $rtelp, $ralamat);
  if (mysqli_stmt_fetch($stmt)) {
    $data = ['id' => $rid, 'nama' => $rnama, 'telp' => $rtelp, 'alamat' => $ralamat];
  }
  mysqli_stmt_close($stmt);
}
// if tidak ditemukan, redirect kembali dengan pesan
if (!$data) {
  flash('err','Data tidak ditemukan.');
  header('Location: ' . base_url() . 'supplier.php');
  exit;
}

// proses submit form update
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
  // ambil dan rapikan input
  $nama = trim($_POST['nama'] ?? '');
  $telp = trim($_POST['telp'] ?? '');
  $alamat = trim($_POST['alamat'] ?? '');
  if ($nama === '' || $telp === '') {
    // validasi error isi sederhana
    flash('err','Nama dan Telp wajib diisi.');
  } else {
    // update menggunakan prepared statement
    $upd = mysqli_prepare($conn, 'UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?');
    if ($upd) {
      mysqli_stmt_bind_param($upd, 'sssi', $nama, $telp, $alamat, $id);
      mysqli_stmt_execute($upd);
      mysqli_stmt_close($upd);
    }
    // simpan pesan sukses terus ke supplier
    flash('ok','Data supplier diupdate.');
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
  <title>Edit Data Master Supplier</title>
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
  <h4 class="mb-3">Edit Data Master Supplier</h4>

  <!-- pesan error jika ada -->
  <?php if ($m = flash('err')): ?><div class="pesan pesanerr"><?= htmlspecialchars($m) ?></div><?php endif; ?>

  <div class="kartu bayangan"><div class="isi">
    <!-- Form edit supplier -->
    <form method="post">
      <div class="bawah3">
        <label class="label">Nama</label>
        <input class="input" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
      </div>
      <div class="bawah3">
        <label class="label">Telp</label>
        <input class="input" name="telp" value="<?= htmlspecialchars($data['telp']) ?>" required>
      </div>
      <div class="bawah3">
        <label class="label">Alamat</label>
        <input class="input" name="alamat" value="<?= htmlspecialchars($data['alamat']) ?>">
      </div>
      <div class="flex celah2">
        <button class="tombol sukses" type="submit">Update</button>
        <a class="tombol bahaya" href="<?= base_url() ?>supplier.php">Batal</a>
      </div>
    </form>
  </div></div>
</main>
</body>
</html>
