var document_width = null;
var document_height = null;
jQuery(document).ready(function(){
	jQuery("#tanggal_awal,#tanggal_akhir,#tanggal_terima")
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
});
			
function button_tanggal_sekarang_onClick(event) {
	ajax('show',{param:'tanggal-sekarang'});
}

function no_nota_onKeyUp(event) {
	var target = event.target;
	var keycode = event.keyCode || event.charCode;
	if(keycode == 13) {
		if(target.value == "") {
			alert('nomor nota masih kosong , harap di isi');
			return;
		}
		ajax('show',{param:'no-nota',nota:target.value});
	}
};

function tanggal_terima_onKeyUp(event) {
	var target = event.target;
	var keycode = event.keyCode || event.charCode;
	if(keycode == 13) {
		if(target.value == "") {
			alert('nomor nota masih kosong , harap di isi');
			return;
		}
		ajax('show',{param:'tanggal-terima','tanggal-terima':convert_date_to_string(target.value)});
	}
}

function tanggal_awal_onKeyUp(event) {
	var target = event.target;
	var tanggal_akhir = document.getElementById('tanggal_akhir');
	var keycode = event.keyCode || event.charCode;
	if(keycode == 13) {
		if(target.value == "") {
			alert('tanggal awal masih kosong , harap di isi');
			return;
		}
		if(tanggal_akhir.value == '') {
			alert('tanggal akhir masih kosong , harap di isi');
			tanggal_akhir.focus();
			return;
		}
		ajax('show',
			{param:'tanggal-awal-akhir','tanggal-awal':convert_date_to_string(target.value),
				'tanggal-akhir':convert_date_to_string(tanggal_akhir.value)});
	}
}

function tanggal_akhir_onKeyUp(event) {
	var target = event.target;
	var tanggal_awal = document.getElementById('tanggal_awal');
	var keycode = event.keyCode || event.charCode;
	if(keycode == 13) {
		if(target.value == "") {
			alert('tanggal akhir masih kosong , harap di isi');
			return;
		}
		if(tanggal_awal.value == '') {
			alert('tanggal awal masih kosong , harap di isi');
			tanggal_awal.focus();
			return;
		}
		ajax('show',
			{param:'tanggal-awal-akhir','tanggal-akhir':convert_date_to_string(target.value),
				'tanggal-awal':convert_date_to_string(tanggal_awal.value)});
	}
}

function convert_date_to_string(d) {
	d = d.split('-');
	return d[1]+'/'+d[0]+'/'+d[2];
} 

function cetak(id) {
	var src = 'cetak/id/'+id;
		var options = {containerCss:{height: document_height - 40,width:document_width-40,padding:0,margin:0,}};	
		jQuery.modal('<iframe src="' + src + '" height="'+(document_height - 40)+'" width="'+(document_width-40)+'" style="border:0">',options)
}

function ajax(url,data) {
	ajax_default(url,data,
		function() {block_ui('please wait ...');},
		function(xml) {
			if(xml != '') {document.getElementById('table-content').innerHTML = xml;}
			else {alert('data tidak ada');}
			unblock_ui();
		},
		function(xml) {
			alert('oops , there something wrong on the server , please try again ... ');
			unblock_ui();
		}
	);
}