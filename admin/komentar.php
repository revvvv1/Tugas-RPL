<?php 
  include('../include/koneksi.php');
  include("include/akses admin.php"); 
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
        	$email = $_SESSION['email']; // mengambil username dari session yang login
      
        	$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email'"); // query memilih entri username pada database
        	if(mysqli_num_rows($sql) == 0){
          		header("Location:../index admin.php");
        	}else{
         	 $row = mysqli_fetch_assoc($sql);
        	}

        	$nama = $row['nama'];
      	?>

		<div class="halaman">
			<header class="header">
				<div class="isi-header">	
					<div class="logo">
						<img src="laporan/logo2.png" alt="Logo" style="height:50px;">
					</div>
					<div class="menu-atas">
						<ul>
						<li><a href="#"><?php echo (strtoupper($row['nama'])); ?></a></li>
						</ul>
					</div>
					<div class="hapus"></div>
				</div>
			</header>
			<div class="judul">
				<div class="isi-judul"></div>
			</div>
	<?php
      if(isset($_GET['aksi']) == 'delete'){ 
        $id_komentar = $_GET['id_komentar']; 
        $cek=$koneksi->query("select*from komentar where id_komentar='$id_komentar'"); 
        if($cek->num_rows == 0){ 
          $errormsgh = ''; 
        }else{
        	      $delete = $koneksi->query("delete from komentar where id_komentar='$id_komentar'");
          if($delete){
            $errormsgh = '<div class="w3-panel w3-pale-green w3-leftbar w3-border-green">
                            <p><b>DONE!</b>, Data berhasil dihapus.</p>
                          </div>';
          }else{ 
            $errormsgh = '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red">
                            <p><b>DONT DELETE!</b>, Data gagal dihapus.</p>
                          </div>';
          }
        }
      }else{
        $errormsgh = '';
      }
  	?>
	<?php
      //menghitung data yang akan di tampilkan pada tabel
      $perhalaman=5;
      $data=mysqli_query($koneksi, "select * from komentar");
      $jum=mysqli_num_rows($data);
      $halaman=ceil($jum/$perhalaman);
      $page=(isset($_GET['page']))?(int)$_GET['page']:1;
      $start=($page - 1) * $perhalaman;
  	?>
	
			<div class="halaman1">
				<div class="isi-halaman">
					<div class="isi">
						<div class="artikel">
							<td class="td2" align="left"><h3>Data Komentar</h3></td>
							<hr>
							<?php echo $errormsgh; ?>
							<table class="tabel">
								<tr>
									<td class="td2" align="right">
										<form method="get" action="">
											<input type="text" class="kotak" name="cari" style="width: 200px;" placeholder="Cari data disini...">
											<button type="submit" class="kotak" style="width: 67px;">Cari</button>
										</form>
									</td>
							</table>
							<table class="tabel">
								<tr class="tr1">
									<th class="th1">No</th>
									<th class="th1">Kode</th>
									<th class="th1">Komentar</th>
									<th class="th1">Opsi</th>
								</tr>
	
								<?php
								if(isset($_GET['cari'])){
        								$cari=$_GET['cari'];
        								$sql=$koneksi->query("select * from komentar where kode_ruangan like '%".$cari."%' ORDER BY kode_ruangan") or die($koneksi->error.__LINE__);;
          							if($sql->num_rows == 0){
            							echo '';
          							}else{
            							$sql=$koneksi->query("select * from komentar where kode_ruangan like '%".$cari."%' ORDER BY kode_ruangan");
          							}
  								}else{    
      								$sql=$koneksi->query("select * from komentar natural join ruangan LIMIT $start,$perhalaman");
      							} 
      							if($sql->num_rows == 0){
        							echo '<tr class="tr1">
            								<td class="td1" colspan="8"><center>Tidak ada data saat ini...</center></td>
	           							  </tr>';
								}else{
									$no=1;
									while($erow = $sql->fetch_assoc()) {
											extract($erow)
          									?>
          									<?php
											echo '<tr class="tr1">
													<td class="td1">'.$no.'</td>
													<td class="td1">'.$erow['kode_ruangan'].'</td>
													<td class="td1">'.$erow['komentar'].'</td>
													<td class="td1">
													<button class="kotak">
														<a href="komentar.php?aksi=delete&id_komentar='.$erow['id_komentar'].'" onclick="return confirm(\'Anda yakin akan menghapus komentar data '.$erow['id_ruangan'].'?\')" class="a">Hapus</a>
													</button>
													</td>
												  </tr>';
										$no++;
										}
									}
								?>
								
							</table>
						</div>
					</div>
					
					<nav class="menu">
						<div class="menu1">
							<h3><?php echo (strtoupper($row['nama'])); ?></h3>
							<hr>
							<ul>
							<li><a href="ruangan data.php">Ruangan</a></li>
							<li><a href="koordinator data.php">Koordinator</a></li>
							<?php
							$cek = $koneksi->query("select*from koordinator where status='non-aktif'");
							if($cek->num_rows == 0){
								echo '<li><a href="#">Konfirmasi</a></li>';
							}else{
								echo '<li><a href="akun.php"><font color="red">Konfirmasi</font></a></li>';
							}
							?>
							<li><a href="komentar.php">Komentar</a></li>
							<li><a href="laporan2.php" target="_blank">Laporan</a></li>
							<li><a href="../logout.php">Logout</a></li>
							</ul>
						</div>
					</nav>
					
					<div class="hapus"></div>
				</div>
			</div>
		
			<div class="footer1">
				<div class="isi-footer1">
					<?php include("include/footer.php"); ?>
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