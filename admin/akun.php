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
	$email = $_SESSION['email']; // mengambil username dari session yang login

	$cek = $koneksi->query("select*from user where email='$email'"); // query memilih entri username pada database
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

		<?php
		if (isset($_GET['aksi']) == 'aktif') {
			$id_koordinator = $_GET['id_koordinator'];

			$cek = $koneksi->query("select*from koordinator where id_koordinator='$id_koordinator'");
			if ($cek->num_rows == 0) {
				$pesan = '';
			} else {
				$rowe 	  = $cek->fetch_assoc();
				$email 	  = $rowe['email'];
				$password = $rowe['password'];

				$koneksi->query("update koordinator set status='aktif' where id_koordinator='$id_koordinator'") or die(mysqli_error($koneksi));
				$insert = $koneksi->query("insert into akun(email,password) values ('$email','$password')") or die(mysqli_error($koneksi));
				if ($insert) {
					$pesan = '<p><b>DONE!</b>, Data berhasil di Aktifkan.</p>';
				} else {
					$pesan = ' <p><b>DONT DELETE!</b>, Data gagal di Aktifkan.</p>';
				}
			}
		} else {
			$pesan = '';
		}
		?>

		<?php
		//menghitung data yang akan di tampilkan pada tabel
		$perhalaman = 5;
		$data = mysqli_query($koneksi, "select * from koordinator");
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
							<h3>Data Konfirmasi Akun</h3>
						</td>
						<hr>
						<?php echo $pesan; ?>

						<table class="tabel">


							<?php
							$cek = $koneksi->query("select * from koordinator natural join fakultas natural join prodi where status='non-aktif' LIMIT $start,$perhalaman");
							if ($cek->num_rows == 0) {
								echo '<tr class="tr1">
            									<td class="td1" colspan="8"><center>Tidak ada data saat ini...</center></td>
	           								  </tr>';
							} else {
								echo '
											<tr class="tr1">
												<th class="th1">No</th>
												<th class="th1">NPM</th>
												<th class="th1">Nama</th>
												<th class="th1">Jenis Kelamin</th>
												<th class="th1">Kelas</th>
												<th class="th1">Jurusan</th>
												<th class="th1">Opsi</th>
											</tr>
										';
								$no = 1;
								while ($erow = $cek->fetch_assoc()) {
									extract($erow)
							?>
							<?php
									echo '<tr class="tr1">
													<td class="td1">' . $no . '</td>
													<td class="td1">' . $erow['npm'] . '</td>
													<td class="td1">' . $erow['nama'] . '</td>
													<td class="td1">' . $erow['jenis_kelamin'] . '</td>
													<td class="td1">' . $erow['kelas'] . '</td>
													<td class="td1">' . $erow['prodi'] . '</td>
													<td class="td1">
													 <button class="kotak">
														<a href="akun.php?aksi=aktif&id_koordinator=' . $erow['id_koordinator'] . '" onclick="return confirm(\'Anda yakin akan mengaktifkan data ' . $erow['nama'] . '?\')" class="a">AKTIFKAN</a>
													 </buutton>
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