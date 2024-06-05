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

	$cek = $koneksi->query("select*from akun natural join koordinator where email='$email'");
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
						<p>Selamat Datang <?php echo $row['nama']; ?>.....</p>
					</div>
					<div style="text-align:center;">
						<img src="FT.jpg" alt="Gambar Ruangan" style="width:80%;max-width:600px;margin-top:20px;">
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