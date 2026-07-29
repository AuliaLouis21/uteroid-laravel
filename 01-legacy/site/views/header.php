<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<meta name="viewport" content="width=device-width, maximum-scale=1.0, user-scalable=yes">-->
<meta name="google-site-verification" content="WR1vGmXxSCNOGgArIknFgMZhVWZiJTpjx2u1_LMuKLY" />
<meta name="Description" content="advertising malang,perusahaan advertising,utero advertising,printing,art,concept,malang" />
<meta name="Keywords" content="digital printing,printing,advertising malang,advertising,uteroadv,utero adv,advertising,malang,advertising malang,
<?php
    $konek = mysqli_connect($serper,$user_db,$passdb,$dbname)or die("<center>Error : Sql Gak Konek, hostingane dudul</center>");
	$sql = mysqli_query($konek,"SELECT * FROM catproduk ORDER BY nama ASC");

	while($dtk=mysqli_fetch_array($sql)){
?>
<?=strtolower($dtk[1]).","?>
<?php } ?>
" />
<meta name="Author" content="Woola" />
<meta name="Robots" content="Index, Follow" />
<meta http-equiv="Content-Language" content="en-us" />
<link rel="stylesheet" type="text/css" href="<?=$view?>/views/style-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=$view?>/views/style.css" />
<link rel="icon" type="image/x-icon" href="https://www.uterogroup.com/site/images/utero.ico" />
<?php include "$dirview/jscript.php"; ?>
<title><?=_Title_?></title>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125639391-28"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-125639391-28');
</script>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '252640178783361');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=252640178783361&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

</head>
<body>
    <div id="header">
        <div class="ketengah" style="height:100%;">&nbsp;</div>
    </div> 
    <div class="bar">
        <div id="menubar">
        	<ul>
            	<li><a href="<?=$root?>/" <?=page($include,"pertamax")?> title="Home" style="border-left:none;">HOME</a></li>
              <li><a href="<?=$root?>/produk.app" <?=page($include,"produk")?> title="Product">PRICE</a></li>
				<?php
				$sql = mysqli_query($konek,"SELECT * FROM page ORDER BY id ASC");
				while($dtx=mysqli_fetch_array($sql)):
				?>
				<?php
$pg = $_GET['p'] ?? '';
?>
<li>
    <a href="<?=$root?>/p/<?=$dtx[5]?>.app"
       <?=pageql($pg,$dtx[5])?>>
       <?=strtoupper($dtx[1])?>
    </a>
</li>
				<?php endwhile; ?> 
				      
              <!--<li><a href="https://wa.me/6281999900900?text=%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%20%2ASalam%20Merah%2A%20%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%0ASaya%20dapat%20informasi%20dari%20uterogroup.com%0AMau%20konsultasi%20dong%21%0ANama%20%3A%20%0AAlamat%20%3A%0ANo.%20Telp%20%3A%0AEmail%20%3A%0AKebutuhan%20%3A" <?=page($include,"produk")?> title="Product" target="_blank">PRICE</a></li>-->
                <li><a href="<?=$root?>/gallery.app" <?=page($include,'gallery')?> title="Gallery" style="border-right:none;">GALLERY</a></li>
				        <li><a href="<?=$root?>/news.app" <?=page($include,"news")?> title="News">NEWS</a></li>
            	  <li><a href="<?=$root?>/testimonial.app" <?=page($include,"testimonial")?> title="Testimonial">TESTIMONIAL</a></li>
                <!--<li style="text-align:right; width:100%; padding:0px; margin:0px;">
                	<form method="post" action="./">
                		<input type="text" name="search" value="search" onfocus="this.value=''" style="margin-right:4px;"/>
                    </form>
                </li-->
            </ul>
        </div>
    </div>   
    <div id="body">
    	<div class="barnull" style="height:10px;">
            <ul id="newsnya" style="display:none;">					
            	<?php
					$qt = mysqli_query($konek,"SELECT * FROM posts ORDER BY id DESC LIMIT 10")
      or die(mysqli_error($konek));
					while($nt=mysqli_fetch_array($qt)){
				?>
                <li><?=tanggal($nt[3])?> : <a href="<?=$root?>/news/<?=$nt[5]?>.app" title="<?=$nt[1]?>"><?=ucwords($nt[1])?></a></li>
                <?php } ?>
            </ul>            
        </div>
        <div class="ketengah">
			<?php
				//tempat modul kiri
				if($include=="gallery" || $include=="picture" || $include=="video" || $include=="audio" || $include=="index"){
					NULL;
				}else{
					require_once("$dirview/kiri.php");
				}
			?>
