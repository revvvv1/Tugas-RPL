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

		<?php
		if (isset($_GET['aksi']) == 'aktif') {
			$id_ruangan = $_GET['id_ruangan'];

			$cek = $koneksi->query("select*from ruangan where id_ruangan='$id_ruangan'");
			if ($cek->num_rows == 0) {
				echo "";
			} else {
				$erow = $cek->fetch_assoc();
			}

			if ($erow['kondisi'] == 'KOSONG') {
				$cek = $koneksi->query("select*from ruangan where email='$email'");

				if ($cek->num_rows == 0) {
					$update = $koneksi->query("update ruangan set kondisi='TERISI', email='$email' where id_ruangan='$id_ruangan'") or die(mysqli_error($koneksi));
					if ($update) {
						$pesan = '<p><b>DONE!</b>, Ruangan berhasil di pilih.</p>';
					} else {
						$pesan = ' <p><b>Ups!</b>, Ruangan tidak bisa di pilih.</p>';
					}
				} else {
					$pesan = 'Anda sudah memilih ruangan, Lihat Ruangan <a href="ruangan terpilih.php" class="a">Terpilih.</a>';
				}
			} else if ($erow['kondisi'] == 'TERISI') {
				$update = $koneksi->query("update ruangan set kondisi='KOSONG', email='' where id_ruangan='$id_ruangan'") or die(mysqli_error($koneksi));

				if ($update) {
					$pesan = 'Berhasil mengubah kondisi ruangan. Kembali ke <a href="ruangan data.php" class="a">Data Ruangan.</a> atau <a href="ruangan terpilih.php" class="a">Ruangan Terpilih0.</a>';
				} else {
					$pesan = 'Ups, Gagal mengubah kondisi ruangan silahkan coba lagi.';
				}
			}
		} else {
			$pesan = '';
		}
		?>
		<?php
		//menghitung data yang akan di tampilkan pada tabel
		$perhalaman = 5;
		$data = mysqli_query($koneksi, "select * from ruangan");
		$jum = mysqli_num_rows($data);
		$halaman = ceil($jum / $perhalaman);
		$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
		$start = ($page - 1) * $perhalaman;
		?>

		<div class="halaman1">
			<div class="isi-halaman">
				<div class="isi">
					<div class="artikel">
						<td class="td2" align="left">
							<h3>Data Ruangan Kosong</h3>
						</td>
						<hr>
						<font>Klik kondisi untuk memilih ruangan yang akan digunakan.</font><br>
						<?php echo $pesan; ?>
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
								<th class="th1">Lantai</th>
								<th class="th1">Gedung</th>
								<th class="th1">Fasilitas</th>
								<th class="th1">Kondisi</th>
							</tr>

							<?php
							if (isset($_GET['cari'])) {
								$cari = $_GET['cari'];
								$cek = $koneksi->query("select * from ruangan where 
        															 kode_ruangan like '%" . $cari . "%' and kondisi='KOSONG'
        														  or lantai like '%" . $cari . "' and kondisi='KOSONG'
        														  or gedung like '%" . $cari . "%' and kondisi='KOSONG'
        														  or fasilitas like '%" . $cari . "%' 
        														  and kondisi='KOSONG' ORDER BY kode_ruangan")
									or die($koneksi->error . __LINE__);;
								if ($cek->num_rows == 0) {
									echo '';
								} else {
									$cek = $koneksi->query("select * from ruangan where
            														 kode_ruangan like '%" . $cari . "%' and kondisi='KOSONG'
            													  or lantai like '%" . $cari . "' and kondisi='KOSONG'
            													  or gedung like '%" . $cari . "%' and kondisi='KOSONG'
            													  or fasilitas like '%" . $cari . "%'
            													  and kondisi='KOSONG' ORDER BY kode_ruangan");
								}
							} else {
								$cek = $koneksi->query("select * from ruangan where kondisi='KOSONG' LIMIT $start,$perhalaman");
							}
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
													<td class="td1">' . $no . '</td>
													<td class="td1">' . $erow['kode_ruangan'] . '</td>
													<td class="td1">' . $erow['lantai'] . '</td>
													<td class="td1">' . $erow['gedung'] . '</td>
													<td class="td1">' . $erow['fasilitas'] . '</td>
													<td class="td1" align="right" width="120px">
													 <button class="kotak" style="width: 110px;">
													  <a href="ruangan data.php?aksi=aktif&id_ruangan=' . $erow['id_ruangan'] . '" onclick="return confirm(\'Anda yakin akan menggunakan ruangan ' . $erow['kode_ruangan'] . '?\')" class="a">KOSONG</a>
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