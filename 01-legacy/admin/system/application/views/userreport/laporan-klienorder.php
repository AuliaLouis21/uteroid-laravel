<html>
	<head>
		<title>Laporan Nota ::: LAPORAN KLIEN ORDER ::: <?=$user?></title>
		<?=jquery_tag()?>
		<?=jquery_ui_tag()?>
		<?=jquery_ui_stylesheet_tag()?>
		<?=stylesheet_tag()?>
		<?= simplemodal_tag() ?>
		<?= javascript_util_tag() ?>
		<?= jquery_blockui_tag() ?>
		<?= javascript_ajax_tag() ?>
		<? $this->load->view('userreport/laporan-klienorder.js.php',array('user_code',$user_code)) ?>
	</head>
	<body>
   <div id="header">
       <?php
				if($this->session->userdata('isadmin') == 'true') echo menu_tag(); 
				if($this->session->userdata('is_sc') == 'true') echo menu_non_admin_tag(); 
				if($this->session->userdata('is_qc') == 'true') echo menu_qc_tag(); 
			?>
    </div>
    <form id="form1" name="form1" runat="server">
    <div id="header2">
      <div id="headsub2"><?= menu_child_laporan_non_admin_tag(); ?></div>
			<div id="headsub1"><h1> Welcome : <?= $user; ?></h1></div>
    </div>
    <div id="content">
        <div id="contentwrapper">
            <div>
                <fieldset id="fieldset1">
                    <legend>Pencarian Berdasarkan</legend>
                    <table style="float: left;">
                        <tr>
                            <td><?=label_for('No. Nota')?></td>
                            <td><?=label_for(':')?></td>
                            <td>
                                <table>
                                    <tr>
                                        <td><?= textbox_tag(array('id'=>'nonota',
																							'name'=>'nonota','onkeypress'=>'nonota_onKeyPress(event);')); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td><?=label_for('Tanggal Terima')?></td>
                            <td><?=label_for(':')?></td>
                            <td>
                                <table>
                                    <tr>
                                        <td><?=calendar_tag(array('id'=>'tanggalterima',
																							'name'=>'tanggalterima','onkeypress'=>'tanggalterima_onKeyPress(event);')); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><?=label_for('Tanggal Dari')?></td>
                            <td><?=label_for(':')?></td>
                            <td>
                                <table>
                                    <tr>
                                        <td><?= calendar_tag(array('id'=>'tanggalawal',
																							'name'=>'tanggalawal','onkeypress'=>'tanggalawal_onKeyPress(event);')); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td colspan="2"><center><?=label_for('s/d')?></center>
                            </td>
                            <td>
                                <table>
                                    <tr>
																				<td><?= calendar_tag(array('id'=>'tanggalakhir',
																							'name'=>'tanggalakhir','onkeypress'=>'tanggalakhir_onKeyPress(event);')); ?>
                                        </td>  
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
															<?= button_tag(array('id'=>'buttonPreviewTanggalSekarang',
																	'name'=>'buttonPreviewTanggalSekarang','value'=>'Tanggal Sekarang',
																	'onclick'=>'javascript:buttonPreviewTanggalSekarang_onClick(event)')); ?>                         
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
</html>