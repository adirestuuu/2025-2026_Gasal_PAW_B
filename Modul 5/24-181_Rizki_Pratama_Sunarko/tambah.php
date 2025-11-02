<!DOCTYPE html>
<html>
<head>
<title>Tambah Supplier</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 90%;
        margin: 30px auto;
    }

    h2 {
        color: #2a6ebb;
        margin-bottom: 5px;
        font-weight: bold;
        font-size: 22px;
    }

    hr {
        border: 0;
        border-bottom: 1px solid #ccc;
        margin-bottom: 20px;
    }

    label {
        width: 120px;
        display: inline-block;
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;
        text-align: left;
    }

    input {
        width: 300px;
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    button {
        padding: 7px 20px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
        margin-right: 5px;
    }

    .btn-save {
        background: #4CAF50;
        color: white;
    }

    .btn-cancel {
        background: #d9534f;
        color: white;
    }
</style>

</head>
<body>

<div class="container">

<h2>Tambah Data Master Supplier Baru</h2>
<hr>

<form action="proses_tambah.php" method="POST">

<div>
<label>Nama</label>
<input type="text" name="nama" placeholder="nama" required>
</div>

<div>
<label>Telp</label>
<input type="text" name="telp" placeholder="telp" required>
</div>

<div>
<label>Alamat</label>
<input type="text" name="alamat" placeholder="alamat" required>
</div>

<div style="margin-top: 10px;">
<button type="submit" class="btn-save">Simpan</button>
<a href="index.php"><button type="button" class="btn-cancel">Batal</button></a>
</div>

</form>

</div>

</body>
</html>
