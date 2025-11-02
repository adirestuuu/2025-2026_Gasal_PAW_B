<?php
require 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id='$id'");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Supplier</title>

<style>
.container { width: 90%; margin: auto; font-family: Arial; }
h2 { color:#2a6ebb; margin-bottom:5px; }

.title-line {
    border: none;
    border-bottom: 1px solid #ccc;
    margin-bottom: 20px;
}

label { width:120px; display:inline-block; margin-bottom:10px; font-weight:bold; }
input, textarea {
    width: 300px;
    padding: 8px;
    margin-bottom: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

button { padding:7px 14px; border:none; cursor:pointer; border-radius:4px; }
.btn-update { background:#4CAF50; color:white; }
.btn-cancel { background:#f44336; color:white; }
</style>

</head>
<body>

<div class="container">

<h2>Edit Data Master Supplier</h2>
<hr class="title-line">

<form action="proses_edit.php" method="POST">
<input type="hidden" name="id" value="<?= $row['id']; ?>">

<label>Nama</label>
<input type="text" name="nama" value="<?= $row['nama']; ?>" required><br>

<label>Telp</label>
<input type="text" name="telp" value="<?= $row['telp']; ?>" required><br>

<label>Alamat</label>
<input type="text" name="alamat" value="<?= $row['alamat']; ?>" required><br>

<button type="submit" class="btn-update">Update</button>
<a href="index.php"><button type="button" class="btn-cancel">Batal</button></a>

</form>

</div>

</body>
</html>
