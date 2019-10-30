<?php

require 'func/function.php'; // untuk memanggil file funtion.php dari dalam folder func

//cek user sudah login atau tidak
if ( !isset($_SESSION["login"]) ) {
   header("Location: process/login.php"); //posisi halaman aktif mengikuti index
}


//SWAP QUERY ANTARA POSTING DAN CARI ORANG
$statement = $koneksi -> query("$query");
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $rows[] = $row;
}

//UNTUK MEMANGGIL DATA USER YANG SEDANG LOGIN
$emailUser = $_SESSION['user'];
$statement = $koneksi -> query("SELECT * FROM USER WHERE EMAIL = '$emailUser'");
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $user[] = $row;
}

//UNTUK MENGHITUNG JUMLAH FOLLOWING
$statement = $koneksi -> query("SELECT COUNT(USE_EMAIL) FROM FOLLOW_USERS WHERE EMAIL = '$emailUser'");
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $countFing[] = $row;
}

//UNTUK MENGHITUNG JUMLAH FOLLOWERS
$statement = $koneksi -> query("SELECT COUNT(EMAIL) FROM FOLLOW_USERS WHERE USE_EMAIL = '$emailUser'");
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $countFwer[] = $row;
}

//UNTUK MENGAMBIL DATA FOLLOWING (email dari following disimpan kedalam array following)
$statement = $koneksi -> query("SELECT FOLLOW_USERS.USE_EMAIL FROM FOLLOW_USERS WHERE FOLLOW_USERS.EMAIL = '$emailUser'");
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $following[] = $row;
}

//UNTUK MENGAMBIL DATA FOLLOWERS (email dari follower disimpan kedalam array followers)
$statement = $koneksi -> query("SELECT FOLLOW_USERS.EMAIL FROM FOLLOW_USERS WHERE FOLLOW_USERS.USE_EMAIL = '$emailUser'");
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $followers[] = $row;
}

//UNTUK MEMANGGIL DATA TEMAN DAN DISIMPAN DALAM ARRAY USER
if (isset($friendsp[0]['EMAIL'])) {
   $email = $friendsp[0]['EMAIL'];
   $statement = $koneksi -> query("SELECT * FROM USER WHERE EMAIL = '$email'");
   while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
      $user[] = $row;
   }
}

//UNTUK CEK USER SUDAH BERTEMAN ATAU BELUM DI PENCARIAN DAN DATA DISIMPAN DALAM ARRAY CEKTEMAN
if (isset($rows[0]["EMAIL"])){
   $emailSrc = $rows[0]["EMAIL"];

   $statement = $koneksi -> query("SELECT * FROM FOLLOW_USERS WHERE EMAIL = '$emailUser' AND USE_EMAIL = '$emailSrc'");
   while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
      $cekteman[] = $row;
   }
   //MENAMPUNG PENGECEKAN DARI QUERY CEKTEMAN. JIKA BERNILAI 0 BERARTI GAGAL, JIKA 1 BERARTI BEHASIL
   $sukses = $statement -> rowCount() > 0;
}
?>


<!DOCTYPE html>
<html id="home">
<head>
   <meta charset="utf-8">
   <title>SocialHash</title>
   <link rel="stylesheet" href="css/style.css">
   <script src="js/dropdown.js"></script>
</head>
<body>
   <!-- NAVBAR AWAL -->
   <div class="navbarInti">
      <a href="index.php?page=home" class="homeBtn"><img src="img/home.png" alt="" class="homeIco">Beranda</a>
      <a href="#home"><img src="img/logoico.png" alt="" class="logo"></a>

      <div class="navbarKanan">
         <!-- tombol search -->
         <form class="" action="index.php?page=search" method="post" id="search">
            <input type="text" name="searchtxt" placeholder="Cari orang.." class="srcField" required>
            <button type="submit" name="cariorang" class="srcBtn"><img src="img/search.png" class="srcIco" alt=""></button>
         </form>

         <!-- menu dropdown -->
         <div class="dropdown">
            <a onclick="myFunction()"><img src="img/<?= $user[0]["FOTO"] ?>" class="dropbtn" alt=""></a>
            <div id="myDropdown" class="dropdown-content">
               <a href="index.php?page=profile">Lihat Profile</a>
               <a href="process/logout.php">Keluar</a>
            </div>
         </div>
         <a href="index.php?page=home#status" class="statusBtn">Status</a>
      </div>
   </div>

   <!-- CONTENT DINAMIS -->
   <div class="container">
      <?php
      if(isset($_GET['page'])){
         $page = $_GET['page'];

         switch ($page) {
            case 'home':
            include "pages/home.php";
            break;
            case 'profile':
            include "pages/profile.php";
            break;
            case 'edit':
            include "pages/edit.php";
            break;
            case 'search':
            include "pages/search.php";
            break;
            case 'people':
            include "pages/people.php";
            break;
            case 'friends':
            include "pages/friends.php";
            break;
            default:
            echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
            break;
         }
      }else{
         include "pages/home.php";
      }

      ?>
   </div>
</body>
</html>
