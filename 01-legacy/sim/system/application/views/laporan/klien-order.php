<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title>Web Administrator - LAPORAN :: KLIEN ORDER</title>   
	<?php echo jquery_tag() ?>
	<?php echo jquery_ui_tag() ?>
	<?php echo jquery_blockui_tag() ?>
	<?php echo simplemodal_tag(); ?>
	<?php echo javascript_ajax_tag('ajax') ?>
	<?php echo jquery_ui_stylesheet_tag() ?>
	<?php echo stylesheet_tag(); ?>

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
			jQuery("#semuaklien").click();
			documentHeight = jQuery(document).height();
			documentWidth = jQuery(document).width();
		});
		
		
		function semuaklien_onClick(event) {
			var semuaklien=document.getElementById('semuaklien');
			if(semuaklien == null) {
				alert('false');
			}
			else {
				var target = event.target;
				if(target.checked == true) {
					jQuery("#klien").attr('disabled',true);
				}
				else {
					jQuery("#klien").attr('disabled',false);
				}
			}			
		};
		
		function klien_onChange(event) {
			var target = event.target;
			var url = "<?php echo base_url().index_page().'/klienorder/preview'; ?>";
			var data = {action:'klien',klien : getClient()};
			ajax(url,data);
		};
		
		function tema_onChange(event) {
			var target = event.target;
			var url = "<?php echo base_url().index_page().'/klienorder/preview'; ?>";
			var data = {action:'tema',tema : target.value};
			ajax(url,data);
		}	;
		
		function perusahaan_onChange(event) {
			var target = event.target;
			var url = "<?php echo base_url().index_page().'/klienorder/preview'; ?>";
			var data = {action:'perusahaan',perusahaan : target.value};
			ajax(url,data);
		};	
		
		function buttonPreviewTanggalSekarang_onClick(event) {
			var url = "<?php echo base_url().index_page().'/klienorder/preview'; ?>";
			var data = {action:'tanggal-sekarang',klien : getClient()};
			ajax(url,data);
		}
			
		function nonota_onKeyPress(event) {
			var target = event.target;
			var keycode = event.charCode || event.keyCode;
			if(keycode == 13) {
				if(target.value == '') {
					alert('No Nota Masih Kosong , Harap Di Isi');
					target.focus();
					return;
				}
				var url = "<?php echo base_url().index_page().'/klienorder/preview'; ?>";
				var data = {action :'nota', klien : getClient() , nota : target.value};
				ajax(url,data);
			}
		};
		
		function tanggalterima_onKeyPress(event) {
			var target = event.target;
			var keycode = event.charCode || event.keyCode;
			if(keycode == 13) {
				if(target.value == '') {
					alert('Tanggal Terima Masih Kosong , Harap Di Is');
					target.focus();
					return;
				}
				var url = "<?php echo base_url().index_page().'/klienorder/preview'; ?>";
				var data = {action : 'tanggal-terima', klien : getClient(), tanggalterima : splitDate(target.value)};
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
				var url = "<?php echo base_url().index_page().'/klienorder/preview'; ?>";
				var data = {action : 'tanggal-awal-akhir', klien : getClient(),
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
				var url = "<?php echo base_url().index_page().'/klienorder/preview'; ?>";
				var data = {action : 'tanggal-awal-akhir', klien : getClient(), 
								tglawal : splitDate(tanggalawal.value), tglakhir : splitDate(target.value)};
				ajax(url,data);
			}
		};
		
		function buttonCetak_onClick(event,buttonParameter) {
			var totaluangmuka = jQuery('#totaluangmuka').text();
			var totaljumlah = jQuery('#totaljumlah').text();
			var tanggalterima = document.getElementById('tanggalterima').value;
			var tanggalawal = document.getElementById('tanggalawal').value;
			var tanggalakhir = document.getElementById('tanggalakhir').value;
			var nota = document.getElementById('nonota').value;
			var _klien = getClient();
			var _tanggalterima = splitDate(tanggalterima);
			var _tanggalawal = splitDate(tanggalawal);
			var _tanggalakhir = splitDate(tanggalakhir);
			var _tema = document.getElementById("tema").value;
			var _perusahaan = document.getElementById("perusahaan").value;

			ajax_preview("<?php echo base_url().index_page().'/klienorder/cetak/'; ?>",
				"action="+buttonParameter+"&uangmuka="+totaluangmuka+"&total="+totaljumlah+'&tanggalterima='+tanggalterima+
				'&tanggalawal='+tanggalawal+'&tanggalakhir='+tanggalakhir+'&_tanggalterima='+_tanggalterima+
				'&_tanggalawal='+_tanggalawal+'&_tanggalakhir='+_tanggalakhir+'&nota='+nota + "&klien="+_klien+
				"&tema="+_tema+"&perusahaan="+_perusahaan);
		};
		
		
		
		/*---------------------------------------- complement function ------------------------------*/
		
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
		
		function getClient() {
			var sc = document.getElementById('semuaklien');
			var datasc = '';
			if(sc.checked == true) {datasc = 'all';}
			else {datasc = jQuery("#klien").val();}
			return datasc;
		};
		
		function splitDate(date) {
			var tanggal = date.split("-");
			return tanggal[1] + "/" + tanggal[0] + "/" + tanggal[2];
		}
		
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
    <form id="form1" name="form1">
    <div id="header2">
        <div id="headsub2">
			<?php echo menu_child_laporan_tag(); ?>
        </div>
        <div id="headsub1">
            <h1>
                Welcome : <?php echo $user; ?>
            </h1>
        </div>
    </div>
    <div id="content">
        <div id="contentwrapper">
            <div>
                <fieldset id="fieldset1">
                    <legend>Pencarian Berdasarkan</legend>
                    <table style="float: left;">
                        <tr>
                            <td><label>No. Nota</label></td>
                            <td><label>:</label></td>
                            <td>
                                <table>
                                    <tr>
																			<td>
																				<?php echo textbox_tag(array('id'=>'nonota',
																									'name'=>'nonota',	'onkeypress'=>'nonota_onKeyPress(event);')); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <label>
                                    Tanggal Terima</label>
                            </td>
                            <td>
                                <label>:</label>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <?php echo calendar_tag(array('id'=>'tanggalterima','name'=>'tanggalterima','onkeypress'=>'tanggalterima_onKeyPress(event);')); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Tanggal Dari</label>
                            </td>
                            <td>
                                <label>:</label>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <?php echo calendar_tag(array('id'=>'tanggalawal','name'=>'tanggalawal','onkeypress'=>'tanggalawal_onKeyPress(event);')); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td colspan="2">
                                <center>
                                    <label>s/d</label></center>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <?php echo calendar_tag(array('id'=>'tanggalakhir','name'=>'tanggalakhir','onkeypress'=>'tanggalakhir_onKeyPress(event);')); ?>
                                        </td>  
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Klien</label>
                            </td>
                            <td>
                                <label>
                                    :</label>
                            </td>
                            <td colspan="3">
                                <table>
                                    <tr>
                                        <td>
                                            <?php echo select_tag(array('id'=>'klien','name'=>'klien','onchange'=>'klien_onChange(event)'),$klien); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <?php echo checkbox_tag(array('id'=>'semuaklien','name'=>'semuaklien','onclick'=>'javascript:semuaklien_onClick(event)'),array('semuaklien'=>'Semua Klien')); ?>								
                            </td>
                        </tr>	
						<tr>
                            <td>
                                <label>Tema</label>
                            </td>
                            <td>
                                <label>:</label>
                            </td>
                            <td colspan="3">
                                <table>
                                    <tr>
                                        <td>
                                            <?php echo select_tag(array('id'=>'tema','name'=>'tema','onchange'=>'tema_onChange(event)'),$tema); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                						
                            </td>
                        </tr>	
						<tr>
                            <td>
                                <label>Perusahaan</label>
                            </td>
                            <td>
                                <label>:</label>
                            </td>
                            <td colspan="3">
                                <table>
                                    <tr>
                                        <td>
                                            <?php 
																						echo select_tag(array('id'=>'perusahaan','name'=>'perusahaan',
																							'onchange'=>'perusahaan_onChange(event)'),$perusahaan); 
																						#echo textbox_tag(array('id'=>'perusahaan','name'=>'perusahaan','style'=>'width:250px;'));
																						?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                						
                            </td>
                        </tr>							
                        <tr>
                            <td colspan="6">
								<?php echo button_tag(array('id'=>'buttonPreviewTanggalSekarang','name'=>'buttonPreviewTanggalSekarang','value'=>'Tanggal Sekarang','onclick'=>'javascript:buttonPreviewTanggalSekarang_onClick(event)')); ?>                         
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <div id="table-content">
					
				</div>
            </div>
        </div>
    </div>
    </form>
</body>
</html>