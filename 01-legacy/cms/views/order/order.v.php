<div id="content">
	<form method="post" style="margin:0px;padding:0px;" name="chkdel">
    <table id="hor-zebra" summary="Employee Pay Sheet" >
        <thead>
            <tr class="tbhead">
                <th style="width:20px;"><input type="checkbox" name="all" onClick="checkAll(document.chkdel.cuk,this)"/></th>
                <th>Nama</th>
                <th style="width:200px;">Produk</th>
                <th style="width:100px;">Total</th>
				<th style="width:70px;">Kota</th>				
                <th style="width:140px;">Tgl / Jam</th>
                <th style="width:70px;">&nbsp;</th>
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
                <td style="text-align:left;"><?=ucwords($dt['3'])?></td>
                <td style="color:#FF0000;">Rp. <?=number_format($dt[4], 0, ',', '.')?></td>
                <td><?=ucwords($t['1'])?></td>
                <td ><?=$dt['6']." / ".$dt['7']?></td>
				<td ><a href="./?cms=order&sub=detil&id=<?=$dt['0']?>">VIEW DETIL</a></td>
            </tr>
            <?php } ?>
        </tbody> 
    </table>
    	<input type="submit" name="submit" value="Delete" style="margin-top:8px;"/>
    </form>
</div>