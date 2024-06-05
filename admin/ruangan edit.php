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
	$email = $_SESSION['email'];

	$cek = $koneksi->query("select*from user where email='$email'");
	if ($cek->num_rows == 0) {
		header("Location:../index admin.php");
	} else {
		$row = $cek->fetch_assoc();
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
						<li><a href="#">Tentang</a></li>
						<li><a href="#">Kontak</a></li>
						<li><a href="#">Bantuan</a></li>
						<li><a href="#"><?php echo (strtoupper($row['nama'])); ?></a></li>
					</ul>
				</div>
				<div class="hapus"></div>
			</div>
		</header>
		<div class="judul">
			<div class="isi-judul"></div>
		</div>
		<!------------------------Proses EditKoordinator-------------------->
		<?php

		$id_ruangan = $_GET['id_ruangan'];
		$cek = $koneksi->query("select * from ruangan WHERE id_ruangan='$id_ruangan'");
		if ($cek->num_rows == 0) {
			echo "";
		} else {
			$erow = $cek->fetch_assoc();
		}
		if (isset($_POST['simpan'])) {
			$kode_ruangan   = $_POST['kode_ruangan'];
			$lantai  		= $_POST['lantai'];
			$gedung   		= $_POST['gedung'];
			$fasilitas  	= $_POST['fasilitas'];
			$kondisi    	= $_POST['kondisi'];

			$update = $koneksi->query("update ruangan set 
                                  kode_ruangan='$kode_ruangan',
                                  lantai='$lantai',
                                  gedung='$gedung',
                                  fasilitas='$fasilitas',
                                  kondisi='$kondisi'
                                  WHERE id_ruangan='$id_ruangan'") or die(mysqli_error($koneksi));
			if ($update) {

				$pesan = '<p>Data berhasil disimpan,  kembali ke <a href="ruangan data.php" class="a">Data Ruangan. </a></p>';
			} else {
				$pesan = '<p>Data gagal disimpan, silahkan coba lagi. Atau kembali ke <a href="ruangan data.php" class="a">Data Ruangan. </a></p>';
			}
		} else {
			$pesan = '';
		}

		?>
		<div class="halaman1">
			<div class="isi-halaman">

				<div class="isi">
					<div class="artikel">

						<form method="post" action="">
							<h3>Edit Ruangan</h3>
							<hr>
							<?php echo $pesan; ?>
							<fieldset class="filset">
								<legend>Ruangan :</legend>
								<input class="kotak" type="text" name="kode_ruangan" value="<?php echo $erow['kode_ruangan']; ?>" style="width: 100%;" placeholder="Kode Ruangan" required="">
								<input class="kotak" type="text" name="lantai" value="<?php echo $erow['lantai']; ?>" style="width: 100%;" placeholder="Lantai Ruangan" required="">
								<input class="kotak" type="text" name="gedung" value="<?php echo $erow['gedung']; ?>" style="width: 100%;" placeholder="Gedung Ruangan" required="">
								<textarea class="kotak" name="fasilitas" placeholder="Fasilitas"><?php echo $erow['fasilitas']; ?></textarea>
								<select name="kondisi" class="kotak" style="width: 100%;" required="">
									<option value="<?php echo $erow['kondisi']; ?>"><?php echo $erow['kondisi']; ?></option>
									<option value="KOSONG">Kosong</option>
									<option value="TERISI">Terisi</option>
								</select>

								<button type="submit" name="simpan" class="kotak" style="width: 100px;">Simpan</button>
								<button type="reset" class="kotak" style="width: 100px;">Batal</button>
							</fieldset>
						</form>
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
							if ($cek->num_rows == 0) {
								echo '<li><a href="#">Konfirmasi</a></li>';
							} else {
								echo '<li><a href="akun.php"><font color="red">Konfirmasi</font></a></li>';
							}
							?>
							<li><a href="komentar.php">Komentar</a></li>
							<li><a href="laporan2.php">Laporan</a></li>
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