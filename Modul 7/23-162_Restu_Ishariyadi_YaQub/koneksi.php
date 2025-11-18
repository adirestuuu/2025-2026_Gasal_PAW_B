<?php 

    $host = 'localhost:3307';
    $username = 'root';
    $pw = '';
    $db = 'reporting';

    try {
        $conn = mysqli_connect($host, $username, $pw, $db);
    } catch (Exception $e) {
        echo $e;
    }

?>