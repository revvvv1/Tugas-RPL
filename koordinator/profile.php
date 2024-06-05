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
						<td class="td2" align="left">
							<h3>Profile</h3>
						</td>
						<hr>
						<form method="post" action="">
							<table class="tabel">
								<?php
								$cek = $koneksi->query("select * from koordinator natural join fakultas natural join prodi where email='$email'");
								if ($cek->num_rows == 0) {
									echo '<tr class="tr1">
            								<td class="td1" colspan="8"><center>Tidak ada data saat ini...</center></td>
	           							  </tr>';
								} else {
									$no = 1;
									while ($erow = $cek->fetch_assoc()) {
										extract($erow)
								?>
								<?php
										echo '<tr class="tr1">
												<td colspan="3"></td>
												<td rowspan="8" align="center">
												 <a href="foto edit.php?id_koordinator=' . $erow['id_koordinator'] . '" class="a">
												  <img src="foto/' . $erow['foto'] . '" width="170px" height="170px">
												 </a>
												</td>
											  <tr>
											  <tr class="tr1">
												<td width="100px"><b>NIM</b></td>
												<td>:</td>
												<td>' . $erow['npm'] . '</td>
											  </tr>
											  <tr class="tr1">
												<td><b>Nama</b></td>
												<td>:</td>
												<td>' . $erow['nama'] . '</td>
											  </tr>
											  <tr class="tr1">
												<td><b>Tanggal Lahir</b></td>
												<td>:</td>
												<td>' . $erow['tempat_lahir'] . ', ' . $erow['tanggal_lahir'] . '</td>
											  </tr>
											  <tr class="tr1">
												<td><b>Jenis Kelamin</b></td>
												<td>:</td>
												<td>' . $erow['jenis_kelamin'] . '</td>
											  </tr>
											  <tr class="tr1">
												<td><b>Kelas</b></td>
												<td>:</td>
												<td>' . $erow['kelas'] . '</td>
											  </tr>
											  <tr class="tr1">
												<td><b>Jurusan</b></td>
												<td>:</td>
												<td>' . $erow['fakultas'] . ' - ' . $erow['prodi'] . '</td>
											  </tr>
											  <tr class="tr1">
											  	<td colspan="3">
											  		<b>
													<a href="profile edit.php?id_koordinator=' . $erow['id_koordinator'] . '" class="a">Edit Profil</a> | 
													<a href="password ganti.php?id_koordinator=' . $erow['id_koordinator'] . '" class="a">Ganti Password</a>
													</b>
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