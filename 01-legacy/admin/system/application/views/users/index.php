<html>
	<head>
		<title>Web Administrator ::: USER </title>
		<?php echo jquery_tag(); ?>
		<?php echo stylesheet_tag(); ?>
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
	        	<div id="headsub2">
					
	        	</div>
	        	<div id="headsub1">
	            	<h1>
	                	Welcome : <?php echo $user; ?>
	            	</h1>
	        	</div>
	    	</div>
			<div id="content">
				<div id='content-wrapper'>
					<div>
		                <fieldset id="fieldset1">
		                    <legend>User Administration</legend>
							<table style="float: left;border-collapse:collapse;border:1px solid silver;" border="1" cellpadding="4">
								<tr>
									<td><?php echo label_for('User Id'); ?></td>
									<td><?php echo label_for('User Name'); ?></td>
									<td><?php echo label_for('Password'); ?></td>
									<td><?php echo label_for('Full Name'); ?></td>
									<td><?php echo label_for('Action'); ?></td>
								</tr>
								<?php 
									foreach($users->result_array() as $row) {
										echo "<tr>";
										echo "<td>".label_for($row['no_user'])."</td>";
										echo "<td>".label_for($row['user_name'])."</td>";
										echo "<td>".label_for($row['password'])."</td>";
										echo "<td>".label_for($row['full_name'])."</td>";
										echo "<td>
												<a href='".base_url().index_page()."/users/edit/".$row['no_user']."'>".label_for("Edit")."</a>
												<a href='".base_url().index_page()."/users/delete/".$row['no_user']."'>".label_for("Delete")."</a>";
										echo "</tr>";
									}
									$users->free_result();
								?>
							</table>
						</fieldset>
					</div>
				</div>        
		    </div>
		</form>
	</body>
</html>