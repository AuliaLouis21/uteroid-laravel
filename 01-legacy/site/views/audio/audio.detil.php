<div id="bodytengah3">
	<h1><?=$pi['1']?></h1>
    
    <div class="detilgal">
    	<div class="img">
        <?=$yvid->EmbedVideo($pi['3'],554,400)?>
        </div>
    </div>  
</div>
<div id="bodykanan2" style="margin-top:50px;">
	<div class="desckanan">
        <span class="block"><b>KETERANGAN:</b></span>
        <span class="block">
        	<?=ucfirst(nl2br($pi['2']))?>
        </span>
    </div>
    <a href="<?=$root?>/video.app" title="back">&larr; Back to Video Gallery</a>
</div> 