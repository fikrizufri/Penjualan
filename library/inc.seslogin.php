<?php
if(empty($_SESSION['SES_LOGIN'])) {
	echo "<center>";
	echo "<br> <br> <b>Maaf Akses Anda Ditolak!</b> <br>
		  Silahkan masukkan Data Login Anda dengan benar untuk bisa mengakses halaman ini.";
	echo "<br><b><a href='index.php'>Silahkan Kembali</a></b> <br>";	  
	echo "</center>";
	exit;
}
?>