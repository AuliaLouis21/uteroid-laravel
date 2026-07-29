<html>
	<head>
		<title>Web Administrator ::: BAHAN BAKU </title>
		<?php echo jquery_tag()?>
		<?php echo stylesheet_tag()?>
	</head>
	<body>
		<div id="header">
        <?php if($this->session->userdata('isadmin') == 'true') echo menu_tag(); else echo menu_non_admin_tag(); ?>
    </div>
		<div id="bigloading" style="display: none;height:0px;" class='bigloading'>
			<center id="center-loading">
				<div style="top: 230px; position: relative; 
						background: url(<?php echo base_url()."resources/images/bigloading.gif"; ?>) 
						no-repeat scroll 0% 0% transparent; 
						vertical-align: middle; width: 66px; height: 66px;">
				</div>
			</center>
		</div>
		<div id='header2'>
			<div id='headsub2'><?php echo menu_child_bahan_baku_tag() ?></div>
			<div id='headsub1'><h1>Welcome : <?php echo $user; ?></h1></div>
		</div>
		<div id='content'>
			<div id='contentwrapper'>
				<form name='form1' name='form1' method='post'>
					<table border='1' style='float:left;border-collapse: collapse; border: 1px solid silver;width:700px;'>
						<tr>
							<td class='table-header'><?php echo label_for('No')?></td>
							<td class='table-header'><?php echo label_for('Bahan Baku')?></td>
							<td class='table-header' colspan='4'><?php echo label_for('Action') ?></td>
						</tr>
						<?php foreach($query_bahan_baku->result_array() as $row) { ?>
							<tr>
								<td class='table-row-center'><?php echo label_for($row['no_id'])?></td>
								<td class='table-row-left'><?php echo label_for($row['bahan_baku'])?></td>
								<td class='table-row-center'>
									<a href='<?php echo base_url().index_page().'/bahanbaku/edit/'.$row['no_id'] ?>'>
										<?php echo label_for('edit')?>
									</a>
								</td>
								<td class='table-row-center'>
									<a href='<?php echo base_url().index_page().'/bahanbaku/delete/'.$row['no_id'] ?>'>
										<?php echo label_for('delete')?>
									</a>
								</td>
								<td class='table-row-center'>
									<a href='<?php echo base_url().index_page().'/bahanbaku/jeniswarna/'.$row['no_id'] ?>'>
										<?php echo label_for('jenis/warna')?>
									</a>
								</td>
								<td class='table-row-center'>
									<a href='<?php echo base_url().index_page().'/bahanbaku/ketebalan/'.$row['no_id'] ?>'>
										<?php echo label_for('ketebalan')?>
									</a>
								</td>
							</tr>
						<?php } ?>
						<?php $query_bahan_baku->free_result() ?>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>