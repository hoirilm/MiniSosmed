<?php
$email = $_SESSION['user'];

//QUERY MEMANGGIL STATUS DARI USER YANG LOGIN
$statement = $koneksi -> query("SELECT * FROM USER LEFT JOIN POSTING ON USER.EMAIL = POSTING.EMAIL WHERE USER.EMAIL = '$email' ORDER BY ID_POSTING DESC");
while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
   $status[] = $row;
}

?>

<div class="profilePage">
   <div class="profileContent">
      <h2>Tinjauan Profil</h2>
      <hr>

      <div class="profile">

         <div class="foto">
            <img src="img/<?= $user[0]["FOTO"] ?>" alt="">
         </div>

         <div class="deskripsi">
            <!-- MEMANGGIL DATA DARI USER YANG LOGIN -->
            <p><span>Nama</span> <?= $user[0]["NAMA"] ?> </p>
            <p><span>Email</span> <?= $user[0]["EMAIL"] ?> </p>
            <p><span>Tgl. lahir</span> <?= $user[0]["TGL_LAHIR"] ?> </p>
            <p><span>Jenis kelamin</span> <?= $user[0]["JK"] ?> </p>
            <p><span>Follower </span> <?= $countFwer[0]["COUNT(EMAIL)"] ?></p>
            <p><span>Following </span> <?= $countFing[0]["COUNT(USE_EMAIL)"] ?></p>
         </div>

      </div>
      <hr>

      <a href="index.php?page=friends" class="friendsBtn">Followers & Following</a>
      <a href="index.php?page=edit" class="editBtn">Edit Profile</a>
   </div>

   <h2>Status</h2>

   <div class="profileStatus">
      <?php
      $statement = $koneksi -> query("SELECT POSTING FROM POSTING WHERE EMAIL = '$email'");
      $cekstatus = $statement -> rowCount() > 0;
      ?>

      <!-- MENGECEK DAN MENAMPILKAN POSTINGAN USER -->
      <?php  if ($cekstatus) { ?>
         <?php foreach ($status as $key): ?>
            <img src="img/<?= $key['FOTO'] ?>" alt="">
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
