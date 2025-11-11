<?php
require "koneksi.php";

if(isset($_POST['submit'])){
    $id_series = $_POST['id_series'];
    $nama_series = $_POST['nama_series'];

    if(empty($id_series) || empty($nama_series)){
        die("Error: Data tidak lengkap.");
    }

    $sql_update_series = "UPDATE series SET nama_series = '$nama_series' WHERE id_series = $id_series";
    
    $query_update_series = mysqli_query($conn, $sql_update_series);

    if ($query_update_series) {
        header("Location: tabel_series.php");
        exit();
    } else {
        echo "Gagal update series: " . mysqli_error($conn);
        echo "<br><a href='tabel_series.php'>Kembali ke Tabel Series</a>";
    }

} else {
    header("Location: tabel_series.php");
    exit();
}
?>