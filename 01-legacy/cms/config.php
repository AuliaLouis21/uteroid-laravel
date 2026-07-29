<?php
$serper = "127.0.0.1";
$user_db = "root";
$passdb = "";
$dbname = "uteroid.cms";

$konek = mysqli_connect($serper, $user_db, $passdb, $dbname);

if (!$konek) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}

mysqli_set_charset($konek, "utf8");
?>