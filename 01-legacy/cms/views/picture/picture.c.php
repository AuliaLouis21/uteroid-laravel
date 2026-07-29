<div id="content">
	<!--h2>Entry Product</h2-->
    <div id="contentwrapper">
        <div id="contentcolumn2">
            <form method="post" style="margin:0px;padding:0px;" name="chkdel">
            <table id="hor-zebra" summary="Employee Pay Sheet" >
                <thead>
                    <tr class="tbhead">
                        <th style="width:20px;">
                        	<input type="checkbox" name="all" onClick="checkAll(document.chkdel.cuk,this)"/>
						</th>                      
                        <th style="width:150px;">Judul</th>
                        <th>INFO / Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($dt=mysql_fetch_array($ql)){
                            $i++;
                            $bg=(($i%2)==0)?"background-color:#EBF5FE;":"background-color:#F4FAFF;";
                            
                            $t = explode('#',$dt['2']);
                    ?>
                    <tr class="tbrow" style="<?=$bg?>">
                        <td><input type="checkbox" id="cuk" name="del[]" value="<?=$dt[0]?>" /></td>
                        <td style="text-align:left;"><?=ucwords($dt['1'])?></td>
                        <td style="text-align:left;"><?=substr($dt['3'],0,60)?></td>
                    </tr>
                    <?php } ?>
                </tbody> 
            </table>
                <input type="submit" name="submit" value="Delete Images" style="margin-top:8px;"/>
            </form>
        </div>
    </div>
    <div id="rightcolumn2">
    	<?=(isset($errmsg))?"<div id=\"errorform2\">".$errmsg."</div>":NULL?>
    	<span class="titleform">Upload Images</span>
        <form method="post" class="cssformright" enctype="multipart/form-data">      
            <p>
            	<label for="nama">ALBUM</label>
            	<select name="cat">
                	<option value="">--------PILIH KATEGORI-------</option> 
                	<?=$gx?>
                </select>
                <a href="./?cms=<?=$include?>&sub=cat" title="tes"><b>+</b> Add New Album</a> 
            </p>
            
            <p>
            	<label for="nama">JUDUL</label>
            	<input type="text" name="nama" id="nama" value="<?=(isset($error))?$_POST['nama']:NULL;?>"/>
            </p>
            
            <p>
            	<label for="descript">KETERANGAN</label>
                <textarea name="descript" id="descript"><?=(isset($error))?$_POST['descript']:NULL;?></textarea>
            </p>            
            
			<p>
            	<label for="img">GAMBAR</label>
            	<input type="file" name="img" id="img"/>
            </p>     
            
            <p>
            	<label>&nbsp;</label>
                <input type="submit" name="submit" value="upload"  style="text-transform:uppercase; font-size:14px;"/>
            </p>            
        </form>
    </div>
</div>