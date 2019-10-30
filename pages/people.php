<?php

require '../func/function.php'; //MEMANGGIL FILE FUNCTION.PHP DARI FOLDER FUNC

//PENGECEKAN LOGIN
if ( !isset($_SESSION["login"]) ) {
   header("Location: ../process/login.php"); //posisi halaman aktif mengikuti index
}

$emailPeople = $_GET["email"]; //MENGAMBIL DATA EMAIL YANG DIKIRIMKAN MELALUI URL (GET)
$emailUser = $_SESSION["user"]; //MENGAMBIL DATA SESSION DARI USER YANG SEDANG LOGIN

//MENGAMBIL DATA USER LOGIN UNTUK NAVBAR
$statement = $koneksi -> prepare("SELECT * FROM USER WHERE EMAIL = :EMAIL");
$statement -> bindvalue(':EMAIL', $emailUser);
$statement -> execute();

//EKSESKUSI QUERY DISIMPAN KEDALAM ARRAY ASOSIASI DAN DITAMPUNG DALAM VARIABLE USER
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $user[] = $row;
}

//MENGAMBIL DATA TEMAN
$statement = $koneksi -> prepare("SELECT * FROM USER WHERE EMAIL = :EMAIL");
$statement -> bindvalue(':EMAIL', $emailPeople);
$statement -> execute();

//EKSESKUSI QUERY DISIMPAN KEDALAM ARRAY ASOSIASI DAN DITAMPUNG DALAM VARIABLE PROFILEPEOPLE
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $profilePeople[] = $row;
}

//UNTUK MENGHITUNG JUMLAH FOLLOWING DARI TEMAN
$statement = $koneksi -> prepare("SELECT COUNT(USE_EMAIL) FROM FOLLOW_USERS WHERE EMAIL = :EMAIL");
$statement -> bindvalue(':EMAIL', $emailPeople);
$statement -> execute();

//EKSESKUSI QUERY DISIMPAN KEDALAM ARRAY ASOSIASI DAN DITAMPUNG DALAM VARIABLE COUNTFING
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $countFing[] = $row;
}

//UNTUK MENGHITUNG JUMLAH FOLLOWERS DARI TEMAN
$statement = $koneksi -> prepare("SELECT COUNT(EMAIL) FROM FOLLOW_USERS WHERE USE_EMAIL = :EMAIL");
$statement -> bindvalue(':EMAIL', $emailPeople);
$statement -> execute();

//EKSESKUSI QUERY DISIMPAN KEDALAM ARRAY ASOSIASI DAN DITAMPUNG DALAM VARIABLE COUNTFWER
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $countFwer[] = $row;
}

//UNTUK MENAMPUNG STATUS ORANG
$statement = $koneksi -> prepare("SELECT * FROM USER LEFT JOIN POSTING ON USER.EMAIL = POSTING.EMAIL WHERE USER.EMAIL = :EMAIL ORDER BY TGL_POSTING DESC");
$statement -> bindvalue(':EMAIL', $emailPeople);
$statement -> execute();

//EKSESKUSI QUERY DISIMPAN KEDALAM ARRAY ASOSIASI DAN DITAMPUNG DALAM VARIABLE STATUSPEOPLE
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $statusPeople[] = $row;
}

?>


<!DOCTYPE html>
<html id="home">
<head>
   <meta charset="utf-8">
   <title>SocialHash</title>
   <link rel="stylesheet" href="../css/style.css">
   <script src="../js/dropdown.js"></script>
</head>
<body>
   <!-- NAVBAR -->
   <div class="navbarInti">
      <a href="../index.php?page=home" class="homeBtn"><img src="../img/home2.png" alt="" class="homeIco">Beranda</a>
      <a href="#home"><img src="../img/logoico.png" alt="" class="logo"></a>

      <div class="navbarKanan">
         <!-- tombol search -->
         <form class="" action="../index.php?page=search" method="post" id="search">
            <input type="text" name="searchtxt" placeholder="Cari orang.." class="srcField" required>
            <button type="submit" name="cariorang" class="srcBtn"><img src="../img/search.png" class="srcIco" alt=""></button>
         </form>

         <!-- menu dropdown -->
         <div class="dropdown">
            <a onclick="myFunction()"><img src="../img/<?= $user[0]["FOTO"] ?>" class="dropbtn" alt=""></a>
            <div id="myDropdown" class="dropdown-content">
               <a href="../index.php?page=profile">Lihat Profile</a>
               <a href="../process/logout.php">Keluar</a>
            </div>
         </div>
         <a href="../index.php?page=home#status" name="status" class="statusBtn">Status</a>
      </div>
   </div>


   <div class="container">
      <div class="profilePage">
         <div class="profileContent">
            <h2>Tinjauan Profil</h2>
            <hr>
            <div class="profile">

               <div class="foto">
                  <img src="../img/<?= $profilePeople[0]["FOTO"] ?>" alt="">
               </div>

               <div class="deskripsi">
                  <!-- MEMANGGIL DATA TEMAN -->
                  <p><span>Nama</span> <?= $profilePeople[0]["NAMA"] ?> </p>
                  <p><span>Email</span> <?= $profilePeople[0]["EMAIL"] ?> </p>
                  <p><span>Tgl. lahir</span> <?= $profilePeople[0]["TGL_LAHIR"] ?> </p>
                  <p><span>Jenis kelamin</span> <?= $profilePeople[0]["JK"] ?> </p>
                  <p><span>Follower </span> <?= $countFwer[0]["COUNT(EMAIL)"] ?></p>
                  <p><span>Following </span> <?= $countFing[0]["COUNT(USE_EMAIL)"] ?></p>
               </div>
            </div>
            <hr>
         </div>

         <h2>Status</h2>

         <div class="profileStatus">

            <!-- MEMANGGIL DATA POSTINGAN TEMAN -->
            <?php  if ($statusPeople[0]["POSTING"] !== NULL) { ?>
               <?php foreach ($statusPeople as $key): ?>
                  <img src="../img/<?= $key['FOTO'] ?>" alt="">
                  <h3><?= $key['NAMA'] ?></h3>
                  <span><?= $key['TGL_POSTING'] ?></span>
                  <p><?= $key['POSTING'] ?></p>
               <?php endforeach; ?>
            <?php } else { ?>
               <?php echo "<h1> Belum ada postingan </h1>"; ?>
            <?php } ?>

         </div>
         <hr>
      </div>
   </div>
</body>
</html>
