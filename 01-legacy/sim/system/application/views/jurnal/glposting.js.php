<script type='text/javascript'>
	var document_width = null;
	var document_heigth = null;
	var jDocument = null;
	jQuery(document).ready(function(){
		jQuery("#tanggal_awal,#tanggal_akhir")
		.datepicker({
			showOn: 'button', 
			buttonImage: "<?php echo base_url() .'resources/style/images/calendar.gif'; ?>", 
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			dateFormat : "d-m-yy",
			showButtonPanel: true
		});
		jDocument = jQuery(document);
		document_width = jDocument.width();
		document_height = jDocument.height();
	});
			
	function tanggal_awal_onKeyPress(event) {
		var target = event.target;
		var keycode = event.keyCode || event.charCode;
		if(keycode == 13) {
			if(target.value != "") {
				var tanggal_akhir = document.getElementById('tanggal_akhir');
				if(tanggal_akhir.value == "") {
					alert('harap isi tanggal akhir');
					tanggal_akhir.focus();
					return;
				}
				request('param=get_transaksi_tanggal_awal_akhir&tanggal_awal='+target.value+'&tanggal_akhir='+tanggal_akhir.value);
			}
		}
	}
	function tanggal_akhir_onKeyPress(event) {
		var target = event.target;
		var keycode = event.keyCode || event.charCode;
		if(keycode == 13) {
			if(target.value != "") {
				var tanggal_awal = document.getElementById('tanggal_awal');
				if(tanggal_awal.value == "") {
					alert("harap isi tanggal awal");
					tanggal_awal.focus();
					return;
				}
				request('param=get_transaksi_tanggal_awal_akhir&tanggal_akhir='+target.value+'&tanggal_awal='+tanggal_awal.value);
			}
		}
	}
		
	function button_transaksi_hari_ini_onClick(event) {
		request('param=get_transaksi_hari_ini');
	}
	
	function keterangan_onKeyPress(event) {
		var target = event.target;
		var keycode = event.keyCode || event.charCode;
		if(keycode == 13) {
			var tanggal_awal = document.getElementById('tanggal_awal');
			var tanggal_akhir = document.getElementById('tanggal_akhir');
			if(target.value != "") {	
				var param = "param=get_keterangan&keterangan="+target.value+"&tanggal_awal="+tanggal_awal.value+"&tanggal_akhir="+tanggal_akhir.value;
				request(param);
			}
			else {
				request('param=get_transaksi_tanggal_awal_akhir&tanggal_akhir='+tanggal_akhir.value+'&tanggal_awal='+tanggal_awal.value);
			}
		}
	}
	
	function request(param) {
		ajax_default('service',param,
			function() {
				block_ui('request data to server , please wait');
			},
			function(xml) {
				unblock_ui();
					document.getElementById('table-content').innerHTML = xml;
				},
				function(xml) {
					alert('opps , there something wrong on the server , please try again later');
					unblock_ui();
				}
			);
	}
</script>