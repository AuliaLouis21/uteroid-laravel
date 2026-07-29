<div id="bodytengah3">
	<h1><?=$pi['1']?></h1>
    
    <div class="detilgal">
    	<div class="img"><img src="https://www.uterogroup.com/gal/galdetil/<?=$pi['6']?>.pic" alt="<?=$pi['2']?>"/></div>
    </div>
    <div class="detilgal">
        <div class="judul" style="background:url(../images/add.gif) left 4px no-repeat #FFF;">
            <a href="javascript:null(0);" id="btadd" style="text-decoration:none; margin-left:16px;">Leave Comment</a>
        
        </div>
        <div class="formcomm" id="formadd" style="display:none;">
            <form method="post" method="post" >
                <span>
                    <label for="nama">Name</label>
                    <input type="text" name="nama" title="Your Name" id="nama" value=""/>
                    <div class="error"></div>
                </span>
        
                <span>
                    <label for="mail">Email</label>
                    <input type="text" name="mail" title="your email" id="mail" value=""/>
                    <div class="error"></div>
                </span>                    
                <span>
                    <label for="testinya">Your Comment</label>
                    <textarea name="testinya" id="testinya"></textarea>
                    <div class="error"></div>
                </span>
                <span>
                    <label for="code">Security Code</label>
                    <img src="http://uterogroup.com/captcha/imgcap.3gp" alt="captcha" style="float:left; border:1px solid #666;"/>
                    <input type="text" name="code" title="Security code" AUTOCOMPLETE="OFF" style="width:150px; font-size:29px; margin-left:4px; float:left; height:34px;" id="code" maxlength="7"/>
                    <div class="error"></div>
                </span>
                <span>
                    <label>&nbsp;</label>
                    <input type="submit" name="submit" value="SEND TESTIMONIAL"/>
                </span>
            </form>
        </div>
    </div-->    
</div>
<div id="bodykanan2" style="margin-top:50px;">
	<div class="desckanan">
        <span class="block"><b>KETERANGAN:</b></span>
        <span class="block">
        	<?=ucfirst(nl2br($pi['3']))?>
        </span>
    </div>
    <a href="<?=$root?>/picture.app" title="back">&larr; Back to Picture Gallery</a>
</div> 