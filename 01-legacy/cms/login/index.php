<?php
	include "./../config.php";
	require_once("loginact.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title>Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="<?=$root?>/login/login.css" type="text/css" media="all">
<link rel="stylesheet" href="<?=$root?>/login/colors-fresh.css" type="text/css" media="all">
</head>
<body class="login">
<div id="login">

<form name="loginform" id="loginform" action="" method="post">
	<p>
		<label>Username<br><input name="uname" id="user_login" class="input" size="20" tabindex="10" type="text"></label>
	</p>
	<p>
		<label>Password<br>
		<input name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" type="password"></label>
	</p>
	<p class="submit">
    	<span style="text-align:right; color:#F00;"><?=(isset($failed))?"$failed":NULL?></span>
		<input name="wp-submit" id="wp-submit" value="Log In" tabindex="100" type="submit">
		<input name="redirect_to" value="http://rio.teknoku.com/wp-admin/" type="hidden">
		<input name="testcookie" value="1" type="hidden">
	</p>
</form>
</div>
<p id="backtoblog"><a href="<?=$rootbase?>/" title="Are you lost?">← Back to Home</a></p>
</body>
</html>