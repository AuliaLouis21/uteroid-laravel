<script type='text/javascript'>
	function clear_form() {
		document.getElementById('no_nota').value = '';
		document.getElementById('nama').value = '';
		document.getElementById('alamat').value = '';
		document.getElementById('telepon').value = '';
		document.getElementById('email').value = '';
		document.getElementById('perusahaan').value = '';
		document.getElementById('tema').value = '';
		//document.getElementById('nama_sales').value = '';
		document.getElementById('tanggal_terima').value = '';
		document.getElementById('deadline_desain').value = '';
		document.getElementById('deadline_selesai').value = '';
		document.getElementById('prosentase').value = '';
		document.getElementById('jumlah_uang').value = '';
		document.getElementById('card').checked = false;
		document.getElementById('total').value = '';
		document.getElementById('biaya_tambahan').value = '';
		document.getElementById('jumlah_tagihan').value = '';
		document.getElementById('sisa_tagihan').value = '';
	}
	
	function init_form() {
		document.getElementById('no_nota').disabled = true;
		document.getElementById('nama').disabled = true;
		document.getElementById('alamat').disabled = true;
		document.getElementById('telepon').disabled = true;
		document.getElementById('email').disabled = true;
		document.getElementById('perusahaan').disabled = true;
		document.getElementById('tema').disabled = true;
		document.getElementById('nama_sales').disabled = true;
		document.getElementById('tanggal_terima').disabled = true;
		document.getElementById('deadline_desain').disabled = true;
		document.getElementById('deadline_selesai').disabled = true;
		document.getElementById('prosentase').disabled = true;
		document.getElementById('jumlah_uang').disabled = true;
		document.getElementById('jumlah_card').disabled = true;
		document.getElementById('card').checked = false;
		document.getElementById('card').disabled = true;
		document.getElementById('total').disabled = true;
		document.getElementById('biaya_tambahan').disabled = true;
		document.getElementById('jumlah_tagihan').disabled = true;
		document.getElementById('sisa_tagihan').disabled = true;
		
		//document.getElementById('button_pesan_nota').disabled = true;
		document.getElementById('button_cari_nama').disabled = true;
		document.getElementById('button_klien_baru').disabled = true;
		//document.getElementById('button_cari_nama_sales').disabled = true;
		//document.getElementById('button_sales_baru').disabled = true;
		document.getElementById('button_simpan_transaksi').disabled = true;
		document.getElementById('button_cetak_transaksi').disabled = true;
		document.getElementById('produk_kategori').disabled = true;
		document.getElementById('jenis_produk').disabled = true;
		document.getElementById('nama_produk').disabled = true;
		
		document.getElementById('harga_satuan').disabled = true;
		document.getElementById('jumlah_produk').disabled = true;
		document.getElementById('diskon_produk').disabled = true;
		document.getElementById('total_produk').disabled = true;
	}
	
	function enable_form() {
		document.getElementById('no_nota').disabled = false;
		document.getElementById('nama').disabled = true;
		document.getElementById('alamat').disabled = true;
		document.getElementById('telepon').disabled = true;
		document.getElementById('email').disabled = true;
		document.getElementById('perusahaan').disabled = true;
		document.getElementById('tema').disabled = false;
		document.getElementById('nama_sales').disabled = true;
		document.getElementById('tanggal_terima').disabled = false;
		document.getElementById('deadline_desain').disabled = false;
		document.getElementById('deadline_selesai').disabled = false;
		document.getElementById('prosentase').disabled = false;
		document.getElementById('jumlah_uang').disabled = false;
		document.getElementById('card').disabled = false;
		document.getElementById('card').checked = false;
		document.getElementById('total').disabled = false;
		document.getElementById('biaya_tambahan').disabled = false;;
		document.getElementById('jumlah_tagihan').disabled = false;
		document.getElementById('sisa_tagihan').disabled = false;
		
		//document.getElementById('button_pesan_nota').disabled = false;
		document.getElementById('button_cari_nama').disabled = false;
		document.getElementById('button_klien_baru').disabled = false;
		//document.getElementById('button_cari_nama_sales').disabled = false; 
		//document.getElementById('button_sales_baru').disabled = false;
		document.getElementById('button_simpan_transaksi').disabled = false;
		document.getElementById('button_cetak_transaksi').disabled = false;
		
		document.getElementById('produk_kategori').disabled = false;
		document.getElementById('jenis_produk').disabled = false;
		document.getElementById('nama_produk').disabled = false;
		
		document.getElementById('harga_satuan').disabled = false;
		document.getElementById('jumlah_produk').disabled = false;
		document.getElementById('diskon_produk').disabled = false;
		document.getElementById('total_produk').disabled = false;
	}
	function create_serial() {
		ajax_default('createserial',null,
			function(){ block_ui('please wait for a moment');},
			function(xml) { eval(xml); unblock_ui(); },
			function(xml) { alert('oops , something wrong on the server ' + xml.responseText); unblock_ui(); window.location.reload(); }
		);
	}

</script>