<?php
include_once "library/inc.seslogin.php";
?>
<div class='hero-unit'><h2 align="left">Laporan Supplier</h2>
</div>
<table  class="table table-hover"><tr>
    <td width="34" align="center" ><b>No</b></td>
    <td width="180" ><b>Nama Supplier </b></td>
    <td width="351" ><b>Alamat Lengkap </b> </td>  
    <td width="114" ><strong>No Telepon </strong></td>
  </tr>
	<?php
	$mySql = "SELECT * FROM supplier ORDER BY nm_supplier ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
	?><tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['nm_supplier']; ?></td>
    <td><?php echo $kolomData['alamat']; ?></td>
    <td><?php echo $kolomData['no_telepon']; ?></td>
  </tr>
  <?php } ?>
</table>
<a href="#" onclick="javascript:window.open('source/cetak_supplier.php', width='900',height=330, left=0)"><i class="icon-print" ></i></a>