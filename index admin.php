<?php
include('include/koneksi.php');
include("include/akses admin.php");
?>

<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Informasi Kelas</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<div class="halaman">
		<header class="header">
			<div class="isi-header">
				<div class="logo">
					<img src="admin/laporan/logo2.png" alt="Logo" style="height:50px;">
				</div>
				<div class="menu-atas">
					<ul>
						<li><a href="index.php">Kembali</a></li>
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
						if (isset($_POST['tambah'])) { // jika tombol 'Simpan' dengan properti name="add" ditekan
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

							move_uploaded_file($file_tmp, 'koordinator/foto/' . $nama1);
							$cek = $koneksi->query("SELECT * FROM koordinator natural join akun WHERE npm='$npm' OR email='$email'"); // query untuk memilih entri dengan nim terpilih
							if ($cek->num_rows == 0) { // mengecek apakah nim yang akan ditambahkan tidak ada dalam database
								if ($pass1 == $pass2) { // mengecek apakah nilai pada pass1 dan pass2 bernilai sama
									$pass = md5($pass1); // assigment variabel pass dengan nilai pass1 yang sudah dienkripsi dengan md5
									$insert = $koneksi->query("INSERT INTO koordinator(
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
                                  VALUES(
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
										$pesan = '<p><b>DONE!</b>, Registrasi berhasil, silahkan login.</p>';
									} else {
										$pesan = '<p><b>Upss</b>, Gagal melakukan registrasi.</p>';
									}
								} else {
									$pesan = '<p><b>WARNING!</b>, Password tidak sama.</p>';
								}
							} else {
								$pesan = '<p><b>WARNING!</b>, NPM/Email sudah digunakan.</p>';
							}
						} else {
							$pesan = '';
						}

						?>
						<form method="post" action="" enctype="multipart/form-data">
							<h3>Registrasi</h3>
							<hr>
							<?php echo $pesan; ?>
							<fieldset class="filset">
								<legend>Akun :</legend>
								<input class="kotak" type="text" name="email" style="width: 100%;" placeholder="Email" required="">
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
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="GJ">GJ</option>
								<option value="GP">GP</option>
							</select>

							<select name="id_fakultas" class="kotak" style="width: 100%;" id="fakultas" required="">
								<option>Pilih Fakultas</option>
								<?php
								$result = mysqli_query($koneksi, "select*from fakultas");
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
						</fieldset>
						</form>
					</div>
				</div>

				<nav class="menu">
					<div class="menu1">
						<h3>LOGIN</h3>
						<hr>
						<?php
						if (isset($_POST['login'])) {
							$email = mysqli_real_escape_string($koneksi, htmlentities($_POST['email']));
							$pass  = mysqli_real_escape_string($koneksi, htmlentities(md5($_POST['password'])));

							$sql = mysqli_query($koneksi, "select*from user where email='$email' and password='$pass'") or die(mysqli_error($koneksi));
							if (mysqli_num_rows($sql) == 0) {
								echo '<center><span>User tidak ditemukan</span></center>';
							} else {
								$row = mysqli_fetch_assoc($sql);
								if ($row) {
									$_SESSION['email'] = $email;
									echo '<script language="javascript">document.location="admin/index.php";</script>';
								} else {
									echo '<center><div class="alert alert-danger">Upss...!!! Login gagal.</div></center>';
								}
							}
						}
						?>

						<form method="post" action="">
							<input class="kotak" type="text" name="email" style="width: 100%;" placeholder="Email" required="">
							<input class="kotak" type="password" name="password" style="width: 100%;" placeholder="Password" required="">
							<button type="skotak" name="login" class="kotak" style="width: 100%;">Login</button>
						</form>
					</div>
				</nav>

				<div class="hapus"></div>
			</div>
		</div>

		<div class="footer1">
			<div class="isi-footer1">
				<?php include("footer.php") ?>
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
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>

<script>
	$("#fakultas").change(function() {
		// variabel dari nilai combo box Fakultas
		var id_fakultas = $("#fakultas").val();
		// mengirim dan mengambil data
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "admin/include/prodi.php",
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