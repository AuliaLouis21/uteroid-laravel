<?php
    $qupro=mysqli_query($konek,"SELECT * FROM posts WHERE cat='2' ORDER BY rand() LIMIT 2");
	$qads=mysqli_query($konek,"SELECT judul,slug,img FROM ads ORDER BY id DESC");
?>