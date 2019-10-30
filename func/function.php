<?php
//MEMULAI SESSION
session_start();

//KOENKSI KEDATABASE MENGGUNAKAN PDO STYLE
$koneksi = new PDO ('mysql:host=localhost;dbname=social','root','');

//QUERY POSTING
$query = "SELECT * FROM USER, POSTING WHERE USER.EMAIL = POSTING.EMAIL ORDER BY TGL_POSTING DESC";


//JENIS NOTOFIKASI ERROR
$errorLogin = "";
$errorRegisterNama = "";
$errorRegisterEmail = "";
$errorRegisterEmail2 = "";
$errorRegisterPass = "";
$errorRegisterConfirmPass = "";
$errorRegisterDate = "";
$errorPost = "";
$errorEditNama = "";
$errorEditPassword = "";
$errorEditFoto = "";


//MENJALANKAN FUNGSI LOGIN SAAT TOMBOL LOGIN DITEKAN
if ( isset($_POST["login"])){
   login();
}

//MENJALANKAN FUNGSI REGISTER SAAT TOMBOL REGISTER DITEKAN
if ( isset($_POST["register"])){
   register();
}

//MENJALANKAN FUNGSI CARIORANG SAAT TOMBOL CARIORANG DITEKAN
if (isset($_POST["cariorang"])){
   cariorang();
}

//MENJALANKAN FUNGSI UPDATEPROFILE SAAT TOMBOL UPDATE1 DITEKAN
if (isset($_POST["update1"])) {
   editprofile();
}

//MENJALANKAN FUNGSI EDITPASSWORD SAAT TOMBOL UPDATE2 DITEKAN
if (isset($_POST["update2"])) {
   editpassword();
}

//MENJALANKAN FUNGSI POSTING SAAT TOMBOL POSTSTATUS DITEKAN
if ( isset($_POST["postStatus"])) {
   posting();
}

//MENJALANKAN FUNGSI TAMBAHTEMAN SAAT TOMBOL ADD DITEKAN
if ( isset($_POST["add"])) {
   tambahteman();
}





//KUMPULAN FUNCTION===============================================================================================



function tambahteman() {
   global $koneksi;

   $emailTambah = $_POST["email"];
   $emailUser = $_SESSION["user"];

   $statement = $koneksi -> prepare ("INSERT INTO FOLLOW_USERS (EMAIL, USE_EMAIL) VALUES (:EMAIL, :USE_EMAIL)");
   $statement -> bindValue(':EMAIL', $emailUser);
   $statement -> bindValue(':USE_EMAIL', $emailTambah);
   $statement -> execute();

   $sukses = $statement -> rowCount() > 0;

   if($sukses) {
      header("Location: index.php?page=home");
   }else{
      echo "gagal tambah teman"; die;
   }

}


function cariorang() {
   global $query;
   $keyword = $_POST["searchtxt"];
   $query = "SELECT * FROM USER WHERE NAMA LIKE '%$keyword%'";
}

function uploadgambar() {
   //mengambil data gampar di $_FILES
   $namaFile = $_FILES["foto"]["name"];
   $ukuranFile = $_FILES["foto"]["size"];
   $error = $_FILES["foto"]["error"];
   $tmpName = $_FILES["foto"]["tmp_name"];

   //cek apakah file yang diupload merupakan gambar atau bukan
   $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
   $ekstensiGambar = explode('.', $namaFile); // memecah string dengan delimiter tanda titik
   $ekstensiGambar = strtolower(end($ekstensiGambar));
   if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
      return false;
   }

   //cek ukuran gambar terlalu besar atau tidak
   if ($ukuranFile > 1000000) { //kurang lebih 1Mb dalam satuan byte
      return false;
   }

   //lolos pengecekan, gambar siap diupload
   //generate nama gambar baru (supaya tidak sama)
   $namaFileBaru = uniqid(); //funsi random
   $namaFileBaru .= '.';
   $namaFileBaru .= $ekstensiGambar;
   move_uploaded_file($tmpName, 'img/' . $namaFileBaru); //memindahkan gambar yang ada di tempat sementara ke folder yang yang ditentukan
   return $namaFileBaru;

}

