<div id="bodytengah2">
	<h1>
    	<span style="color:#FB0000">image</span>gallery 
        <span style="font-size:40px;">&raquo;</span> <?=(isset($_GET['cat']))?$tt['0']:NULL?>
    </h1>
</div>
<div id="bodytengah3">    
<?php
	if(isset($nodata)){
		echo $nodata;
	}else{
	while($pic=mysqli_fetch_array($picture)):
		$p++;
		$margin=(($p % 2)==0)?"margin-right:0px;":"margin-right:26px;";
?>
        <div class="listgal" style="<?=$margin?>">
            <div class="img"><img src="https://www.uterogroup.com/gal/crop/<?=$pic['6']?>.pic" alt="<?=$pic['2']?>"/></div>
            <div class="desc">
            	<a href="<?=$root?>/picture/detil/<?=$pic['6']?>.jpg" title="<?=$pic['1']?>"><?=ucwords($pic['1'])?></a>
				<b>&rarr;</b> <?=tanggal($pic['4'])?>
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
        $sql = mysqli_query($konek,"SELECT * FROM albumpic ORDER BY nama ASC");
        while($dtx=mysqli_fetch_array($sql)):
    ?>				
        <li><a href="<?=$root?>/picture/cat/<?=$dtx[2]?>/" title="category: <?=$dtx[1]?>"><?=$dtx[1]?></a></li>
    <?php endwhile; ?>
    <li><a href="<?=$root?>/video.app" title="Video Gallery">Video Gallery</a></li>
    <li><a href="<?=$root?>/audio.app" title="Video Gallery">Audio Gallery</a></li>
    </ul>
</div> 