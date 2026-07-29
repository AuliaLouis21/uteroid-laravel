<html>
	<head>
		<title>Web Administrator ::: EDIT USER</title>
		<?php echo jquery_tag(); ?>
		<?php echo stylesheet_tag(); ?>
		<?php echo jquery_ui_stylesheet_tag(); ?>
	</head>
	<body>
		<div id="header">
      <?php
				if($this->session->userdata('isadmin') == 'true') echo menu_tag(); 
				if($this->session->userdata('is_sc') == 'true') echo menu_non_admin_tag(); 
				if($this->session->userdata('is_qc') == 'true') echo menu_qc_tag(); 
			?>
    </div>
		<form id="form1" name="form1" action="<?php echo base_url().index_page().'/users/save/'; ?>" method="post">
	    	<div id="header2">
	        	<div id="headsub2">
					
	        	</div>
	        	<div id="headsub1">
	            	<h1>
	                	Welcome : <?php echo $user; ?>
	            	</h1>
	        	</div>
	    	</div>
			<div id="content">
				<fieldset id="fieldset1">
                    <legend>User Administration</legend>
					<table style="float: left;">
						<tr>
							<td><?php echo label_for("User Name"); ?></td>
							<td><?php echo label_for(":"); ?></td>
							<td><?php echo textbox_tag(array('id'=>"username","name"=>"username","value"=>$users['user_name'])); ?></td>
						</tr>
						<tr>
							<td><?php echo label_for('Old Password'); ?></td>
							<td><?php echo label_for(":"); ?></td>
							<td><?php echo password_tag(array("id"=>"password","name"=>"password","value"=>$users['password'])); ?></td>
						</tr>
						<tr>
							<td><?php echo label_for("Full Name"); ?></td>
							<td><?php echo label_for(":"); ?></td>
							<td><?php echo textbox_tag(array("id"=>"fullname","name"=>"fullname","value"=>$users['full_name'])); ?></td>
						</tr>
						<tr>
							<td colspan="3">
								<?php echo button_tag(array("type"=>"submit","id"=>"save","name"=>"save","value"=>"hapus")); ?>
								<?php echo hidden_tag(array("id"=>"no_user","name"=>"no_user","value"=>$users['no_user'])); ?>
								<?php echo hidden_tag(array("id"=>"action","name"=>"action","value"=>"delete")); ?>
							</td>
						</tr>
					</table>
				</fieldset>
			</div>
		</form>
	</body>
</html>