function editprofile() {
   global $koneksi, $errorEditNama, $errorEditFoto;
   $error = false;
   $email = $_SESSION["user"];
   $statement = $koneksi -> prepare("SELECT * FROM USER WHERE EMAIL = :EMAIL");
   $statement -> bindValue(':EMAIL', $email);
   $statement -> execute();

   while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
      $rows[] = $row;
   }

   $fotoLama = $rows[0]['FOTO'];
   $namaLama = $rows[0]['NAMA'];

   //cek nama
   if ($_POST['nama'] === $namaLama ) {
      $nama = $namaLama;
   } else {
      $nama = $_POST['nama'];
   }

   if (!preg_match("/^[a-zA-Z ]*$/",$_POST["nama"])){
      $errorEditNama = "*Nama harus berisikan alphabet.";
      $error = true;
   }

   //cek foto
   if ($_FILES['foto']['error'] === 4){
      $foto = $fotoLama;
   } else {
      $foto = uploadgambar();
   }

   //query insert data
   if ($error === false && $foto !== false){
      $statement = $koneksi -> prepare ("UPDATE USER SET NAMA = :NAMA, FOTO = :FOTO WHERE EMAIL = '$email'");
      $statement -> bindValue(':NAMA', $nama);
      $statement -> bindValue(':FOTO', $foto);
      $statement -> execute();
      header("Location: index.php?page=home");
   } else {
      $errorEditFoto = "*Format foto tidak sesuai.";
   }
}

function editpassword() {
   global $koneksi, $errorEditPassword;
   $error = false;
   $cekstring = strlen($_POST["passBaru"]);
   $email = $_SESSION["user"];
   $statement = $koneksi -> prepare("SELECT * FROM USER WHERE EMAIL = :EMAIL");
   $statement -> bindValue(':EMAIL', $email);
   $statement -> execute();

   while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
      $rows[] = $row;
   }

   $passDatabase = $rows[0]["PASSWORD"]; //data password dari database
   $passLama = hash('sha256', $_POST["passLama"]); //data password dari inputan user
   $passwordBaru = $_POST["passBaru"];
   $confirmPassBaru = $_POST["confirmPassBaru"];

   if($passDatabase === $passLama) {
      if ($passwordBaru !== $confirmPassBaru) {
         $errorEditPassword = "*Password tidak sama.";
         $error = true;
      } else if ($cekstring < 6) {
         $errorEditPassword = "*Password yang dimasukkan kurang dari 6 karakter.";
         $error = true;
      }
   } else {
      $errorEditPassword = "*Password lama salah.";
      $error = true;
   }

   if ($error === false) {
      $statement = $koneksi -> prepare ("UPDATE USER SET PASSWORD =  SHA2(:PASSWORD, 0)  WHERE EMAIL = '$email'");
      $statement -> bindValue(':PASSWORD', $passwordBaru);;
      $statement -> execute();
      header("Location: index.php?page=home");
   }
}

