<script type='text/javascript'>
	var documentHeight = null;
	var documentWidth = null;
	var url = "<?= site_url().'/userreport/preview_nota' ?>";
	var sc	= "<?= $this->session->userdata('users_code') ?>";
	jQuery().ready(function(){
		jQuery("#tanggalterima,#tanggalawal,#tanggalakhir").datepicker({
			showOn:'button',
			buttonImage : "<?php echo base_url().'resources/style/images/calendar.gif'; ?>",
			buttonImageOnly : true,
			changeMonth: true,
			changeYear: true,
			dateFormat : "d-m-yy",
			showButtonPanel: true
		});
		documentHeight = jQuery(document).height();
		documentWidth = jQuery(document).width();
		}
	);
	
	function nonota_onKeyPress(event) {
		var target = event.target;
		var keycode = event.keyCode || event.charCode;
		if(keycode == 13) {
			if(target.value == '') {
				alert('no nota masih kosong');
				target.focus();
				return;
			}
			var data = {action:'nota',nonota:target.value};
			ajax(data); 
		}
	}
	
	function tanggalterima_onKeyPress(event) {
		var target = event.target;
		var keycode = event.keyCode || event.charCode;
		if(keycode == 13 ) {
			if(target.value == '') {
				alert('tanggal masih kosong');
				target.focus();
				return;
			}
			var data = {action : 'tanggal-terima', 'tanggal-terima' : splitDate(target.value)};
			ajax(data);
		}
	}
	function tanggalawal_onKeyPress(event) {
		var target = event.target;
		var keycode = event.charCode || event.keyCode;
		var tanggalakhir = document.getElementById('tanggalakhir');
		if(keycode == 13) {
			if(target.value == '') {
				alert('Tanggal Awal , Harap Di Isi');
				target.focus();
				return;
			}
			if(tanggalakhir.value == '') {
				alert('Tanggal Akhir Tidak Valid , Harap Di Isi');
				tanggalakhir.focus();
				return;
			}
			var data = {action : 'tanggal-awal-akhir', 'tanggal-awal' : splitDate(target.value), 
				'tanggal-akhir' : splitDate(tanggalakhir.value)};
			ajax(data);
		}
	}
	function tanggalakhir_onKeyPress(event) {
		var target = event.target;
		var keycode = event.charCode || event.keyCode;
		var tanggalawal = document.getElementById('tanggalawal');
		if(keycode == 13) {
			if(target.value == '') {
				alert('Tanggal Akhir , Harap Di Isi');
				target.focus();
				return;
			}
		if(tanggalawal.value == '') {
			alert('Tanggal Awal Tidak Valid , Harap Di Isi');
				tanggalawal.focus();
				return;
			}
			var data = {action : 'tanggal-awal-akhir', 'tanggal-awal' : splitDate(tanggalawal.value), 'tanggal-akhir' : splitDate(target.value)};
			ajax(data);
		}
	}
	function buttonPreviewTanggalSekarang_onClick(event) {
		var data = {action:'tanggal-sekarang'};
		ajax(data);
	}
	function buttonCetak_onClick(event,button_parameter) {
		ajax_preview(button_parameter);
	}
	function ajax(data) {
		ajax_default(url,data,
			function() { block_ui('retreiving data from server , please wait ... ');},
			function(xml) {
				var table_content = document.getElementById('table-content');
				table_content.innerHTML = "<fieldset style='padding:15px;'>"+xml+"</fieldset>";	
				unblock_ui();
			},
			function(xml) {
				alert('oops , there something wrong on the server , please try again later');
				unblock_ui();
			}
		);
	} 
	function ajax_preview(button_parameter) {
		var src = "<?=site_url().'/userreport/cetak_klien/'?>"+button_parameter;
		var _height = documentHeight - 60;
		var _width = documentWidth - 60;
		var options = {containerCss:{height: _height,padding:0,margin:0,width:_width}};
		jQuery.modal('<iframe src="' + src + '" height="'+(_height) 
				+'" width="'+(_width)+'" style="border:0">',options);
	}
	function splitDate(date) {
		var tanggal = date.split("-");
		return tanggal[1] + "/" + tanggal[0] + "/" + tanggal[2];
	};
</script>