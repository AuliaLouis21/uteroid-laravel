<div class="bodytengahgal">

    <h1>
        <span style="color:#FB0000">image</span>gallery
        <span style="font-size:40px;">&raquo;</span>
    </h1>

<?php
while($pic = mysqli_fetch_array($picture)):
    $p++;
    $margin = (($p % 3) == 0) ? "margin-right:0px;" : "margin-right:26px;";
?>

    <div class="listgal" style="<?=$margin?>">

        <div class="img">
            <img
                src="https://www.uterogroup.com/gal/crop/<?=$pic['6']?>.pic"
                alt="<?=htmlspecialchars($pic['1'], ENT_QUOTES)?>"
                style="width:100%;height:132px;object-fit:cover;border:0;"
            />
        </div>

        <div class="desc">
            <a href="<?=$root?>/picture/detil/<?=$pic['6']?>.jpg"
               title="<?=htmlspecialchars($pic['1'], ENT_QUOTES)?>">
                <?=ucwords($pic['1'])?>
            </a>
            <b>&rarr;</b>
            <?=tanggal($pic['4'])?>
        </div>

    </div>

<?php endwhile; ?>

    <span class="lineboth" style="margin-right:16px;font-size:14px;border:none;">
        <a href="<?=$root?>/picture.app">
            View All Images &rarr;
        </a>
    </span>

</div>



<div class="bodytengahgal" style="margin-bottom:10px;">

    <h1>
        <span style="color:#FB0000">video</span>gallery
        <span style="font-size:40px;">&raquo;</span>
    </h1>

<?php
while($vid = mysqli_fetch_array($video)):
    $v++;
    $margin = (($v % 6) == 1) ? "margin-left:0px;" : "margin-left:24px;";
    $yid = $yvid->_GetVideoIdFromUrl($vid['3']);
?>

    <div class="vidgal" style="<?=$margin?>">

        <div class="img">
            <img
                src="<?=$yvid->GetImg($yid, rand(1,3))?>"
                alt="<?=htmlspecialchars($vid['1'], ENT_QUOTES)?>"
                style="width:120px;border:0;"
            />
        </div>

        <div class="desc">
            <a href="<?=$root?>/video/detil/<?=$vid['6']?>.flv"
               title="<?=htmlspecialchars($vid['1'], ENT_QUOTES)?>">
                <?=$vid['1']?>
            </a>
        </div>

    </div>

<?php endwhile; ?>

    <span class="lineboth" style="margin-right:16px;font-size:14px;border:none;">
        <a href="<?=$root?>/video.app">
            View All Videos &rarr;
        </a>
    </span>

</div>



<div class="bodytengahgal" style="margin-bottom:10px;">

    <h1>
        <span style="color:#FB0000">audio</span>gallery
        <span style="font-size:40px;">&raquo;</span>
    </h1>

<?php
while($aud = mysqli_fetch_array($audio)):
    $a++;
    $margin = (($a % 3) == 0) ? "margin-right:0px;" : "margin-right:26px;";
?>

    <div class="listgal" style="<?=$margin?>">

        <div class="imgmp3">

            <object
                type="application/x-shockwave-flash"
                data="http://flash-mp3-player.net/medias/player_mp3_maxi.swf"
                width="200"
                height="20">

                <param name="movie"
                       value="http://flash-mp3-player.net/medias/player_mp3_maxi.swf"/>

                <param name="FlashVars"
                       value="mp3=<?=$root?>/mp3/<?=$aud['3']?>&showstop=1&showvolume=1"/>

            </object>

        </div>

        <div class="descmp3">

            <?=ucwords($aud['1'])?>
            <b>&rarr;</b>
            <?=tanggal($aud['4'])?>

        </div>

    </div>

<?php endwhile; ?>

    <span class="lineboth" style="margin-right:16px;font-size:14px;border:none;">
        <a href="<?=$root?>/audio.app">
            View All Audio &rarr;
        </a>
    </span>

</div>