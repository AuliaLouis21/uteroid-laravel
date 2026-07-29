<html>
	<head>
		<title>Web Administrator ::: NOTA RECORD</title>
		
		<?php echo jquery_tag() ?>
		<?php echo jquery_ui_tag() ?>
		<?php echo jquery_blockui_tag() ?>
		<?php echo simplemodal_tag() ?>
		<?php echo javascript_ajax_tag() ?>
		
		<?php echo jquery_ui_stylesheet_tag()?>
		<?php echo stylesheet_tag() ?>
		
		<style type='text/css'>
		</style>
		<script type='text/javascript'>
			<?php $this->load->view('notarecord/index.js') ?>
		</script>
	</head>
	<body>
		<div id='header'>
			<?php
				if($this->session->userdata('isadmin') == 'true') echo menu_tag(); 
				if($this->session->userdata('is_sc') == 'true') echo menu_non_admin_tag(); 
				if($this->session->userdata('is_qc') == 'true') echo menu_qc_tag(); 
			?></div>
		<div id='header2'>
			<div id='headsub2'><?php echo menu_child_transaksi_tag() ?></div>
			<div id='headsub1'><h1>Welcome : <?php echo $user; ?></h1></div>
		</div>
		<div id='content'>
			<div id='contentwrapper'>
				<form name='form1' id='form1' method='post'>
					<fieldset>
						<legend><?php echo label_for('Pencarian Berdasarkan')?></legend>
						<table style='float:left'>
							<tr>
								<td><?php echo label_for('No.Nota')?></td>
								<td><?php echo label_for(':')?></td>
								<td colspan='4'><?php echo textbox_tag(array('id'=>'no_nota','name'=>'no_nota','onkeyup'=>'no_nota_onKeyUp(event)'))?></td>
							</tr>
							<tr>
								<td><?php echo label_for('Tanggal Terima')?></td>
								<td><?php echo label_for(':')?></td>
								<td colspan='4'><?php echo calendar_tag(array('id'=>'tanggal_terima','name'=>'tanggal_terima','onkeyup'=>'tanggal_terima_onKeyUp(event)'))?></td>
							</tr>
							<tr>
								<td><?php echo label_for('Tanggal Dari')?></td>
								<td><?php echo label_for(':')?></td>
								<td><?php echo calendar_tag(array('id'=>'tanggal_awal','name'=>'tanggal_awal','onkeyup'=>'tanggal_awal_onKeyUp(event)'))?></td>
								<td colspan='2'><center><?php echo label_for('S/D')?></center></td>
								<td><?php echo calendar_tag(array('id'=>'tanggal_akhir','name'=>'tanggal_akhir','onkeyup'=>'tanggal_akhir_onKeyUp(event)'))?></td>
							</tr>
							<tr>
								<td></td><td></td>
								<td colspan='3'><?php echo  button_tag(array('name'=>'button_tanggal_sekarang',
										'id'=>'button_tanggal_sekarang','onclick'=>'button_tanggal_sekarang_onClick(event)',
										'value'=>'tanggal sekarang'))?>
								</td>
						</table>
					</fieldset>
				</form>
				
				<div id='table-content'></div>
			</div>
		</div>
	</body>
</html>