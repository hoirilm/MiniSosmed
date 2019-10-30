<?php

require '../func/function.php'; //MEMANGGIL DATA DARI FUNC

//CEK USER USAH SEDANG LOGIN ATAU TIDAK
if ( isset($_SESSION["login"]) ) {
   header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Login</title>
   <link rel="stylesheet" href="../css/style2.css">
</head>
<body>

   <img src="../img/logo2.png" alt="" class="logo">
   <hr><br>

   <div class="container">
      <h3>Masuk dengan alamat emailmu</h3>

      <form class="" action="login.php" method="post">
         <input type="text" name="email" value="" placeholder="Alamat email">
         <input type="password" name="password" value="" placeholder="Password">
         <p class="errormsg"><?= $errorLogin ?></p>
         <p>Belum punya akun? <a href="../process/register.php">Daftar</a></p>
         <button type="submit" name="login">Masuk</button>
      </form>
   </div>
</body>
</html>
