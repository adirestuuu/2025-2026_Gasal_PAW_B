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
        <h2>Edit Data Master Supplier</h2>
    </div>

    <div class="inputan">
        <form action="" method="post">
            <div class="nama">
                <label for="nama">Nama: 
                    <input type="text">
                </label>
            </div>
            <div class="telp">
                <label for="telp">Telp: 
                    <input type="text">
                </label>
            </div>
            <div class="alamat">
                <label for="alamat">Alamat: 
                    <input type="text">
                </label>
            </div>
            <div class="tombol">
                <button class="btn btn-update" onclick="window.location.href=''">Update</button>
                <button class="btn btn-batal" onclick="window.location.href=''">Batal</button>
            </div>
        </form>
    </div>
</body>
</html>