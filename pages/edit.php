<?php
//UNSET SESSION SEARCH
unset($_SESSION["search"]);
?>

<!-- DIV UNTUK EDIT PROFILE -->
<div class="editPage">
   <div class="editPribadi">
      <h3>Data pribadi</h3>
      <form class="" action="index.php?page=edit" method="post" enctype="multipart/form-data">
         <input type="text" name="nama" value="<?= $user[0]['NAMA'] ?>" placeholder="Siapa namamu?" required>
         <h4>Foto Profile</h4>
         <input type="file" name="foto" class="gambar">

         <!-- MENGECEK ERROR -->
         <?php if ($errorEditNama !== ""){ ?>
            <p class="errormsg"><?= $errorEditNama ?></p>
         <?php }else if ( $errorEditFoto !== ""){ ?>
            <p class="errormsg"><?= $errorEditFoto ?></p>
         <?php } ?>

         <button type="submit" name="update1">Simpan perubahan</button>
      </form>
   </div>
   <hr>


   <!-- DIV UNTUK EDIT PASSWORD -->
   <div class="editPassword">
      <h3>Keamanan</h3>
      <form class="" action="index.php?page=edit" method="post">
         <input type="password" name="passLama" value="" placeholder="Password lama" required>
         <input type="password" name="passBaru" value="" placeholder="Password baru" required>
         <input type="password" name="confirmPassBaru" value="" placeholder="Konfirmasi password baru" required>
         <p class="errormsg"><?= $errorEditPassword ?></p> 
         <button type="submit" name="update2">Simpan perubahan</button>
      </form>
   </div>
</div>
