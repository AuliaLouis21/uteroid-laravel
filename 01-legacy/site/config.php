<?php

$serper = "127.0.0.1";
$user_db = "root";
$passdb = "";
$dbname = "uteroid.cms";

$konek = mysqli_connect($serper,$user_db,$passdb,$dbname)
or die(mysqli_connect_error());

mysqli_set_charset($konek,"utf8");

/*
|--------------------------------------------------------------------------
| URL WEBSITE
|--------------------------------------------------------------------------
*/

$root = "http://localhost/utero-group-dev/01-legacy";

$view = $root."/site";

$dirview="./site/views";

$func="./site/func";

/*
|--------------------------------------------------------------------------
*/

$produkperpage=15;
$newsperpage=10;

?>