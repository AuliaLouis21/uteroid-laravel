<script type="text/javascript">	
	var documentHeight = null;
	var documentWidth = null;
		jQuery().ready(function(){
			jQuery("#tanggalterima,#tanggalawal,#tanggalakhir")
				.datepicker({
					showOn: 'button', 
					buttonImage: "<?php echo base_url() .'resources/style/images/calendar.gif'; ?>", 
					buttonImageOnly: true,
					changeMonth: true,
		    	changeYear: true,
		    	dateFormat : "d-m-yy",
		    	showButtonPanel: true
        });
			documentHeight = jQuery(document).height();
			documentWidth = jQuery(document).width();
    });
		
	function buttonPreviewTanggalSekarang_onClick(event) {
		var datasc = getSalesCounter();
		var url = "<?php echo base_url().index_page().'/userreport/preview'; ?>";
		var data = {action:'tanggal-sekarang',sc : datasc};
		ajax(url,data);
	};
			
	function nonota_onKeyPress(event) {
		var target = event.target;
		var keycode = event.charCode || event.keyCode;
		if(keycode == 13) {
			if(target.value == '') {
				alert('No Nota Masih Kosong , Harap Di Isi');
				target.focus();
				return;
			}
			var url = "<?php echo base_url().index_page().'/userreport/preview/'; ?>";
			var data = {action :'nota', sc : getSalesCounter() , nota : target.value};
			ajax(url,data);
		}
	};
		
	function tanggalterima_onKeyPress(event) {
		var target = event.target;
		var keycode = event.charCode || event.keyCode;
		if(keycode == 13) {
			if(target.value == '') {
				alert('Tanggal Terima Masih Kosong , Harap Di Isi...');
				target.focus();
				return;
			}
			var url = "<?php echo base_url().index_page().'/userreport/preview'; ?>";
			var data = {action : 'tanggal-terima', sc : getSalesCounter(), tanggalterima : splitDate(target.value)};
			ajax(url,data);				
		}
	};
		
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
			var url = "<?php echo base_url().index_page().'/userreport/preview'; ?>";
			var data = {action : 'tanggal-awal-akhir', sc : getSalesCounter(), 
							tglawal : splitDate(target.value), tglakhir : splitDate(tanggalakhir.value)};
			ajax(url,data);
		}
	};
		
	function tanggalakhir_onKeyPress(event) {
		var target = event.target;
		var keycode = event.charCode || event.keyCode;
		var tanggalawal = document.getElementById('tanggalawal');
		if(keycode == 13) {
			if(target.value == '') {
				alert('Tanggal Awal , Harap Di Isi');
				target.focus();
				return;
			}
			if(tanggalawal.value == '') {
				alert('Tanggal Awal Tidak Valid , Harap Di Isi');
				tanggalakhir.focus();
				return;
			}
			var url = "<?php echo base_url().index_page().'/userreport/preview'; ?>";
			var data = {action : 'tanggal-awal-akhir', sc : getSalesCounter(), 
							tglawal : splitDate(tanggalawal.value), tglakhir : splitDate(target.value)};
			ajax(url,data);
		}
	};
		
		
	function buttonCetak_onClick(event,buttonParameter) {		
		var src = "<?=site_url().'/userreport/cetak/'?>"+buttonParameter;
		var _height = documentHeight - 60;
		var _width = documentWidth - 60;
		var target = event.target;
		var options = {containerCss:{height: _height,padding:0,margin:0,width:_width}};
		jQuery.modal('<iframe src="' + src + '" height="'+(_height) 
				+'" width="'+(_width)+'" style="border:0">',options);
	}

	function getSalesCounter() {
		return <?=$user_code?>;
	};
		
	function splitDate(date) {
		var tanggal = date.split("-");
		return tanggal[1] + "/" + tanggal[0] + "/" + tanggal[2];
	}
		
	function ajax(url,data) {
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
		
	function ajax_preview(url,data) {
		var _width = documentWidth - 80;
		var _height = documentHeight - 50;
		var options = {containerCss:{height:_height,padding:5,width:_width}};
		ajax_default(url,data,
			function() { block_ui('generating report from server , please wait'); },
			function(xml) {
				if(xml != "") { unblock_ui();jQuery.modal(xml,options); }
				else { alert('data tidak ada'); unblock_ui(); }
			},
			function(xml) { alert('oops , there something wrong on the server'); unblock_ui();}
		);
	}
</script>