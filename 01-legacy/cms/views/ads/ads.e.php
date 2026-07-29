<div id="content">
	<!--h2>Entry Product</h2-->
    <div id="contentwrapper">
        <div id="contentcolumn2" style="padding-right:8px;">
            <form method="post" style="margin:0px;padding:0px;" name="chkdel">
            <table id="hor-zebra" summary="Employee Pay Sheet" >
                <thead>
                    <tr class="tbhead">
                        <th style="width:20px;">
                        	<input type="checkbox" name="all" onClick="checkAll(document.chkdel.cuk,this)"/>
						</th>                      
                        <th style="width:150px;">Judul</th>
                        <th>INFO / Keterangan</th>
                        <th style="width:70px;">View</th>
						<th style="width:30px;">EDIT</th>                          
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
                        <td style="text-align:left;"><?=substr($dt['2'],0,60)?> ...</td>
                        <td style="color:#FF0000;"><?=$dt[7]?></td>
                        <td>
                        	<a href="./?cms=ads&sub=edit&id=<?=$dt[0]?>" title="edit">EDIT</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody> 
            </table>
                <input type="submit" name="submit" value="Delete" style="margin-top:8px;"/>
            </form>
        </div>
    </div>
    <div id="rightcolumn2">
    	<?=(isset($errmsg))?"<div id=\"errorform2\">".$errmsg."</div>":NULL?>
    	<span class="titleform">Upload File</span>
        <form method="post" class="cssformright" enctype="multipart/form-data">            
            <p>
            	<label for="nama">JUDUL</label>
            	<input type="text" name="nama" id="nama" value="<?=($bt=="edit")?$dtx['1']:NULL;?>"/>
            </p>     

            <p>
            	<label for="info">INFO / KETERANGAN</label>
                <textarea name="info" id="info"><?=($bt=="edit")?$dtx['2']:NULL;?></textarea>
            </p>                   
            
			<p>
            	<label for="file">PILIH GAMBAR</label>
            	<input type="file" name="file" id="file"/>
            </p>     
            
            <p>
            	<label>&nbsp;</label>
                <input type="submit" name="submit" value="<?=$bt?>"  style="text-transform:uppercase; font-size:14px;"/>
                <br><br><b style="color:#F00;">&nbsp;&nbsp;&nbsp;NB : Gambar Iklan Minimum Lebarnya 300px</b>
            </p>            
        </form>
    </div>
</div>