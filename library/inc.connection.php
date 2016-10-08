<?php

$host	= "localhost";
$user	= "root";
$pass	= "";
$db		= "db_har";


$koneksidb	= mysql_connect($host, $user, $pass);
if (! $koneksidb) {
  echo "Failed Connection !";
}


mysql_select_db($db) or die ("Database not Found !");
//ini_set('display_errors', 0);
?>