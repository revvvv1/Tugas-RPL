<?php
include('include/koneksi.php');
include("include/akses koordinator.php");
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
						<li><a href="index admin.php">Login Admin</a></li>
						<li><a href="login.php">Login Or Register User</a></li>
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

						<h1>Welcome</h1>
						<hr>
						<marquee>Gunakan Ruangan Dengan Baik dan Jaga Kondisi Ruangan Dalam Belajar Mengajar....</marquee>
						<div style="text-align:center;">
							<img src="FT.jpg" alt="Gambar Ruangan" style="width:80%;max-width:600px;margin-top:20px;">
						</div>
					</div>
				</div>

				<nav class="menu">
					<div class="menu1">
						<h3>Sistem Manejemen Ruangan Fakultas Teknik</h3>
						<hr>
						<p align="justify">
							<font>Sistem manajemen ruangan adalah sebuah informasi yang mengenai ruangan baik itu ruangan kosong atau terisi yang nantinya digunakan untuk belajar mengajar. Dan dapat juga bisa memberikan saran, komentar atau melaporkan mengenai keadaan suatu kondisi dari ruangan.</font>
						</p>

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