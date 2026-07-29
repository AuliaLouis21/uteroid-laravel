<div id="bodytengah2">
	<h1>
    	<span style="color:#FB0000">video</span>gallery 
        <span style="font-size:40px;">&raquo;</span> <?=(isset($_GET['cat']))?$tt['0']:NULL?>
    </h1>
</div>
<div id="bodytengah3">    
<?php
	if(isset($nodata)){
		echo $nodata;
	}else{
	while($vid = mysqli_fetch_array($video)):
		$p++;
		$margin=(($p % 2)==0)?"margin-right:0px;":"margin-right:26px;";
		$yid = $yvid->_GetVideoIdFromUrl($vid['3']);
?>
        <div class="listgal" style="<?=$margin?>">
            <div class="imgvid"><img src="<?=$yvid->GetImg($yid,rand(1,3))?>" alt="<?=$vid[1]?>" /></div>
            <div class="nn">
            	<a href="<?=$root?>/video/detil/<?=$vid['6']?>.flv" title="<?=$vid['1']?>"><?=ucwords($vid['1'])?></a>
            </div>
            <div class="descvid">
				<?=tanggal($vid['4'])?>
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