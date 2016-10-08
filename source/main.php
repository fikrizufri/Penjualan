<?php
if(isset($_SESSION['SES_ADMIN'])) {
	include_once "page_admin.php";
	exit;
}
else if(isset($_SESSION['SES_KASIR'])) {
	include_once "page_kasir.php";	
	exit;
}
else {
	include_once "source/pagelogin.php";
}
?>