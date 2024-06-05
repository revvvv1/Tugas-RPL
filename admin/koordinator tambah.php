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
		<div class="halaman1">
			<div class="isi-halaman">

				<div class="isi">
					<div class="artikel">
						<!------------------------Proses Tambah Koordinator-------------------->
						<?php
						if (isset($_POST['tambah'])) {
							$email            = $_POST['email'];
							$npm              = $_POST['npm'];
							$nama             = $_POST['nama'];
							$jenis_kelamin    = $_POST['jenis_kelamin'];
							$tempat_lahir     = $_POST['tempat_lahir'];
							$tanggal_lahir    = $_POST['tanggal_lahir'];
							$kelas 			      = $_POST['kelas'];
							$id_fakultas      = $_POST['id_fakultas'];
							$id_prodi		      = $_POST['id_prodi'];
							$pass1            = $_POST['password1'];
							$pass2            = $_POST['password2'];

							$nama1 = $_FILES['foto']['name'];
							$x = explode('.', $nama1);
							$ekstensi = strtolower(end($x));
							$file_tmp = $_FILES['foto']['tmp_name'];

							move_uploaded_file($file_tmp, '../koordinator/foto/' . $nama1);
							$cek = $koneksi->query("select*from koordinator natural join akun where npm='$npm' OR email='$email'");
							if ($cek->num_rows == 0) {
								if ($pass1 == $pass2) {
									$pass = md5($pass1);
									$insert = $koneksi->query("insert into koordinator(
                                      email,
                                      password,
                                      npm,
                                      nama,
                                      jenis_kelamin,
                                      tempat_lahir,
                                      tanggal_lahir,
                                      kelas,
                                      id_fakultas,
                                      id_prodi,
                                      foto)
                                  values(
                                      '$email',
                                      '$pass',
                                      '$npm',
                                      '$nama',
                                      '$jenis_kelamin',
                                      '$tempat_lahir',
                                      '$tanggal_lahir',
                                      '$kelas',
                                      '$id_fakultas',
                                      '$id_prodi',
                                      '$nama1')") or die(mysqli_error($koneksi));
									$koneksi->query("insert into akun(email,password) values('$email','$pass')") or die(mysqli_error($koneksi));
									if ($insert) {
										$pesan = '<p><b>DONE!</b>, Data berhasil ditambahkan.</p>';
									} else {
										$pesan = '<p><b>Upss</b>, Data gagal disimpan.</p>';
									}
								} else {
									$pesan = '<p><b>WARNING!</b>, Password tidak sama.</p>';
								}
							} else {
								$pesan = '<p><b>WARNING!</b>, NPM/Email sudah digunakan.</p></div></div>';
							}
						} else {
							$pesan = '';
						}
						?>

						<form method="post" action="" enctype="multipart/form-data">
							<h3>Tambah Koordinator</h3>
							<hr>
							<?php echo $pesan; ?>
							<fieldset class="filset">
								<legend>Akun :</legend>
								<input class="kotak" type="email" name="email" style="width: 100%;" placeholder="Email" required="">
								<input class="kotak" type="password" name="password1" style="width: 100%;" placeholder="Password" required="">
								<input class="kotak" type="password" name="password2" style="width: 100%;" placeholder="Ulangi Password" required="">
							</fieldset>
					</div>
					<div class="artikel">
						<fieldset class="filset">
							<legend>Identitas :</legend>
							<input class="kotak" type="text" name="nama" style="width: 100%;" placeholder="Nama Lengkap" required="">
							<input class="kotak" type="text" name="npm" style="width: 100%;" placeholder="Nomor Induk Mahasiswa" required="">
							<input class="kotak" type="text" name="tempat_lahir" style="width: 50%;" placeholder="Tempat Lahir" required="">
							<input class="kotak" type="text" name="tanggal_lahir" style="width: 49%;" placeholder="Tanggal Lahir      Tahun-Bulan-Tanggal" required="">
							<select name="jenis_kelamin" class="kotak" style="width: 100%;" required="">
								<option value="">Jenis Kelamin</option>
								<option value="laki-laki">Laki-laki</option>
								<option value="perempuan">Perempuan</option>
							</select>

							<select name="kelas" class="kotak" style="width: 100%;" required="">
								<option value="">Kelas</option>
								<option value="4A">4A</option>
								<option value="4B">4B</option>
								<option value="4C">4C</option>
								<option value="4D">4D</option>
								<option value="4E">4E</option>
								<option value="4F">4F</option>
							</select>

							<select name="id_fakultas" class="kotak" style="width: 100%;" id="fakultas" required="">
								<option>Pilih Fakultas</option>
								<?php
								$result = $koneksi->query("select*from fakultas");
								while ($erow = mysqli_fetch_array($result)) {
									echo '<option value="' . $erow['id_fakultas'] . '">' . $erow['fakultas'] . '</option>';
								}
								?>
							</select>

							<select name="id_prodi" class="kotak" id="prodi" style="width: 100%;" required="">
								<option value="">Pilih Program Studi</option>
							</select>
							<input class="kotak" type="file" name="foto" style="width: 100%;" required="">
							<button type="submit" name="tambah" class="kotak" style="width: 100px;">Register</button>
							<button type="reset" class="kotak" style="width: 100px;">Batal</button>
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
<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>

<script>
	$("#fakultas").change(function() {
		// variabel dari nilai combo box Fakultas
		var id_fakultas = $("#fakultas").val();
		// mengirim dan mengambil data
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "include/prodi.php",
			data: "fakul=" + id_fakultas,
			success: function(msg) {
				// jika tidak ada data
				if (msg == '') {
					alert('Tidak ada data Jurusan');
				}
				// jika dapat mengambil data,, tampilkan di combo box jurusan
				else {
					$("#prodi").html(msg);
				}
			}
		});
	});
</script>

</html>