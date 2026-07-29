<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
    <title>Web Administrator - LAPORAN :: PIUTANG KLIEN</title>   
		<?php echo jquery_tag(); ?>
		<?php echo jquery_ui_tag(); ?>
		<?php echo jquery_blockui_tag() ?>
		<?php echo javascript_ajax_tag() ?>
		<?php echo simplemodal_tag(); ?>
		
		<?php echo jquery_ui_stylesheet_tag(); ?>
		<?php echo stylesheet_tag(); ?>
		<script type='text/javascript'>
			var documentHeight = null;
			var documentWidth = null;
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
			});
			
			function nonota_onKeyPress(event) {
				var target = event.target;
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					if(target.value == '') {
						alert('no nota masih kosong');
						target.focus();
						return;
					}
					var url = "<?php echo base_url().index_page().'/serviceklien/preview'; ?>";
					var data = {action:'nota',nonota:target.value};
					ajax(url,data); 
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
					var url = "<?php echo base_url().index_page().'/serviceklien/preview'; ?>";
					var data = {action : 'tanggal-terima', 'tanggal-terima' : splitDate(target.value)};
					ajax(url,data);
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
					var url = "<?php echo base_url().index_page().'/serviceklien/preview'; ?>";
					var data = {action : 'tanggal-awal-akhir', 'tanggal-awal' : splitDate(target.value), 'tanggal-akhir' : splitDate(tanggalakhir.value)};
					ajax(url,data);
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
					var url = "<?php echo base_url().index_page().'/serviceklien/preview'; ?>";
					var data = {action : 'tanggal-awal-akhir', 'tanggal-awal' : splitDate(tanggalawal.value), 'tanggal-akhir' : splitDate(target.value)};
					ajax(url,data);
				}
			}
			
			function buttonPreviewTanggalSekarang_onClick(event) {
				var url = "<?php echo base_url().index_page().'/serviceklien/preview'; ?>";
				var data = {action:'tanggal-sekarang'};
				ajax(url,data);
			}
			
			function buttonCetak_onClick(event,buttonParameter) {
				var totaluangmuka = jQuery('#totaluangmuka').text();
				var totaljumlah = jQuery('#totaljumlah').text();
				var tanggalterima = document.getElementById('tanggalterima').value;
				var tanggalawal = document.getElementById('tanggalawal').value;
				var tanggalakhir = document.getElementById('tanggalakhir').value;
				var nota = document.getElementById('nonota').value;
				var _tanggalterima = splitDate(tanggalterima);
				var _tanggalawal = splitDate(tanggalawal);
				var _tanggalakhir = splitDate(tanggalakhir);

				ajax_preview("<?php echo base_url().index_page().'/serviceklien/cetak/'; ?>",
					buttonParameter+"&tanggalawal="+tanggalawal+'&tanggalakhir='+tanggalakhir+
					'&_tanggalterima='+_tanggalterima+'&_tanggalawal='+_tanggalawal+'&_tanggalakhir='+_tanggalakhir+'&nota='+nota);
			}
			
			/*---------- another script ---------------*/
			
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
			
			function splitDate(date) {
				var tanggal = date.split("-");
				return tanggal[1] + "/" + tanggal[0] + "/" + tanggal[2];
			};

		</script>
	</head>
	<body>
		<div id="header">
        <?php
				if($this->session->userdata('isadmin') == 'true') echo menu_tag(); 
				if($this->session->userdata('is_sc') == 'true') echo menu_non_admin_tag(); 
				if($this->session->userdata('is_qc') == 'true') echo menu_qc_tag(); 
			?>
    </div>
		<form name='form1' id='form1'>
			<div id="header2">
				<div id='headsub2'> 
					<?php echo menu_child_laporan_tag(); ?>
				</div>
				<div id='headsub1'> 
					<h1><?php echo $user; ?></h1>
				</div>
			</div>
			<div id='content'>
				<div id='contentwrapper'>
					<div>
						<fieldset>
							<legend>Daftar Piutang Klien</legend>
							<table style="float: left;">
								<tr>
									<td>
										<?php echo label_for('No Nota')?>
									</td>
									<td>
										<?php echo label_for(':'); ?>
									</td>
									<td>
										<table>
											<tr>
												<td>
													<?php 
														echo textbox_tag(array('id'=>'nonota','name'=>'nonota','onkeypress'=>'nonota_onKeyPress(event);')); ?>
												</td>
											</tr>
										</table>
									</td>
									<td>
									<td>
										<?php echo label_for('Tanggal Terima')?>
									</td>
									<td>
										<?php echo label_for(':'); ?>
									</td>
									<td>
										<table>
											<tr>
												<td>
													<?php echo calendar_tag(array('id'=>'tanggalterima','name'=>'tanggalterima',
															'onkeypress'=>'tanggalterima_onKeyPress(event);')); ?>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<?php echo label_for('Tanggal Dari'); ?>
									</td>
									<td>
										<?php echo label_for(':'); ?>
									</td>
									<td>
										<table>
											<tr>
												<td>
													<?php echo calendar_tag(array('id'=>'tanggalawal','name'=>'tanggalawal',
														'onkeypress'=>'tanggalawal_onKeyPress(event);'));
													?>
												</td>
											</tr>
										</table>
									</td>
									<td colspan='3'>
										<center>
											<?php echo label_for('S/D'); ?>
										</center>
									</td>	
									<td>
										<table>
											<tr>
												<td>
													<?php echo calendar_tag(array('id'=>'tanggalakhir','name'=>'tanggallakhir',
														'onkeypress'=>'tanggalakhir_onKeyPress(event)')); ?>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan='6'>
										<?php echo button_tag(array('id'=>'buttonPreviewTanggalSekarang',
											'name'=>'buttonPreviewTanggalSekarang','value'=>'Tanggal Sekarang',
											'onclick'=>'javascript:buttonPreviewTanggalSekarang_onClick(event)')); ?>
									</td>
								</tr>
							</table>
						</fieldset>
						<div id="table-content"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>