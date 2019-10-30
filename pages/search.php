<!-- SIDEBAR AWAL -->
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
   <!-- PENGECEKAN DATA KOSONG ATAU TIDAK -->
   <?php if (empty($rows)) { ?>
      <div class="contentSrc">
         <p class="notif">Maaf, kami tidak dapat menemukan <span><?= $_POST["searchtxt"] ?></span></p>
      </div>
   <?php } else { ?>
      <!-- JIKA DATA TERISI MAKA DITAMPILKAN DATA ORANG YANG DICARI -->
      <?php foreach ($rows as $key): ?>
         <div class="contentSrc">

            <?php if ($sukses) { ?>
               <img src="img/<?= $key['FOTO'] ?>" alt="">
               <a href="pages/people.php?email=<?= $key['EMAIL'] ?>" class="nama"><?= $key['NAMA'] ?></a>
            <?php } else if ($key['NAMA'] !== $user[0]['NAMA']) {?>
               <img src="img/<?= $key['FOTO'] ?>" alt="">
               <p><?= $key['NAMA'] ?></p>
               <form action="index.php" method="post">
                  <input type="hidden" name="email" value="<?= $key['EMAIL'] ?>">
                  <button type="submit" name="add" class="add">Follow</button>
               </form>
            <?php } else { ?>
               <img src="img/<?= $key['FOTO'] ?>" alt="">
               <a href="index.php?page=profile" class="nama"><?= $key['NAMA'] ?></a>
            <?php } ?>
         </div>
      <?php endforeach; ?>

   <?php } ?>
</div>
