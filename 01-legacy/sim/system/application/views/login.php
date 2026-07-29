<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Welcome To Admin Utero</title>
    <?php echo login_stylesheet_tag(); ?>
</head>
<body class="login">
    <div id="login">
        <form name="loginform" id="loginform" action="<?php echo $posturl; ?>" method="post" runat="server">
        <p>
            <label>
                Username
                <br>
				<input type="text" class="input input-text" id="username" name="username"/>
            </label>
        </p>
        <p>
            <label>
                Password
                <br>
                <input type="password" class="input input-text" id="password" name="password"/>
            </label>
        </p>
        <p class="submit">
            <span style="text-align: right; color: rgb(255, 0, 0);"></span>
            <input name="wp-submit" id="wp-submit" value="Log In" tabindex="100" type="submit" onclick="return wp-submit_onclick()">
        </p>
        </form>
    	<div style='margin:10px 0px 0px 10px;text-align:center;color:red;font-size:14px;'>
		<?php
			$flash_notice = $this->session->userdata('flash_notice');
			if(isset($flash_notice['error_login_notice'])) {
				echo $flash_notice['error_login_notice'];
			}
		?>
		</div>
	</div>
</body>
</html>