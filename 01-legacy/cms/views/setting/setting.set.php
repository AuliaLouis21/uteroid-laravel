<div id="content" style="width:800px;; float:left;">
	<div id="formsetting" style="width:800px;">
    	<h2>Email Order</h2>
        <h5 style="color:#0C0;"><?=(isset($m))?"$m":""?></h5>
        <form method="post">                       
            <p>
                <label for="mail">Email</label>
                <textarea name="mail"></textarea>
                <span>Gunakan pembatas koma ( , ) untuk menambahkan alamat email</span>
                <?=(isset($msg['mail']))?"<i>".$msg['mail']."</i>":""?>
            </p>                        
            <p>
            	<label>&nbsp;</label>
                <input type="submit" name="loginfo" value="save"  />
            </p>
        </form>
    </div>
</div>