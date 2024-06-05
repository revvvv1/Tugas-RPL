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
		$email 		 = $row['email'];
		$id_koordinator = $row['id_koordinator'];
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
		if (isset($_GET['aksi']) == 'delete') {
			$id_komentar = $_GET['id_komentar'];

			$delete = $koneksi->query("delete from komentar where id_komentar='$id_komentar'");
			if ($delete) {
				$pesan = 'Komentar berhasil dihapus.';
			} else {
				$pesan = 'Ups, Gagal menghapus komentar.';
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
							<h3>Data Ruangan Anda Komentar</h3>
						</td>
						<hr>

						<?php echo $pesan; ?>

						<table class="tabel">

							<?php
							$cek = $koneksi->query("select * from komentar natural join ruangan where id_koordinator='$id_koordinator' LIMIT $start,$perhalaman");

							if ($cek->num_rows == 0) {
								echo '<tr class="tr1">
            								<td class="td1" colspan="8"><center>Tidak ada data saat ini...</center></td>
	           							  </tr>';
							} else {
								echo '<br><br>';
								$no = 1;
								while ($erow = $cek->fetch_assoc()) {
									extract($erow)
							?>
							<?php
									echo
									'<tr class="tr1">
											   <td>' . $no . ". " . $erow['kode_ruangan'] . '</td>
											   <td align="right"><font size="1">Date : ' . $erow['tanggal'] . '</font></td>
											 </tr>
											 <tr class="tr1">
											   <td>' . $erow['komentar'] . '</td>
											   <td align="right">
													<a href="komentar.php?aksi=delete&id_komentar=' . $erow['id_komentar'] . '" onclick="return confirm(\'Anda yakin akan menghapus komentar ' . $erow['kode_ruangan'] . '?\')" class="a"> Hapus</a>
												</td>
											 </tr>
											 <tr class="tr1">
												<td colspan="2"><hr></td>
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