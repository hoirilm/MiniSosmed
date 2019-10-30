<!-- SIDEBAR -->
<div class="sidebar">
   <img src="img/<?= $user[0]["FOTO"] ?>" alt="" class="profilePic">
   <p class="username"><?= $user[0]["NAMA"] ?></p>
   <hr>
   <div class="follow">
      <h2>Follower</h2>
      <p><?= $countFwer[0]["COUNT(EMAIL)"] ?></p>
   </div>
   <div class="follow">
      <h2>Following</h2>
      <p><?= $countFing[0]["COUNT(USE_EMAIL)"] ?></p>
   </div>
</div>


<!-- STATUS BAR -->
<div class="createStatus">
   <form action="index.php" method="post" id="posting">
      <textarea name="status" id="status" form="posting" placeholder="Hi!, ada cerita seru apa hari ini?" rows="1" cols="20"></textarea>
      <button type="submit" name="postStatus" class="postStatus">Post</button>
   </form>
</div>



<!-- CONTENT -->
<div class="content">
   <h2>Followers</h2>
   <?php if(!empty($followers)) { ?>
      <?php foreach ($followers as $key) { ?>
         <!-- MENGAMBIL DATA TAMPUNG DARI QUERY FOLLOWERS UNTUK DIKELOLA LAGI -->
         <?php
         $statement = $koneksi -> prepare ("SELECT * FROM USER WHERE EMAIL = :EMAIL");
         $statement -> bindvalue(':EMAIL', $key["EMAIL"]);
         $statement -> execute();
         ?>
         <!-- MENAMPILKAN DATA FOLLOWER DARI DATA QUERY FOLLOWERS -->
         <?php foreach ($statement as $key): ?>
            <div class='contentSrc'>
               <img src='img/<?= $key['FOTO'] ?>' alt=''>
               <a href='pages/people.php?email=<?= $key['EMAIL'] ?>' class='nama'><?= $key['NAMA'] ?></a>
            </div>
         <?php endforeach; ?>
      <?php } ?>
   <?php }else{ ?>
      <p class="notif">Tidak ada Followers</p>
   <?php } ?>

   <h2>Following</h2>
   <!-- MENGAMBIL DATA TAMPUNG DARI QUERY FOLLOWING UNTUK DIKELOLA LAGI -->
   <?php if(!empty($following)) { ?>
      <?php foreach ($following as $key) { ?>
         <?php
         $statement = $koneksi -> prepare ("SELECT * FROM USER WHERE EMAIL = :USE_EMAIL");
         $statement -> bindvalue(':USE_EMAIL', $key["USE_EMAIL"]);
         $statement -> execute();
         ?>
         <!-- MENAMPILKAN DATA FOLLOWING DARI DATA QUERY FOLLOWING -->
         <?php foreach ($statement as $key): ?>
            <div class='contentSrc'>
               <img src='img/<?= $key['FOTO'] ?>' alt=''>
               <a href='pages/people.php?email=<?= $key['EMAIL'] ?>' class='nama'><?= $key['NAMA'] ?></a>
            </div>
         <?php endforeach; ?>
      <?php } ?>
   <?php } else { ?>
      <p class="notif">Tidak mengikuti siapapun</p>
   <?php } ?>
</div>
