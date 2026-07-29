document.getElementById('nama').value='<?php echo $row['nama'] ?>';
document.getElementById('alamat').value='<?php echo $row['alamat'] ?>';
document.getElementById('telepon').value='<?php echo $row['telepon'] ?>';
document.getElementById('email').value='<?php echo $row['email'] ?>';
document.getElementById('perusahaan').value='<?php echo $row['perusahaan'] ?>';
id_klien = "<?php echo $row['no_id'] ?>";
jQuery.modal.close();
