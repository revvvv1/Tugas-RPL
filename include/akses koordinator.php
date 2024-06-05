<?php
if (session_status() == PHP_SESSION_NONE) { // mengecek apakah session belum dimulai
    session_start(); // maka mulai session
}
if(isset($_SESSION['email'])){ // jika session adalah admin
	echo '<script language="javascript">document.location="koordinator/index.php";</script>'; // maka arahkan ke halaman admin
}
?>