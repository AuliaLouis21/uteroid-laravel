<script type='text/javascript'>
			var document_state = null;
			var date_picker = "#selesaidesaintanggalawal,#selesaidesaintanggalakhir,#selesaidesaintanggal,";
			date_picker += "#selesaiproduksitanggalawal,#selesaiproduksitanggalakhir,#selesaiproduksitanggal,";
			date_picker += "#slipordertanggalawal,#slipordertanggalakhir,#slipordertanggal,";
			date_picker += "#selesaikeklientanggalawal,#selesaikeklientanggalakhir,#selesaikeklientanggal";
			jQuery(document).ready(function(){
				jQuery(date_picker)
					.datepicker({
						showOn: 'button', 
						buttonImage: "<?php echo base_url() .'resources/style/images/calendar.gif'; ?>", 
						buttonImageOnly: true,
	             	changeMonth: true,
			    		changeYear: true,
			    		dateFormat : "d-m-yy",
			    		showButtonPanel: true
	         	});
				document.getElementById('sablon').click();
			});
			
			function change_document_state(event) {
				var target = event.target;
				document_state = target.value;
				if(target.value == 'sablon') {
					document_state = target.value;
					slip_p3(false);
				}
				if(target.value =='konstruksi') {
					document_state = target.value;
					slip_p3(false);
				}
				if(target.value =='slipp3') {
					document_state = target.value;
					slip_p3(true);
				}
				if(target.value =='slipumum') {
					document_state = target.value;
					slip_p3(false);
				}
			};
			
			function slip_p3(disabled) {
				document.getElementById('selesaidesaintanggalawal').disabled = disabled;
				document.getElementById('selesaidesaintanggalakhir').disabled = disabled;
				document.getElementById('selesaidesaintanggal').disabled = disabled;
				document.getElementById('buttonselesaidesain').disabled = disabled;
				
				document.getElementById('selesaiproduksitanggalawal').disabled = disabled;
				document.getElementById('selesaiproduksitanggalakhir').disabled = disabled;
				document.getElementById('selesaiproduksitanggal').disabled = disabled;
				document.getElementById('buttonselesaiproduksi').disabled = disabled;
				
				document.getElementById('selesaikeklientanggalawal').disabled = disabled;
				document.getElementById('selesaikeklientanggalakhir').disabled = disabled;
				document.getElementById('selesaikeklientanggal').disabled = disabled;
				document.getElementById('buttonselesaikeklien').disabled = disabled;
			}
			
			function check_datepicker(first_datepicker_id,last_datepicker_id) {
				var datepicker_1 = document.getElementById(first_datepicker_id);
				var datepicker_2 = document.getElementById(last_datepicker_id);
				var retval = true;
				if(datepicker_1.value == "") {
					alert("tanggal awal tidak valid , harap di isi");
					datepicker_1.focus();
					return false;
				}
				if(datepicker_2.value == "") {
					alert("tanggal akhir tidak valid , harap di isi");
					datepicker_2.focus();
					return false;
				}
				return true;
			};
			
			function selesaidesaintanggalawal_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(check_datepicker(target.id,'selesaidesaintanggalakhir')) {
						var data = "param=selesaidesaintanggalawalakhir&"+"document_state="+document_state+"&tanggalawal="+target.value
							+"&tanggalakhir="+document.getElementById('selesaidesaintanggalakhir').value;
						ajax(data);
					}
				}
			};
			
			function selesaidesaintanggal_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(target.value == "") {
						alert('tanggal masih kosong , harap di isi');
						target.focus();
					}
					else {
						var data = "param=selesaidesaintanggalawal&"+"document_state="+document_state+"&tanggal="+target.value;
						ajax(data);
					}
				}
			}
			
			function selesaidesaintanggalakhir_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(check_datepicker("selesaidesaintanggalawal",target.id)) {
						var data = "param=selesaidesaintanggalawalakhir&"+"document_state="+document_state+"&tanggalakhir="+target.value
							+"&tanggalawal="+document.getElementById('selesaidesaintanggalawal').value;
						ajax(data);
					}
				}
			};
			
			function selesaiproduksitanggalawal_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(check_datepicker(target.id,"selesaiproduksitanggalakhir")) {
						var data = "param=slipproduksitanggalawalakhir&"+"document_state="+document_state
							+"&tanggalawal="+target.value+"&tanggalakhir="+document.getElementById('selesaiproduksitanggalakhir').value;
						ajax(data);
					}
				}
			};
			
			function selesaiproduksitanggalakhir_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
 					if(check_datepicker("selesaiproduksitanggalawal",target.id)) {
						var data = "param=slipproduksitanggalawalakhir&"+"document_state="+document_state
							+"&tanggalakhir="+target.value+"&tanggalawal="+document.getElementById('selesaiproduksitanggalawal').value;
						ajax(data);
					}
				}
			};
			
			function selesaiproduksitanggal_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(target.value == "") {
						alert('tanggal tidak valid , harap di isi');
						target.focus();
					}
					else {
						var data = "param=slipproduksitanggal&"+"document_state="+document_state
							+"&tanggal="+target.value;
						ajax(data);
					}
				}
			};
			
			function slipordertanggalawal_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(check_datepicker(target.id,"slipordertanggalakhir")) {
						var data = 'param=slipordertanggalawalakhir&'+'document_state='+document_state+'&tanggalawal='+target.value
						+"&tanggalakhir="+document.getElementById('slipordertanggalakhir').value;
						ajax(data);
					}
				}
			};
			
			function slipordertanggalakhir_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(check_datepicker("slipordertanggalawal",target.id)) {
						var data = 'param=slipordertanggalawalakhir&'+'document_state='+document_state+'&tanggalakhir='+target.value
						+"&tanggalawal="+document.getElementById('slipordertanggalawal').value;
						ajax(data);
					}
				}
			};
			
			function slipordertanggal_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(target.value == "") {
						alert("tanggal tidak valid , harap di isi");
						target.focus();
						return;
					}
					else {
						var data = 'param=slipordertanggal&'+'document_state='+document_state+'&tanggal='+target.value;
						ajax(data);
					}
				}
			};
			
			function selesaikeklientanggalawal_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(check_datepicker(target.id,"selesaikeklientanggalakhir")) {
						var data = 'param=slipklientanggalawalakhir&'+'document_state='+document_state+'&tanggalawal='+target.value
						+"&tanggalakhir="+document.getElementById('selesaikeklientanggalakhir').value;
						ajax(data);
					}
				}
			};
			
			function selesaikeklientanggalakhir_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(check_datepicker("selesaikeklientanggalakhir",target.id)) {
						var data = 'param=slipklientanggalawalakhir&'+'document_state='+document_state+'&tanggalakhir='+target.value
						+"&tanggalawal="+document.getElementById('selesaikeklientanggalawal').value;
						ajax(data);
					}
				}
			};
			
			function selesaikeklientanggal_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(target.value == "") {
						alert('tanggal tidak valid, harap di isi');
						target.focus();
						return;
					}
					else {
						var data = 'param=slipklientanggal&'+'document_state='+document_state+'&tanggal='+target.value;
						ajax(data);
					}
				}
			};
			
			function buttonselesaidesain_onClick(event) {
				var data = "param=selesaidesaintanggalsekarang&"+"document_state="+document_state;
				ajax(data);
			};
			
			function buttonselesaiproduksi_onClick(event) {
				var data = "param=slipproduksitanggalsekarang&"+"document_state="+document_state;
				ajax(data);
			};
			
			function buttonsliporder_onClick(event) {
				var data = "param=slipordertanggalsekarang&"+"document_state="+document_state;
				ajax(data);
			};
			
			function buttonselesaikeklien_onClick(event) {
				var data = "param=slipklientanggalsekarang&"+"document_state="+document_state;
				ajax(data);
			};
			
			function nonota_onKeyUp(event) {
				var target	=	event.target;
				var keycode	=	event.keyCode || event.charCode;
				if(target.value != "") {
					if(keycode == 13) {
						var data = "param=nonota&document_state="+document_state+"&nota="+target.value
						ajax(data,'service2');
					}
				}
			}
			
			function noslip_onKeyUp(event) {
				var target	= event.target;
				var keycode	= event.keyCode || event.charCode;
				if(target.value != "") {
					if(keycode == 13) {
						var data = "param=noslip&document_state="+document_state+"&slip="+target.value
						ajax(data,'service2');
					}
				}
			}
			
			function ajax(_data,url) {
				var _url = null;
				if(typeof(url) == 'undefined')
					_url = 'service';
				else
					_url = url;
				
				ajax_default(_url,_data,
					function() { block_ui('loading data from server , please wait'); },
					function(xml) {
						unblock_ui();
						var content_table = document.getElementById('content-table');
						jQuery(content_table).html(xml);
					},
					function(xml) {
						alert('opps , something wrong on the server , plase try again!!');
						unblock_ui();
					});
			}
			
			function splitDate(date) {
				var tanggal = date.split("-");
				return tanggal[1] + "/" + tanggal[0] + "/" + tanggal[2];
			};
</script>