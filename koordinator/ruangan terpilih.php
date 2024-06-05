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
	<?php
	if (isset($_POST['simpan'])) {
		$id_koordinator = $_POST['id_koordinator'];
		$id_ruangan     = $_POST['id_ruangan'];
		$komentar 	    = $_POST['komentar'];
		$tanggal        = $_POST['tanggal'];

		$insert = $koneksi->query("insert into komentar(id_koordinator, id_ruangan, komentar, tanggal) values('$id_koordinator','$id_ruangan','$komentar','$tanggal')") or die(mysqli_error($koneksi));
		if ($insert) {
			$pesanko = "Terimakasih Telah Memberikan Saran.";
		} else {
			$pesanko = "Ups, Gagal Menberikan Saran!";
		}
	} else {
		$pesanko = "";
	}
	?>

	<?php
	if (isset($_GET['aksi']) == 'aktif') {
		$id_ruangan = $_GET['id_ruangan'];

		$cek = $koneksi->query("select*from ruangan where id_ruangan='$id_ruangan'");
		if ($cek->num_rows == 0) {
			echo "";
		} else {
			$erow = $cek->fetch_assoc();
			$email = $erow['email'];
		}

		if ($erow['kondisi'] == 'TERISI') {
			$update = $koneksi->query("update ruangan set kondisi='KOSONG', email='' where id_ruangan='$id_ruangan'") or die(mysqli_error($koneksi));

			if ($update) {
				$pesan = 'Terimaksih, Silahkan meninggalkan ruangan.';
			} else {
				$pesan = 'Ups, Gagal mengubah kondisi ruangan silahkan coba lagi.';
			}
		}
	} else {
		$pesan = '';
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
						<td class="td2" align="left">
							<h3>Data Ruangan Digunakan</h3>
						</td>
						<hr>
						<?php echo $pesan; ?>
						<form method="post" action="">
							<table class="tabel">
								<?php
								$cek = $koneksi->query("select * from ruangan where email='$email'");
								if ($cek->num_rows == 0) {
									echo '<tr class="tr1">
            								<td class="td1" colspan="8"><center>Tidak ada data saat ini...</center></td>
	           							  </tr>';
								} else {
									echo '<font>Tinggalkan ruangan jika tidak digunakan!.</font>
											  <br>' . $pesanko . '
											  <br>
											  <br>';
									$no = 1;
									while ($erow = $cek->fetch_assoc()) {
										extract($erow)
								?>
									<?php
										echo '<tr class="tr1">
												<td width="100px"><b>Kode Ruangan</b></td>
												<td>:</td>
												<td>' . $erow['kode_ruangan'] . '</td>
											  </tr>
											  <tr class="tr1">
												<td><b>Lantai</b></td>
												<td>:</td>
												<td>' . $erow['lantai'] . '</td>
											  </tr>
											  <tr class="tr1">
												<td><b>Gedung</b></td>
												<td>:</td>
												<td>' . $erow['gedung'] . '</td>
											  </tr>
											  <tr class="tr1">
												<td><b>Fasilitas</b></td>
												<td>:</td>
												<td>' . $erow['fasilitas'] . '</td>
											  </tr>
											  <tr class="tr1">
												<td colspan="3">
													<b>
													<a href="ruangan terpilih.php?aksi=aktif&id_ruangan=' . $erow['id_ruangan'] . '" onclick="return confirm(\'Anda yakin akan meninggalkan ruangan ' . $erow['kode_ruangan'] . '?\')" class="a">Tinggalkan Ruangan</a>
													</b>
												</td>
												<input type="hidden" name="id_ruangan" value="' . $erow['id_ruangan'] . '">
												<input type="hidden" name="tanggal" value="' . date("Y-m-d") . '">
											  </tr>';
										$no++;
									}
									?>
									<tr>
										<td colspan="3">
											<?php

											?>
											<input type="hidden" name="id_koordinator" value="<?php echo $row['id_koordinator']; ?>">
											<textarea class="kotak" name="komentar" placeholder="Saran/Komentar Tentang Ruangan" required=""></textarea>
											<div align="right"><button type="submit" name="simpan" class="kotak" style="width: 110px;">Komentar</button></div>
						</form>
						</td>
						</tr>
					<?php
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