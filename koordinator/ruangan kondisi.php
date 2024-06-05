<?php 
  include('../include/koneksi.php');
  include("include/akses koordinator.php"); 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Informasi Kelas</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
	</head>
	<body>
		
		<?php
        	$email = $_SESSION['email']; 
      
        	$cek = $koneksi->query("select * from akun natural join koordinator where email='$email'"); 
        	if($cek->num_rows == 0){
          		header("Location:../index.php");
        	}else{
         	 $row = $cek->fetch_assoc();
        	}
      	?>

		<div class="halaman">
			<header class="header">
				<div class="isi-header">	
					<div class="logo">
						<img src="foto/logo2.png" alt="Logo" style="height:50px;">
					</div>
					<div class="menu-atas">
						<ul>
						<li><a href="profile.php"><?php echo (strtoupper($row['nama'])); ?></a></li>
						</ul>
					</div>
					<div class="hapus"></div>
				</div>
			</header>
			<div class="judul">
				<div class="isi-judul"></div>
			</div>
			<div class="halaman1">
				<div class="isi-halaman">
				
					<div class="isi">
						<div class="artikel">
	<!------------------------Proses EditKoordinator-------------------->
	<?php

      $id_ruangan = $_GET['id_ruangan']; 
      $cek = $koneksi->query("select * from ruangan where id_ruangan='$id_ruangan'"); 
      if($cek->num_rows == 0){
        echo "";
      }else{
        $erow = $cek->fetch_assoc();
      }
      if(isset($_POST['simpan'])){
        	$kondisi    	= $_POST['kondisi'];
        	$email			= $_POST['email'];
        
     

     if($erow['kondisi']=='KOSONG'){
     	$cek=$koneksi->query("select * from ruangan where email='$email'");

     	if($cek->num_rows == 0){
     		$update = $koneksi->query("update ruangan set kondisi='$kondisi', email='$email' where id_ruangan='$id_ruangan'") or die(mysqli_error());
        	if($update){ 
           		$pesan = 'Berhasil mengubah kondisi ruangan. Kembali ke <a href="ruangan data.php" class="a">Data Ruangan.</a> atau <a href="ruangan terpilih.php" class="a">Ruangan Terpilih1.</a>';
       		}else{ 
           		$pesan = 'Ups, Gagal mengubah kondisi ruangan silahkan coba lagi.';
        	}
        }else{
        	$pesan = 'Anda sudah memilih ruangan, Lihat Ruangan <a href="ruangan terpilih.php" class="a">Terpilih.</a>';
        }

      }else{
         $pesan='';
      }

    ?>


							<form method="post" action="">
            					<h3>Edit Ruangan</h3>
            					  <hr>
                    				<?php echo $pesan; ?>
                    				<br>
            					<font>Ruangan</font>
            					<br>
            					<input type="radio" name="kondisi" value="KOSONG" <?php if($erow['kondisi']=='KOSONG'){echo "checked";} ?>>KOSONG
            					<br>
 								<input type="radio" name="kondisi" value="TERISI" <?php if($erow['kondisi']=='TERISI'){echo "checked";} ?>>TERISI
 								<br>
            					<input type="hidden" name="email" value="<?php echo $row['email']; ?>">
            					
            					<button type="submit" name="simpan" class="kotak" style="width: 200px;">Simpan</button>
        					</form>
						</div>
					</div>
					
					<nav class="menu">
						<div class="menu1">
							<h3><?php echo (strtoupper($row['nama'])); ?></h3>
							<hr>
							<ul>
							<li><a href="ruangan data.php">Ruangan</a></li>
							<li><a href="ruangan terpilih.php">Ruangan Terpilih</a></li>
							<li><a href="komentar.php">Komentar</a></li>
							<li><a href="../logout.php">Logout</a></li>
							</ul>
						</div>
					</nav>
					
					<div class="hapus"></div>
				</div>
			</div>
		
			<div class="footer1">
				<div class="isi-footer1">
					<?php include("include/footer.php") ?>
					<div class="hapus"></div>
				</div>
			</div>
			<footer class="footer">
				<div class="isi-footer">
					<p>&copy; Sistem <a href="#">Informasi Ruangan</a> &#124; <a href="#">KEL 6</a> &#124; <a href="#">Teknik Informatika UHO 2022</a></p>
					<div class="hapus"></div>
				</div>
			</footer>
		</div>
	</body>
</html>
