<div id="content">
	<?=(isset($errmsg))?"<div id=\"errorform\">".$errmsg."</div>":NULL?>
    <div id="formnya">
        <form method="post">	
        	<fieldset>
                <legend><label for="judul">JUDUL BERITA</label></legend>
                <input type="text" name="judul" value="<?=($_GET['sub']=="edit")?$dt[1]:NULL?>" id="judul" class="judul" /><br/>
            </fieldset>         
            <fieldset>
                <legend><label for="elm4">ISI BERITA</label></legend>
               	<span class="stextarea"><textarea name="isinya" id="elm4"><?=($_GET['sub']=="edit")?$dt[2]:NULL?></textarea></span>
                <br />
            </fieldset>    
            <fieldset>
                <input type="submit" name="submit" value="<?=$bt?>"  /><br>
            </fieldset>
        </form>
    </div>
</div>