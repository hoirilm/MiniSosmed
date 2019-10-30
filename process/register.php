<?php require '../func/function.php' ?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Register</title>
   <link rel="stylesheet" href="../css/style2.css">
</head>
<body>

   <img src="../img/logo2.png" alt="" class="logo">
   <hr><br>

   <div class="container">
      <h3>Daftar dengan emailmu</h3>
      <form class="" action="register.php" method="post">
         <input type="text" name="nama" value="" placeholder="Siapa namamu?" required>
         <p class="errormsg"><?= $errorRegisterNama ?></p>
         <input type="text" name="email" value="" placeholder="Email" required>
         <?php if ($errorRegisterEmail == ""){ ?>
            <p class="errormsg"><?= $errorRegisterEmail2 ?></p>
         <?php } else if ($errorRegisterEmail2 === ""){ ?>
            <p class="errormsg"><?= $errorRegisterEmail ?></p>
         <?php } ?>
         <input type="password" name="password" value="" placeholder="Password" required>
         <p class="errormsg"><?= $errorRegisterPass ?></p>
         <input type="password" name="confirm-password" value="" placeholder="Konfirmasi password" required>
         <p class="errormsg"><?= $errorRegisterConfirmPass ?></p>

         <div class="tglLahir">
            <h4>Ulang Tahun</h4>
            <select class="hari" name="hari">
               <option value="hari"> Hari </option>
               <?php for ($hari=1; $hari <= 31; $hari++) { ?>
                  <option value="<?= $hari ?>"><?= $hari ?></option>
               <?php } ?>
            </select>

            <select class="bulan" name="bulan">
               <option value="bulan"> Bulan </option>
               <?php $namabulan=["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Aug","Sep","Oct","Nov","Des"] ?>
               <?php for ($bulan=0; $bulan < count($namabulan); $bulan++) { ?>
                  <option value="<?= $bulan+1 ?>"><?= $namabulan[$bulan] ?></option>
               <?php } ?>
            </select>

            <select class="tahun" name="tahun">
               <option value="tahun"> Tahun </option>
               <?php $tahunini = date("Y") ?>
               <?php for ($tahun=$tahunini; $tahun >=1990 ; $tahun--) { ?>
                  <option value="<?= $tahun ?>"><?= $tahun ?></option>
               <?php } ?>
            </select>
         </div>
         <p class="errormsg"><?= $errorRegisterDate ?></p>
         <div class="jk">
            <input class="radiobtn" type="radio" name="jk" value="Laki-laki" required>Laki-laki &nbsp; &nbsp;
            <input class="radiobtn" type="radio" name="jk" value="Perempuan" required>Perempuan
         </div>

         <p>Sudah punya akun? <a href="../process/login.php">Masuk</a></p>
         <button type="submit" name="register">Daftar</button>
      </form>
   </div>
</body>
</html>
