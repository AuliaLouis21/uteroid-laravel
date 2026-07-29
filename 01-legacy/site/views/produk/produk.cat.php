            <div id="bodytengah">
                <div class="label">Produk </div>
                <table border="0" cellpadding="0" cellspacing="1" class="tbspec" style="border:1px solid #EBF5FE;">
                    <tr class="trhead">
                        <td style="width:36px;">&nbsp;</td>
                        <td style="width:210px;">Nama Produk</td>
                        <td>Min Order</td>
                        <td>Harga Satuan</td>
                        <!--td style="width:20px;">&nbsp;</td-->
                    </tr>
                    <?php 
                        echo (isset($empty))?"<tr><td colspan=\"5\"><span class=\"empty\">$empty</span></td></tr>":NULL;
                        
                        while($dtr = mysqli_fetch_array($qlr)):
                        $i++;
                        $bg=(($i % 2) == 0) ? "background-color:#EBF5FE;" : "background-color:#F4FAFF;";
                        #echo $i % 3 ."<br>";
                    ?>               
                    <tr class="rowz" style="<?=$bg?>">
                        <td style="text-align:center;">
                            <img src="<?=$root?>/img/imgcropkecil/<?=$dtr['0']?>.pic" alt="<?=$dtr[1]?>" style="<?=$imgcss?>"/>
                        </td>
                        <td><a href="<?=$root?>/produk/<?=$dtr[4]?>.app"><?=$dtr[1]?></a></td>
                        <td style="text-align:center;"><?=$dtr[2]?></td>
                        <td style="text-align:right;"><?=number_format($dtr[3], 0, ',', '.')?></td>
                        <!--td>[v]</td-->
                    <?php endwhile; ?>
                </table>           
			</div>