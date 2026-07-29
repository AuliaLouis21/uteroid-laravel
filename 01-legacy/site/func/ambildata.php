<?php

require_once("./../config.php");

$kode = mysqli_real_escape_string($konek, $_GET['kode'] ?? '');

if ($kode != '') {

    echo '<select name="jenis">';

    $rs = mysqli_query($konek, "SELECT * FROM jnsproduk WHERE cat='$kode'")
        or die(mysqli_error($konek));

    if (mysqli_num_rows($rs) < 1) {

        echo '<option value="">No Data</option>';

    } else {

        while ($r = mysqli_fetch_array($rs)) {

            echo "<option value='{$r['id']}'>{$r['jenis']}</option>";

        }

    }

    echo '</select>';
}
?>