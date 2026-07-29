<script type='text/javascript'>
	var document_width = null;
	var document_height = null;
	var serial = "<?php echo $row_order['serial'] ?>";
	var bucket = new Array();
	var no = 0;
	var id_klien = "<?php echo $row_order['klien'] ?>";
	var id_sales = "<?php echo $row_order['sales'] ?>";
	var error_on_init = false;
	var global_no_id = "<?php echo $row_order['no_id'] ?>";
	jQuery(document).ready(function() {
		jQuery("#tanggal_terima,#deadline_desain,#deadline_selesai")
			.datepicker({
				showOn: 'button', 
				buttonImage: "<?php echo base_url() .'resources/style/images/calendar.gif'; ?>", 
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				dateFormat : "d-m-yy",
				showButtonPanel: true
			});
		document_width = jQuery(document).width();
		document_height = jQuery(document).height();;
		init_form();
	});
	
	function button_cetak_transaksi_onClick(event) {
		var _height = document_height - 60;
		var _width = document_width - 60
		var src = '<?php echo site_url().'/transaksinota/cetak/id/'?>' + global_no_id;
		var options = {
					containerCss:{
						height: 551,
						padding:0,
						margin:0,
						width:1306
					}
				};	
		jQuery.modal('<iframe src="' + src + '" height="'+(551)+'" width="'+(1306)+'" style="border:0">',options)
	};
	
	function update_bucket(_no,kategori_produk,jenis_produk,nama_produk,ukuran_produk,harga_satuan,jumlah_produk,diskon_produk,total_produk) {
		bucket.push(new Array(_no,new Array(kategori_produk,jenis_produk,nama_produk,
																				ukuran_produk,harga_satuan,jumlah_produk,
																				diskon_produk,total_produk)));
		no = _no;
	}
	
	function button_cari_nama_onClick(event) {
		var target = event.target;
		var options = {containerCss:{height: 265,padding:5,width:800}};		
		ajax_default("<?php echo site_url().'/transaksinota/cariklien' ?>",{"param":"load-view"},
			function() { block_ui('loading client data ... '); },
			function(xml) { if(xml != "") { unblock_ui(); jQuery.modal(xml,options); }},
			function(xml) { alert('oops , there something wrong on the server , while loading client data ...'); unblock_ui(); });
	
	}
	
	function button_klien_baru_onClick(event) {				
		var options = {containerCss:{height: 435,padding:5,width:800}};				
		ajax_default("<?php echo site_url().'/transaksinota/loadklien' ?>",null,
			function() { block_ui('attempting to add new client ... '); },
			function(xml) { if(xml != "") { unblock_ui(); jQuery.modal(xml,options); }},
			function(xml) { unblock_ui(); alert('oops , there something wrong on the server , while attempting to add new client ...'); });
	}
			
	function button_cari_nama_sales_onClick(event) {
		var target = event.target;
		var options = {containerCss:{height: 265,padding:5,width:800}};		
		ajax_default("<?php echo site_url().'/transaksinota/carisales' ?>",{"param":"load-view"},
			function() { block_ui('loading sales data ... '); },
			function(xml) { if(xml != "") { unblock_ui(); jQuery.modal(xml,options); }},
			function(xml) { unblock_ui(); alert('oops , there something wrong on the server , while loading sales data ...'); });
	}
			
	function button_sales_baru_onClick(event) {
		var options = {containerCss:{height: 405,padding:5,width:800}};								
		ajax_default("<?php echo site_url().'/transaksinota/loadsales' ?>",null,
			function() { block_ui('attempting to add new sales ... '); },
			function(xml) { if(xml != "") { unblock_ui(); jQuery.modal(xml,options); }},
			function(xml) { unblock_ui(); alert('oops , there something wrong on the server , while attempting to add new sales  ...'); });
	}
			
	function produk_kategori_onChange(event) {
		var target = event.target;
		ajax_default("<?php echo site_url().'/transaksinota/service' ?>",{"param":"load-jenis-produk","id":target.value},
			function() { block_ui('please wait while loading produk kategori'); },
			function(xml) {
				document.getElementById('jenis_produk').innerHTML = xml; 
				unblock_ui();
			},
			function(xml) { alert('oops , there something wrong on the server while loading produk kategori'); unblock_ui();});
	}
			
	function jenis_produk_onClick(event) {
		var target = event.target;
		ajax_default("<?php echo site_url().'/transaksinota/service' ?>",{"param":"load-produk","id":target.value},
			function() { block_ui('please wait while loading jenis produk ...'); },
			function(xml) {
				document.getElementById('nama_produk').innerHTML = xml;
				unblock_ui();
			},
			function(xml) { alert('opps error , cek lagi apakah kategori produk sudah valid');; unblock_ui();});
	}
	
	function nama_produk_onClick(event) {
		var target = event.target;
		ajax_default("<?php echo site_url().'/transaksinota/service' ?>",{"param":"load-detail-produk","id":target.value},
			function() { block_ui('please wait while loading nama produk ...'); },
			function(xml) {
				eval(xml);
				unblock_ui();
			},
			function(xml) { alert('opps error , cek lagi apakah jenis produk sudah valid'); unblock_ui();});
	}
	
	function add_produk_onClick(event) {
		calculate_grid();
		var target = event.target;
		var parent = target.parentNode.parentNode;
		var table = parent.parentNode;
		var kategori_produk = document.getElementById('produk_kategori');
		var jenis_produk = document.getElementById('jenis_produk');
		var nama_produk = document.getElementById('nama_produk');
		var ukuran_produk = document.getElementById('ukuran_produk');
		var harga_satuan = document.getElementById('harga_satuan');
		var jumlah_produk = document.getElementById('jumlah_produk');
		var diskon_produk = document.getElementById('diskon_produk');
		var total_produk = document.getElementById('total_produk');
				
		var kategori_text = kategori_produk.options[kategori_produk.selectedIndex].text;
		var jenis_text = jenis_produk.options[jenis_produk.selectedIndex].text;
		var nama_text = nama_produk.options[nama_produk.selectedIndex].text;
		
		var trhtml = "";				
		var jTable = jQuery(table);
		no++;
		trhtml += 
			"<tr>" + 
				"<td class='table-row-center'><label style='font-size: 12px;'>" + no + "</label></td>" +
				"<td class='table-row-left'><label style='font-size: 12px;'>" + kategori_text + "</label></td>" + 
				"<td class='table-row-left'><label style='font-size: 12px;'>" + jenis_text + "</label></td>" +
				"<td class='table-row-left'><label style='font-size: 12px;'>" + nama_text + "</label></td>" + 
				"<td class='table-row-right'><label style='font-size: 12px;'>" + ukuran_produk.value + "</label></td>" +
				"<td class='table-row-right'><label style='font-size: 12px;'>" + harga_satuan.value + "</label></td>" +
				"<td class='table-row-right'><label style='font-size: 12px;'>" + jumlah_produk.value + "</label></td>" +
				"<td class='table-row-right'><label style='font-size: 12px;'>" + diskon_produk.value + "</label></td>" + 
				"<td class='table-row-right'><label style='font-size: 12px;'>" + total_produk.value + "</label></td>" +
				"<td class='table-row-center' style='clear: both; width: 70px;'>" + 
					"<input  type='button' value='hapus' onclick='remove_me(event,"+no+")'  class='ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all' />" + 
						"</td>"+
		"</tr>";					
		jTable.append(trhtml);		
		bucket.push(new Array(no,new Array(kategori_produk.value,jenis_produk.value,nama_produk.value,
																				ukuran_produk.value,harga_satuan.value,jumlah_produk.value,
																				diskon_produk.value,total_produk.value)));
	};
	
	function remove_me(event,no) {
		var target = event.target;
		var total = 0;
		var temp = 0;
		var temp_array1 = null;
		var temp_array2 = null;
		jQuery(target.parentNode.parentNode).remove();
		for(var i=0;i<bucket.length;i++) {
			var temp = bucket[i];
			if (temp[0] == no) {
				bucket.splice(i,1);						
			}
		}
		for(var i=0;i<bucket.length;i++) {
			temp_array1 = bucket[i];
			temp_array2 = temp_array1[1];
			total += String2Number(temp_array2[7]);
		}
			
		if(total == 0) {
			document.getElementById('total').value = Number2String(total);
			document.getElementById('biaya_tambahan').value = "";
			document.getElementById('jumlah_uang').value = "";
			document.getElementById('prosentase').value = "";
			document.getElementById('jumlah_tagihan').value = "";
			document.getElementById('sisa_tagihan').value = "";
			return;
		}
			
		document.getElementById('total').value = Number2String(total);
		hitung();
	}
	
	function jumlah_uang_onKeyUp(event) {
		document.getElementById('prosentase').value = '';
		hitung();
	}
	
	function card_onClick(event) {
		var target = event.target;
		var jumlah_card = document.getElementById('jumlah_card');
		if(target.checked) {
			jumlah_card.disabled = false;
		}
		else {
			jumlah_card.disabled = true;
		}
	}
			
	function prosentase_onKeyUp(event) {
		hitung();
	}
		
	function biaya_tambahan_onKeyUp(event){ 
		hitung();
	}
	
	function calculate_grid() {
		var harga_satuan = document.getElementById('harga_satuan');
		var jumlah_produk = document.getElementById('jumlah_produk');
		var diskon_produk = document.getElementById('diskon_produk');
		var total_produk = document.getElementById('total_produk');
		var harga,jumlah,diskon,total = 0;
		if(harga_satuan.value != '') {
			harga = parseFloat(String2Number(harga_satuan.value));
			if(isNaN(harga)) {
				alert('harga satuan tidak valid , harap diisi kembali');harga_satuan.focus();harga = 0;
				return;
			}
		}
		if(jumlah_produk.value != '') {
			jumlah = parseFloat(jumlah_produk.value);
			if(isNaN(jumlah)) {
				alert('jumlah tidak valid , harap diisi kembali');jumlah_produk.focus();jumlah = 0;
				return;
			}
		}
		if(diskon_produk.value != '') {
			diskon = parseFloat(diskon_produk.value);
			if(isNaN(diskon)) {
				alert('diskon produk tidak valid , harap diisi kembali');diskon_produk.focus();diskon = 0;
				return;
			}
		}
		total = harga * jumlah;
		total_diskon = total/100 * diskon;
		total = total - total_diskon;
		total_produk.value = Number2String(total);
				
		var total_all = document.getElementById('total');
		var value_total_all = 0;	
		if(total_all.value.length == 0) {
			total_all.value = 0;
		}
		if(!isNaN(String2Number(total_all.value))) {
			value_total_all = String2Number(total_all.value) + total;
			total_all.value = Number2String(value_total_all);
		}	
		hitung();
	}
	
	function convert_date_to_string(d) {
		d = d.split('-');
		return d[1]+'/'+d[0]+'/'+d[2];
	}
	
	function check_before_update() {
		var retval = true;
		var tema = document.getElementById('tema');
		var sales = document.getElementById('nama_sales');
		var jumlah_uang = document.getElementById('jumlah_uang');
		
		if(tema.value == "") {
			retval = false;alert('Mohon isi tema...!!!');tema.focus();
			return retval;
		}
		if(nama_sales.value == "") {
			retval = false;alert("Mohon isi nama sales...!!!");nama_sales.focus();
			return retval;
		}
		if(bucket.length == 0) {
			retval = false;alert('oii , anda belum melakukan transaksi apapun ... !!!');
			return retval;
		}
		if((jumlah_uang.value == "" || jumlah_uang == "0")) {
			retval = false;alert("Mohon isi Jumlah Uang Muka");jumlah_uang.focus();
			return retval;
		}
		return retval;
	}
	
	function after_update() {
		document.getElementById('button_cetak_transaksi').disabled = false;
	}
	
	
	function button_simpan_transaksi_onClick(event) {
		if(check_before_update()) {
			if(confirm('apakah data transaksi sudah yakin benar ?')) {
				var no_nota = document.getElementById('no_nota');
				var tema = document.getElementById('tema');
				var tanggal_terima = document.getElementById('tanggal_terima');
				var deadline_desain = document.getElementById('deadline_desain');
				var deadline_selesai = document.getElementById('deadline_selesai');
				var prosentase = document.getElementById('prosentase');
				var jumlah_uang = document.getElementById('jumlah_uang');
				var total = document.getElementById('total');
				var biaya_tambahan = document.getElementById('biaya_tambahan');
				var jumlah_tagihan = document.getElementById('jumlah_tagihan');
				var sisa_tagihan = document.getElementById('sisa_tagihan');
				var card = document.getElementById('card');
				var jumlah_card = document.getElementById('jumlah_card');
				
				if(card.checked) jumlah_card = jumlah_card.value;
				else jumlah_card = "";
				
				ajax_default('<?php echo site_url().'/transaksinota/save/' ?>',
					{
						"param":"update-transaksi",
						"no-id" : global_no_id,
						"klien" : id_klien,
						"tema" : tema.value,
						"sales" : id_sales,
						"nota" : no_nota.value,
						"serial" : serial,
						"total" : String2Number(total.value),
						"biaya_tambahan" : biaya_tambahan.value == "" ? 0 : biaya_tambahan.value,
						"uang_muka" : 0,
						"jumlah_uangmuka" : jumlah_uang.value == "" ? 0 : jumlah_uang.value ,
						"jumlah_tagihan" : String2Number(jumlah_tagihan.value),
						"sisa" : String2Number(sisa_tagihan.value),
						"tgl_terima" : convert_date_to_string(tanggal_terima.value),
						"tgl_desain" : convert_date_to_string(deadline_desain.value),
						"tgl_selesai" : convert_date_to_string(deadline_selesai.value),
						"jumlah_card" : jumlah_card
					},
						function() {block_ui('updating transaksi nota to server , please wait for a moment ...'); },
						function(xml) {
							
							
							xml = xml.split('-');
							if(xml[0] == "firstsavepoint") {
								var _nota = xml[1];
								var _no_id = xml[2]; // ini id dari sim_nota_order
								global_no_id = _no_id;
								var is_last = false;
								for(var i=0;i<bucket.length;i++) {
									var barang = bucket[i][1];
									if((i+1) == bucket.length) is_last = true;
									ajax_default('<?php echo site_url().'/transaksinota/save/' ?>',
										{
											"param":"update-transaksi-detail",
											'no_id':_no_id,
											'no_kategori':barang[0],
											'no_jenis':barang[1],
											'no_produk':barang[2],
											'harga':String2Number(barang[4]),
											'jumlah':barang[5],
											'diskon':barang[6],
											'ukuran':barang[3],
											'is_last' : is_last
										},
										function() {
											if(document.getElementById('block-ui-message') != null) {
												jQuery('#block-ui-message').text('please wait , updating order with code : ' + barang[2]);
											}
											else {
												block_ui('please wait , updating order with code : ' + barang[2]);
											}
										},
										function(xml) {
											xml = xml.split('-');
											if(xml[0] == 'next') {
												if(document.getElementById('block-ui-message') != null) {
													jQuery('#block-ui-message').text('success , updating order with code : ' + barang[2]);
												}
											}
											if(xml[0] == 'last') {
												if(document.getElementById('block-ui-message') != null) {
													unblock_ui();
												}
												alert('transaksi berhasil di update di server');
												after_save();
											}
										},
										function(xml) {
											alert('ooops , error while updating order ... please try again in a few minutes ...');
											if(document.getElementById('block-ui-message') != null) {
												unblock_ui();
											}
										}
									);
								}
							}
							else {
								alert('update transaksi nota gagal , mungkin ada gangguan pada server ... , coba YM ke pusat');
								unblock_ui();
							}
						},
						function(xml) {
							alert('oops , there something wrong on the server , try again in a few minutes ...');
							unblock_ui();
						}
				);
			}
		}
	}
	
	function after_save() {
		document.getElementById('button_cetak_transaksi').disabled = false;
	}
</script>