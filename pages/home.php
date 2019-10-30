<!-- SIDEBAR AWAL -->
<div class="sidebar">
   <!-- MEMANGGIL LALU MENAMPILKAN DATA USER DARI NILAI TAMPUNG ARRAY USER DI INDEX -->
   <img src="img/<?= $user[0]["FOTO"] ?>" alt="" class="profilePic">
   <p class="username"><?= $user[0]["NAMA"] ?></p>
   <hr>
   <div class="follow">
      <h2>Follower</h2>
      <!-- MENGHITUNG JUMLAH FOLLOWERS -->
      <p><?= $countFwer[0]["COUNT(EMAIL)"] ?></p>
   </div>
   <div class="follow">
      <h2>Following</h2>
      <!-- MENGHITUNG JUMLAH FOLLOWING -->
      <p><?= $countFing[0]["COUNT(USE_EMAIL)"] ?></p>
   </div>
</div>


<!-- STATUS -->
<div class="createStatus">
   <form action="index.php?page=home" method="post" id="posting">
      <textarea name="status" id="status" form="posting" placeholder="Hi!, ada cerita seru apa hari ini?" rows="1" cols="20"></textarea>
      <button type="submit" name="postStatus" class="postStatus">Post</button>
   </form>
   <!-- PENGECEKAN POSTINGAN ERROR POSTING -->
   <?php if ($errorPost !== ""){ ?>
      <p class="errormsg"><?= $errorPost ?></p>
   <?php } ?>
</div>


<!-- CONTENT -->
<div class="content">
   <!-- MENAMPILKAN POSTINGAN SELURUH USER -->
   <?php foreach ($rows as $key): ?>
      <div class="statusContent">
         <img src="img/<?= $key['FOTO'] ?>" alt="">
         <h3><?= $key['NAMA'] ?></h3>
         <span>Diposting pada <?= $key['TGL_POSTING'] ?></span>
         <p><?= $key['POSTING'] ?></p>
      </div>
   <?php endforeach; ?>
</div>
