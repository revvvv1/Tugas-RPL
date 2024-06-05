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
		<div class="halaman1">
			<div class="isi-halaman">

				<div class="isi">
					<div class="artikel">
						<!------------------------Proses Tambah Koordinator-------------------->
						<?php
						if (isset($_POST['tambah'])) {
							$kode_ruangan     = $_POST['kode_ruangan'];
							$lantai           = $_POST['lantai'];
							$gedung           = $_POST['gedung'];
							$fasilitas        = $_POST['fasilitas'];
							$kondisi          = $_POST['kondisi'];


							$cek = $koneksi->query("select*from ruangan where kode_ruangan='$kode_ruangan'");
							if ($cek->num_rows == 0) {
								$insert = $koneksi->query("insert into ruangan(
                                      kode_ruangan,
                                      lantai,
                                      gedung,
                                      fasilitas,
                                      kondisi)
                                  value(
                                      '$kode_ruangan',
                                      '$lantai',
                                      '$gedung',
                                      '$fasilitas',
                                      '$kondisi')") or die(mysqli_error($koneksi));
								if ($insert) {
									$pesan = '<p><b>DONE!</b>, Data berhasil ditambahkan.</p>';
								} else {
									$pesan = '<p><b>Upss</b>, Data gagal disimpan.</p>';
								}
							} else {
								$pesan = '<p><b>WARNING!</b>, Kode Ruangan sudah terdaftar.</p>';
							}
						} else {
							$pesan = '';
						}
						?>

						<form method="post" action="">
							<h3>Tambah Ruangan</h3>
							<hr>
							<?php echo $pesan; ?>
							<fieldset class="filset">
								<legend>Ruangan :</legend>
								<input class="kotak" type="text" name="kode_ruangan" style="width: 100%;" placeholder="Kode Ruangan" required="">
								<input class="kotak" type="text" name="lantai" style="width: 100%;" placeholder="Lantai Ruangan" required="">
								<input class="kotak" type="text" name="gedung" style="width: 100%;" placeholder="Gedung Ruangan" required="">
								<textarea class="kotak" name="fasilitas" style="width: 100%;" placeholder="Fasilitas" required=""></textarea>

								<select name="kondisi" class="kotak" style="width: 100%;" required="">
									<option value="">Pilih Kondisi</option>
									<option value="KOSONG">Kosong</option>
									<option value="TERISI">Terisi</option>
								</select>

								<button type="submit" name="tambah" class="kotak" style="width: 120px;">Tambahkan</button>
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