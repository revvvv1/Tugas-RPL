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
	$email = $_SESSION['email']; // mengambil username dari session yang login

	$cek = $koneksi->query("select*from akun natural join koordinator where email='$email'"); // query memilih entri username pada database
	if ($cek->num_rows == 0) {
		header("Location:../index.php");
	} else {
		$row = $cek->fetch_assoc();
		$email = $row['email'];
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
						$id_koordinator = $_GET['id_koordinator'];
						$cek = $koneksi->query("select*from koordinator natural join akun where id_koordinator='$id_koordinator'");
						if ($cek->num_rows == 0) {
							header("Location: index.php");
						} else {
							$row = $cek->fetch_assoc();
						}

						if (isset($_POST['simpan'])) {
							$passwordLama   = md5($_POST['passwordLama']);
							$passwordBaru   = $_POST['passwordBaru'];
							$passwordUlang  = $_POST['passwordUlang'];

							$cek = $koneksi->query("select*from koordinator natural join akun where password='$passwordLama'");
							if ($cek->num_rows == 1) {
								if ($passwordBaru == $passwordUlang) {
									$pass = md5($passwordBaru);
									$update = $koneksi->query("update koordinator set password='$pass' where id_koordinator='$id_koordinator'") or die(mysqli_error($koneksi));
									$koneksi->query("update akun set password='$pass' where email='$email'") or die(mysqli_error($koneksi));
									if ($update) {
										$pesan = '<p>Password berhasil di ubah,  kembali ke <a href="profile.php" class="a"> -> Profile. </a></p>';
									} else {
										$pesan = '<p>Password gagal di ubah, silahkan coba lagi. Atau kembali ke <a href="profile.php" class="a"> -> Profile. </a></p>';
									}
								} else {
									$pesan = '<p>Password tidak sama!, Pastikan Passsword Baru dengan Password Ulang sama.</p>';
								}
							} else {
								$pesan = '<p>Password gagal dirubah.</p>';
							}
						} else {
							$pesan = '';
						}

						?>


						<form method="post" action="">
							<h3>Ganti Password</h3>
							<hr>
							<?php echo $pesan; ?>
							<fieldset class="filset">
								<legend>Password :</legend>
								<input class="kotak" type="password" name="passwordLama" style="width: 100%;" placeholder="Password Lama" required="">
								<input class="kotak" type="password" name="passwordBaru" style="width: 100%;" placeholder="Password Baru" required="">
								<input class="kotak" type="password" name="passwordUlang" style="width: 100%;" placeholder="Ulangi Password Baru" required="">

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