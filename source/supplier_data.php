<?php
include_once "library/inc.seslogin.php";
include_once "supplier_add.php";


$row = 20;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM supplier";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<strong><div class='hero-unit'><h2 align="left"> Daftar Supplier</h2>
</div>
<hr></strong>
<table width="700" border="0" cellpadding="2" cellspacing="1" class="table table-condensed">
  <tr >
  	<ul class="pager">
  		<li class="previous">
   		<a data-toggle="modal" href="#windowTitleDialog"><i class="icon-plus"></i>Tambah Supplier</a>
  		</li>
 	</ul>
  </tr>  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table table-condensed" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="26" align="center"><b>No</b></th>
        <th width="224"><b>Nama Supplier </b></th>
        <th width="320"><b>Alamat</b></th>
        <td width="49" align="center"><b>Edit</b></td>
        <td width="49" align="center"><b>Delete</b></td>
      </tr>
      <?php
	$mySql = "SELECT * FROM supplier ORDER BY kd_supplier ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_supplier'];
		
		
		
	?>
      <tr >
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $kolomData['nm_supplier']; ?></td>
        <td><?php echo $kolomData['alamat']; ?></td>
        <td align="center"><a href="?page=EditSupplier&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"><i class="icon-wrench"></i></a></td>
        <td align="center"><a href="?page=DeleteSupplier&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Anda yakin menghapus <?php echo $kolomData['nm_supplier']; ?> ... ?')"><i class="icon-trash"></i></a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td align="right"><b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=DataSupplier&hal=$list[$h]'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>

