<?php $row = $query_produk->row_array() ?>
document.getElementById('ukuran_produk').value = "<?php echo $row['ukuran'] ?>";
document.getElementById('harga_satuan').value = Number2String(<?php echo $row['harga'] ?>);
document.getElementById('jumlah_produk').value = "<?php echo $row['min_order'] ?>";
document.getElementById('diskon_produk').value = 0;
document.getElementById('total_produk').value = Number2String(<?php echo (intval($row['min_order']) * $row['harga']) ?>);
