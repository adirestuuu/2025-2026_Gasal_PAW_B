<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="aset/style.css">
</head>
<body>

    <?php include 'aset/header.php' ?>

    <div class="judul">
        <h2>Tambah Data Master Supplier Baru</h2>
    </div>

    <div class="inputan">
        <form action="" method="post">
            <div class="form-group">
                <label for="nama">Nama: 
                    <input type="text" placeholder="Nama">
                </label>
            </div>
            <div class="from-group">
                <label for="telp">Telp: 
                    <input type="text" placeholder="telp">
                </label>
            </div>
            <div class="from-group">
                <label for="alamat">Alamat: 
                    <input type="text" placeholder="alamat">
                </label>
            </div>
            <div class="tombol">
                <button class="btn btn-simpan" onclick="window.location.href=''">Simpan</button>
                <button class="btn btn-batal" onclick="window.location.href=''">Batal</button>
            </div>
        </form>
    </div>
</body>
</html>