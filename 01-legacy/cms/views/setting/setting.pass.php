<div id="content" style="width:800px;; float:left;">
	<div id="formsetting" style="width:800px;">
    	<h2>Name & Email</h2>
        <h5 style="color:#0C0;"><?=(isset($m))?"$m":""?></h5>
        <form method="post">                       
            <p>
                <label for="nama">Nama Anda</label>
                <input type="text" name="nama" id="nama" value="<?=$dt['0']?>"/>
                <span>&nbsp;</span>
                <?=(isset($msg['nama']))?"<i>".$msg['nama']."</i>":""?>
            </p>
            <p>
                <label for="mail">Email</label>
                <input type="text" name="mail" id="mail" value="<?=$dt['1']?>"/>
                <span>&nbsp;</span>
                <?=(isset($msg['mail']))?"<i>".$msg['mail']."</i>":""?>
            </p>                        
            <p>
            	<label>&nbsp;</label>
                <input type="submit" name="loginfo" value="save"  />
            </p>
        </form>
    </div>
</div>
<div id="content" style="width:800px;; float:left;">
	<div id="formsetting">
    	<h2>Change Password</h2>
        <form method="post">                       
            <p>
                <label for="user">Username</label>
                <input type="text" name="user" id="user" value="<?=$qlx[0]?>"/>
                <?=(isset($msg['user']))?"<i>".$msg['user']."</i>":""?>
            </p>
            <p>
                <label for="passlama">Password Sekarang</label>
                <input type="password" name="passlama" id="passlama"/>
                <i><?=(isset($msg['passlama']))?$msg['passlama']:""?></i>  
            </p>            
            <p style="background-color:#efefef;">
                <label for="pass">Password Baru</label>
                <input type="password" name="pass" id="pass"/>
                <i><?=(isset($msg['pass']))?$msg['pass']:""?></i>  
            </p>
            <p style="background-color:#efefef;">
                <label for="pass2">Ulangi Password</label>
                <input type="password" name="pass2" id="pass2"/>
                <i><?=(isset($msg['pass2']))?$msg['pass2']:""?></i>  
            </p>                         
            <p>
            	<label>&nbsp;</label>
                <input type="submit" name="password" value="save"  />
            </p>
        </form>
    </div>
</div>