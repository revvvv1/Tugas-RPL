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

						$id_koordinator = $_GET['id_koordinator']; // assigment nim dengan nilai nim yang akan diedit
						$cek = $koneksi->query("select * from koordinator natural join fakultas natural join prodi WHERE id_koordinator='$id_koordinator'"); // query untuk memilih entri data dengan nilai nim terpilih
						if ($cek->num_rows == 0) {
							echo "";
						} else {
							$erow = $cek->fetch_assoc();
						}
						if (isset($_POST['simpan'])) { // jika tombol 'Simpan' dengan properti name="simpan" ditekan

							$nama1 = $_FILES['foto']['name'];
							$x = explode('.', $nama1);
							$ekstensi = strtolower(end($x));
							$file_tmp = $_FILES['foto']['tmp_name'];

							move_uploaded_file($file_tmp, 'foto/' . $nama1);

							$update = $koneksi->query("update koordinator set foto='$nama1' where id_koordinator='$id_koordinator'") or die(mysqli_error($koneksi)); // query untuk mengupdate nilai entri dalam database
							if ($update) { // jika query update berhasil dieksekusi

								$pesan = '<p>Data berhasil disimpan,  kembali ke <a href="profile.php" class="a"> -> Profile. </a></p>';
							} else { // jika query update gagal dieksekusi
								$pesan = '<p>Data gagal disimpan, silahkan coba lagi. Atau kembali ke <a href="profile.php" class="a"> -> Profile. </a></p>'; // maka tampilkan 'Data gagal disimpan, silahkan coba lagi.'
							}
						} else {
							$pesan = '';
						}

						?>


						<form method="post" action="" enctype="multipart/form-data">
							<h3>Edit Profile</h3>
							<hr>
							<?php echo $pesan; ?>
							<fieldset class="filset">
								<legend>Ubah foto :</legend>
								<input class="kotak" type="file" name="foto" value="<?php echo $erow['nama']; ?>" style="width: 100%;" required="">

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