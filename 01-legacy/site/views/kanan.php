<?php require("$func/footerkanan.php") ?>
<div id="bodykanan">
        <?php
                while($dpro=mysqli_fetch_array($qupro)){
        ?>
    <div class="isikanan2">
                <a target="_blank" href="<?=$root?>/news/<?=$dpro['5']?>.app"><?=ucwords($dpro['1'])?></a>
        <?=strip_tags(substr("$dpro[2]", 0, 150))?> ...
    </div>
    <?php } ?>
        <?php
        while($ads=mysqli_fetch_array($qads)){
    ?>
                <div class="isikanan img1">
<?php

// The Regular Expression filter
//$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

// The Text you want to filter for urls
//$text = $ads['1'];
//$text=mysqli_query("SELECT judul FROM ads ORDER BY id DESC",$konek);

// Check if there is a url in the text
if(preg_match("/(http|https|ftp|ftps|.com|.net|.org|.co.id)/", $ads['0'], $matches)) {

       // make the urls hyper links
       ?><a target="_blank" href="<?=$ads['0']?>" title="<?=$ads['0']?>">
<?php ;

} else {

       // if no urls in the text just return the text
       ?><a href="<?=$root?>/ads/<?=$ads['1']?>.app" title="<?=$ads['0']?>"><?php ;

}
?>

                <img src="https://www.uterogroup.com/ads/imgads/<?=$ads['1']?>.pic" alt="<?=$ads['0']?>"/>
            </a>
        </div>
    <?php } ?>
</div>
