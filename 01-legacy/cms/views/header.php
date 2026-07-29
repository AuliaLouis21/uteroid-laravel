<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CMS</title>
<link rel="stylesheet" type="text/css" href="<?=$root?>/css/style.css" />
<script type="text/javascript" src="<?=$root?>/js/checkall.js"></script>
<script type="text/javascript" src="<?=$root?>/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?=$root?>/js/customtinymce.js"></script>
<script type="text/javascript" src="<?=$root?>/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?=$root?>/js/jsfunc.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#errorform2 a").click(function () {
			$("#errorform2").fadeOut("slow");
		});
	});
</script>
<script type="text/javascript" src="<?=$root?>/js/ajaxcombo.js"></script>
</head>
<body>
<div id="header">
	<a href="./" <?=page($include,"pertamax")?> >HOME</a>
    <a href="./?cms=posts" <?=page($include,"posts")?> >POST NEWS</a>
    <a href="./?cms=pages" <?=page($include,"pages")?> >PAGES</a>
    <a href="./?cms=catalog" <?=page($include,"catalog")?> >KATALOG PRODUK</a>
    <a href="./?cms=testimonial" <?=page($include,"testimonial")?> >TESTIMONIAL</a>
    <a href="./?cms=picture" <?=page($include,"picture")?> >GALLERY</a>
    <a href="./?cms=order" <?=page($include,"order")?> >ORDER LIST</a>
    <a href="./?cms=upload" <?=page($include,"upload")?> >UPLOAD</a>
    <a href="./?cms=ads" <?=page($include,"ads")?> >IKLAN</a>	      
    <a href="./?cms=setting" <?=page($include,"setting")?> style="color:#060;">SETTING</a>
    <a href="javascript:void(0);" onclick="javascript:out('<?=$rootbase?>')" style="color:#F00; letter-spacing:-1px;">LOGOUT</a>
</div>