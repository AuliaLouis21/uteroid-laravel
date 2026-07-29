<div id="content">
	<form method="post" style="margin:0px;padding:0px;" name="chkdel">
    <table id="hor-zebra" summary="Employee Pay Sheet" >
        <thead>
            <tr class="tbhead">
                <th style="width:20px;"><input type="checkbox" name="all" onClick="checkAll(document.chkdel.cuk,this)"/></th>
                <th	style="width:200px;">Pengirim</th>
                <th >Testimonial</th>                
                <th style="width:150px;">Email</th>
                <th style="width:120px;">tgl/jam</th>
                <th style="width:100px;">IP Address</th>
                <th style="width:70px;">Approve</th>
            </tr>
        </thead>
        <tbody>
        	<?php
				while($dt=mysql_fetch_array($ql)){
					$i++;
					$bg=(($i%2)==0)?"background-color:#EBF5FE;":"background-color:#F4FAFF;";
					$sudah="<img src=\"./images/yes.gif\" alt=\"approved\" title=\"Testi Has Been Approved\">";
					$belum="<a href=\"./?cms=testimonial&sub=approve&id=".$dt['0']."\" style=\"color:#F00;\" 
							onclick=\"if(!confirm('Mau Di Approve ta??')) return false;\">Approve?</a>";
					$berbintang=($dt['8']=="1")?NULL:"<span style=\"color:#F00; font-size:20px; font-weight:bold;\">*</span>";
			?>
            <tr class="tbrow" style="<?=$bg?>">
				<td><input type="checkbox" id="cuk" name="del[]" value="<?=$dt[0]?>" /></td>
                <td style="text-align:left;">
                  <b><?=ucwords($dt['2'])?></b><?=$berbintang?><br />
					<?=($dt['4']!="")?$dt['4']:NULL?>
				</td>
                <td style="text-align:left;"><?=htmlentities($dt['1'])?></td>
                <td style="font-size:10px;"><?=$dt['3']?></td>
                <td style="font-size:10px;"><?=$dt['5']." | ".$dt['6']?></td>
                <td><?=$dt['7']?></td>
                <td ><?=($dt['8']=="1")?"$sudah":"$belum"?></td>
            </tr>
            <?php } ?>
        </tbody> 
    </table>
    	<input type="submit" name="submit" value="Delete Testi" style="margin-top:8px;"/>
    </form>
</div>