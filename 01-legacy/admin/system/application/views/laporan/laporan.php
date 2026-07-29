<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Web Administrator - LAPORAN</title>   
	<?php echo jquery_ui_stylesheet_tag(); ?>
	<?php echo stylesheet_tag(); ?>
	<?php echo jquery_tag(); ?>
	<?php echo jquery_ui_tag(); ?>    
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
            <?php echo menu_child_laporan_tag(); ?>
        </div>
        <div id="headsub1">
            <h1>
                Welcome : <?php echo $user; ?>
            </h1>
        </div>
    </div>
    <div id="content">        
    </div>
    </form>
</body>
</html>