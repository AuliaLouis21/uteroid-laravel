<?php foreach($query_jenis_produk->result_array() as $row) { ?>
	<option value="<?php echo $row['no_id'] ?>"><?php echo $row['jenis'] ?></option>
<?php } ?>