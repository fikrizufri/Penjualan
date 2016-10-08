<?php
include_once "library/inc.seslogin.php";


if($_GET) {
	
	$kodeSupplier = isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : 'ALL';

	
	if(isset($_POST['btnFilter'])) {
		if (trim($_POST['cmbSupplier'])=="ALL") {
			
			$filterSQL 	= "SELECT barang.*, Jenis.nm_Jenis FROM barang, Jenis 
							WHERE barang.kd_Jenis=Jenis.kd_Jenis ORDER BY barang.kd_barang";
		}
		else {
			
			$filterSQL 	= "SELECT barang.*, Jenis.nm_Jenis FROM barang, Jenis 
							WHERE barang.kd_Jenis=Jenis.kd_Jenis AND kd_supplier ='$kodeSupplier'
							ORDER BY kd_barang";
		}
	}
	else {
		
		$filterSQL 	= "SELECT barang.*, Jenis.nm_Jenis FROM barang, Jenis 
						WHERE barang.kd_Jenis=Jenis.kd_Jenis ORDER BY barang.kd_barang";
	}
}


$row = 50;  
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageQry = mysql_query($filterSQL, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">KONTROL STOK BARANG</h2>
</div>
<div class="alert">
  			<button type="button" class="close" data-dismiss="alert">&times;</button>
  			<strong>Filter Stok Berdasar  </strong>
		  </div>
<form action="?page=StokBarang" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table table-condensed">
      <td width="84"><strong> Supplier </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="397">
	  <select name="cmbSupplier">
        <option value="ALL">- ALL -</option>
        <?php
	  $mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($kolomData = mysql_fetch_array($myQry)) {
	  	if ($kodeSupplier == $kolomData['kd_supplier']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$kolomData[kd_supplier]' $cek>$kolomData[nm_supplier]</option>";
	  }
	  $mySql ="";
	  ?>
      </select>
      <input name="btnFilter" type="submit" value=" Filter "/></td>
    </tr>
  </table>
</form>
<table class="table table-condensed" width="800" border="0" cellspacing="1" cellpadding="2"><tr>
    <th width="25" ><b>No</b></th>
    <th width="72" ><strong>Kode</strong></th>
    <th width="367" ><b>Nama Barang </b></th>
    <th width="118" ><strong>Jenis</strong></th>
    <th width="36" align="center" ><strong>Stok</strong></th>
    <th width="109" align="center" ><b>Stok Opname </b></th>
    <td width="37" align="center" ><strong>Tools</strong></td>
    <td></td>
  </tr>
  <?php
	
	$mySql 	= $filterSQL." LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_barang'];

		
		
		
		
		if($kolomData['stok_opname'] > 3) {
			$warna_stok	= "";
		}
		elseif($kolomData['stok_opname'] >= 1) {
			$warna_stok	= "#00ffe4"; 
		}
		elseif($kolomData['stok_opname'] >= 0) {
			$warna_stok	= "#0006ff";
		}
		else {
			$warna_stok	= "";
		}
	?>
  <tr >
    <td><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['kd_barang']; ?></td>
    <td><?php echo $kolomData['nm_panjang']; ?></td>
    <td><?php echo $kolomData['nm_Jenis']; ?></td>
    <td align="center"><?php echo $kolomData['stok']; ?></td>
    <td  bgcolor="<?php echo $warna_stok; ?>"><p class="text-center"><?php echo $kolomData['stok_opname']; ?></p></td>
    <td align="center" ><a href="?page=EditStokBarang&amp;Kode=<?php echo $Kode; ?>"><i class="icon-wrench"></i></a></td>
  </tr>
  <?php } ?><tr>
    <td colspan="3" ><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td colspan="3" align="right"><b>Halaman ke :</b></td>
    <td>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=StokBarang&hal=$list[$h]'>$h</a> ";
	}
	?>
    </td>
  </tr>
</table>
