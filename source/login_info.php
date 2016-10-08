<?php
$sql = "SELECT * FROM user WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
$qry = mysql_query($sql, $koneksidb)  or die ("Query user salah : ".mysql_error());
$row = mysql_fetch_array($qry);
?>
<div class='alert fade in'>
<button type='button' class='close' data-dismiss='alert'>&times;</button>
Halo <?php echo $row['nm_user']; ?>. Login anda sebagai <?php echo $row['username']; ?> 
</div>