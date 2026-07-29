<div id="bodytengah2">
	<h1>
    	<span style="color:#FB0000">audio</span>gallery 
        <span style="font-size:40px;">&raquo;</span> <?=(isset($_GET['cat']))?$tt['0']:NULL?>
    </h1>
</div>
<div id="bodytengah3">
	<script type='text/javascript' src='http://www.longtailvideo.com/jw/embed/swfobject.js'></script>    
<?php
	if(isset($nodata)){
		echo $nodata;
	}else{
	while($aud=mysqli_fetch_array($video)):
		$p++;
		$margin=(($p % 2)==0)?"margin-right:0px;":"margin-right:26px;";
		#$yid = $yvid->_GetVideoIdFromUrl($vid['3']);
?>
        <div class="listgal" style="<?=$margin?>">
            <div class="imgmp3">		
            <object type="application/x-shockwave-flash" data="http://flash-mp3-player.net/medias/player_mp3_maxi.swf" width="200" height="20">
             <param name="movie" value="http://flash-mp3-player.net/medias/player_mp3_maxi.swf" />
             <param name="FlashVars" value="mp3=<?=$root?>/mp3/<?=$aud['3']?>&showstop=1&showvolume=1" />
            </object>
            </div>
            <div class="descmp3">
                <?=ucwords($aud['1'])?>
            <b>&rarr;</b> <?=tanggal($aud['4'])?>
            </div>
        </div>        
<?php
	endwhile;
	}
?> 
</div>
<div id="bodykanan2">    
    <div class="label">Category Picture</div>
    <ul class="menukiri">
    <?php
        $sql = mysqli_query($konek, "SELECT * FROM albumpic ORDER BY nama ASC");

while($dtx = mysqli_fetch_array($sql)):
    ?>				
        <li><a href="<?=$root?>/picture/cat/<?=$dtx[2]?>/" title="category: <?=$dtx[1]?>"><?=$dtx[1]?></a></li>
    <?php endwhile; ?>
    	<li><a href="<?=$root?>/video.app" title="Video Gallery">Video Gallery</a></li>
    	<li><a href="<?=$root?>/audio.app" title="Video Gallery">Audio Gallery</a></li>
    </ul>
</div> 