function register() {
   global $koneksi, $errorRegisterNama, $errorRegisterNama, $errorRegisterEmail, $errorRegisterEmail2, $errorRegisterPass, $errorRegisterConfirmPass, $errorRegisterDate;
   $error = false;

   //cek nama
   if (!preg_match("/^[a-zA-Z ]*$/",$_POST["nama"])) {
      $errorRegisterNama = "*Nama harus berisikan alphabet.";
      $error = true;
   }

   //cek email
   if ( !empty($_POST["email"])){
      $valid = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
      if ( !$valid ){
         $errorRegisterEmail = "*Format email tidak valid.";
         $error = true;
      } else if ( $valid ){
         $cekEmail = $_POST["email"];
         $statement = $koneksi -> prepare("SELECT EMAIL FROM USER WHERE EMAIL = :EMAIL");
         $statement -> bindvalue(':EMAIL', $cekEmail);
         $statement -> execute();

         while ($row = $statement -> fetch(PDO::FETCH_ASSOC)){
            $email[] = $row;
         }

         if ($email[0]['EMAIL'] === $cekEmail) {
         $errorRegisterEmail2 = "*Email sudah terdaftar.";
         $error = true;
      }
   }
}


   //cek password
   $cekstring = strlen($_POST["password"]);
   if ( $_POST["password"] !== $_POST["confirm-password"]){
      $errorRegisterConfirmPass = "*Password yang dimasukkan tidak sama.";
      $error = true;
   }

   if ($cekstring < 6) {
      $errorRegisterPass = "*Password yang dimasukkan kurang dari 6 karakter.";
      $error = true;
   }


   //tanggal
   $hari = $_POST["hari"];
   $bulan = $_POST["bulan"];
   $tahun = $_POST["tahun"];
   $tanggal = $tahun . "-" . $bulan . "-" . $hari ; //nilai asli dari tgl lahir

   // if ($tanggal === "--" or $tanggal === $hari."--" or $tanggal === "-".$bulan."-" or $tanggal === "--".$tahun or $tanggal === $hari."-".$tahun){
   if ($hari === "hari" or $bulan === "bulan" or $tahun === "tahun"){
      $errorRegisterDate = "*Tanggal lahir salah.";
      $error = true;
   }

   //insert data
   if ($error === false) {
      $statement = $koneksi -> prepare("INSERT INTO USER (EMAIL, NAMA, TGL_LAHIR, JK, FOTO, PASSWORD) VALUES (:EMAIL, :NAMA, :TGL_LAHIR, :JK, :FOTO, SHA2(:PASSWORD, 0))");
      $statement -> bindValue(':EMAIL', $_POST['email']);
      $statement -> bindValue(':NAMA', $_POST['nama']);
      $statement -> bindValue(':TGL_LAHIR', $tanggal);
      $statement -> bindValue(':JK', $_POST['jk']);
      $statement -> bindValue(':FOTO', "foto.png" );
      $statement -> bindValue(':PASSWORD', $_POST['password']);
      $statement -> execute();

      $sukses = $statement -> rowCount() > 0;

      if ($sukses){
         header("Location: ../process/login.php");
      }
   }
}

function login() {
   global $errorLogin;
   global $koneksi;
   $email = $_POST['email'];
   $statement = $koneksi -> prepare("select * FROM USER WHERE EMAIL = :EMAIL and PASSWORD = SHA2(:PASSWORD, 0)");
   $statement -> bindValue(':EMAIL', $email);
   $statement -> bindValue(':PASSWORD', $_POST['password']);
   $statement -> execute();

   $sukses = $statement -> rowCount() > 0;
   // var_dump($success); die;

   if ($sukses){
      $_SESSION["login"] = true;
      $_SESSION["user"] = $_POST["email"];
      header("Location: ../index.php");
   }else{
      $errorLogin = "*Email atau password salah.";
   }
}

function posting() {
   global $koneksi, $errorPost;
   $error = false;
   if ($_POST["status"] === "" or strlen($_POST["status"]) > 0 && strlen(trim($_POST["status"])) === 0) {
      $errorPost = "*Status tidak boleh kosong.";
      $error = true;
   }

   if ($error === false) {
      $email = $_SESSION["user"];
      date_default_timezone_set("Asia/Jakarta");
      $tanggal = date("Y-m-d H:i:s");
      $statement = $koneksi -> prepare("INSERT INTO POSTING (ID_POSTING, EMAIL, POSTING, TGL_POSTING) VALUES (:ID_POSTING, :EMAIL, :POSTING, :TGL_POSTING)");
      $statement -> bindValue(':ID_POSTING', "");
      $statement -> bindValue(':EMAIL', $email);
      $statement -> bindValue(':POSTING', $_POST["status"]);
      $statement -> bindValue(':TGL_POSTING', $tanggal);
      $statement -> execute();

      $sukses = $statement -> rowCount() > 0;
      // var_dump($sukses); die;

      if ($sukses){
         header("Location: index.php?page=home");
      }else{
         $errorPost = "*Postingan gagal dibuat";
      }
   }
}

?>
