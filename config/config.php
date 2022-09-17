<?php

$host = 'localhost';
$username = 'root';
$password =  '';
$database = 'program';

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    echo "Tidak dapat terkoneksi dengan server";
    exit();
}
if (!mysqli_select_db($koneksi, $database)) {
    echo "Tidak dapat membuka database";
    exit();
}
