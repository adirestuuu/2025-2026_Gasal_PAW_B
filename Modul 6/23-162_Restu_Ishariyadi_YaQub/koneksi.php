<?php

$conn = mysqli_connect("localhost","root","","bookstore");

if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
