<div id="content">
	<!--h2>Entry Product</h2-->
    <div id="contentwrapper">
        <div id="contentcolumn2">
			<?=(isset($errmsg))?"<div id=\"errorform\">".$errmsg."</div>":NULL?>
            <div id="formnya">
                <form method="post">	
                    <fieldset>
                        <legend><label for="judul">JUDUL PROMO</label></legend>
                        <input type="text" name="judul" id="judul" class="judul" /><br/>
                        <input type="hidden" value="2" name="cat"/>
                    </fieldset>         
                    <fieldset>
                        <legend><label for="elm4">ISI PROMO</label></legend>
                        <span class="stextarea">
                        	<textarea name="isinya" id="elm4"></textarea>
						</span>
                        <br />
                    </fieldset>    
                    <fieldset>
                        <input type="submit" name="submit" value="post promo"  /><br>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div id="rightcolumn2">
        <table id="hor-zebra" summary="Employee Pay Sheet" >
            <thead>
                <tr>
                    <th cellpadding="8px" scope="col" class="chk">
                    	<input type="checkbox" name="all" onClick="checkAll(document.chkdel.cuk,this)"/>
                    </th>
                     <th cellpadding="8px" scope="col" class="isipost">Posts</th>
                    <th cellpadding="8px" scope="col" style="width:30px;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php if (isset($empty)): ?>
                <tr><td colspan="4" class="empty"><?=$empty?></td></td>
            <?php endif; ?>
            <form name="chkdel" method="post" >
            <?php 
                $i = 0;
                while($dt=mysql_fetch_array($ql)): 
                $i++;
            ?>	
                <tr class="odd<?=($i & 1)?>">				
                    <td class="chk"><input type="checkbox" id="cuk" name="del[]" value="<?=$dt[0]?>"/></td>
                    <td class="isipost">
	                    <a href="./?cms=<?=$include?>&sub=edit&id=<?=$dt[0]?>" title="EDIT"><?=ucwords($dt[1])?></a>
						<?=substr("$dt[2]", 0, 150)?>
                    </td>
                    <td style="text-align:center;"><a href="./?cms=<?=$include?>&sub=edit&id=<?=$dt[0]?>" title="EDIT">EDIT</a></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    	<input type="submit" name="submit" value="Delete Post" style="margin-top:8px;"/>
    </form>        
    </div>
</div>