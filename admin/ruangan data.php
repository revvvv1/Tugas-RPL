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
		if (isset($_GET['aksi']) == 'delete') {
			$id_ruangan = $_GET['id_ruangan'];
			$cek = $koneksi->query("select*from ruangan where id_ruangan='$id_ruangan'");
			if ($cek->num_rows == 0) {
				$pesan = '';
			} else {
				$koneksi->query("delete from komentar where id_ruangan='$id_ruangan'");
				$delete = $koneksi->query("delete from ruangan where id_ruangan='$id_ruangan'");
				if ($delete) {
					$pesan = '<p><b>DONE!</b>, Data berhasil dihapus.</p>';
				} else {
					$pesan = '<p><b>DONT DELETE!</b>, Data gagal dihapus.</p>';
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
							<h3>Data Ruangan</h3>
						</td>
						<hr>
						<font>Ini adalah data ruangan yang bisa digunakan.</font>
						<?php echo $pesan; ?>
						<table class="tabel">
							<tr>
								<td class="td2" align="right">
									<form method="get" action="">
										<input type="text" class="kotak" name="cari" style="width: 200px;" placeholder="Cari data disini...">
										<button type="submit" class="kotak" style="width: 67px;">Cari</button>
										<input type="button" class="kotak" value="Tambah" style="width: 97px;" onclick="window.location = 'ruangan tambah.php';" />
									</form>
								</td>
						</table>
						<table class="tabel">
							<tr class="tr1">
								<th class="th1">No</th>
								<th class="th1">Kode</th>
								<th class="th1">Lantai</th>
								<th class="th1">Prodi</th>
								<th class="th1">Fasilitas</th>
								<th class="th1">Kondisi</th>
								<th class="th1">Opsi</th>
							</tr>

							<?php
							if (isset($_GET['cari'])) {
								$cari = $_GET['cari'];
								$cek = $koneksi->query("select * from ruangan where 
        															 kode_ruangan like '%" . $cari . "%' 
        														  or lantai like '%" . $cari . "'
        														  or gedung like '%" . $cari . "%'
        														  or fasilitas like '%" . $cari . "%'
        														  or kondisi like '%" . $cari . "%' ORDER BY kode_ruangan")
									or die($koneksi->error . __LINE__);;
								if ($cek->num_rows == 0) {
									echo '';
								} else {
									$cek = $koneksi->query("select * from ruangan where
            														 kode_ruangan like '%" . $cari . "%'
            													  or lantai like '%" . $cari . "'
            													  or gedung like '%" . $cari . "%'
            													  or fasilitas like '%" . $cari . "%'
            													  or kondisi like '%" . $cari . "%' ORDER BY kode_ruangan");
								}
							} else {
								$cek = $koneksi->query("select * from ruangan LIMIT $start,$perhalaman");
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
													<td class="td1">' . $erow['kondisi'] . '</td>
													<td class="td1">
														<a href="ruangan edit.php?id_ruangan=' . $erow['id_ruangan'] . '" class="a">Edit</a>
														||
														<a href="ruangan data.php?aksi=delete&id_ruangan=' . $erow['id_ruangan'] . '" onclick="return confirm(\'Anda yakin akan menghapus data ' . $erow['kode_ruangan'] . '?\')" class="a">Hapus</a>
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