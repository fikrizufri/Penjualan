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
							WHERE barang.kd_Jenis=Jenis.kd_Jenis AND barang.kd_supplier ='$kodeSupplier' 
							ORDER BY barang.kd_barang";
		}
	}
	else {
		$filterSQL = "SELECT barang.*, Jenis.nm_Jenis FROM barang, Jenis 
							WHERE barang.kd_Jenis=Jenis.kd_Jenis ORDER BY barang.kd_barang";
	}
}

$row = 50;  
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageQry = mysql_query($filterSQL, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Laporan Barang Dari Supplier</h2>
</div>
<form action="?page=LaporanBarangBySupplier" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table table-condensed"><tr>
    </tr><tr>
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
      <input name="btnFilter" type="submit" value=" Filter " class="btn btn-primary"/></td>
    </tr>
  </table>
</form>
<table table class="table table-hover"><tr>
    <td width="24" ><b>No</b></td>
    <td width="68" ><strong>Kode</strong></td>
    <td width="345" ><b>Judul Barang </b></td>
    <td width="130" ><strong>Jenis</strong></td>
    <td width="80" align="right" ><b>Harga (Rp) </b></td>
    <td width="40" align="center" ><strong>Disk</strong></td>
    <td width="40" align="center" ><strong>Stok</strong></td>
    <td width="32" align="center" ><strong>Print</strong></td>
  </tr>
  <?php
	$mySql 	= $filterSQL." LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_barang'];

		
	?>
  <tr >
    <td><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['kd_barang']; ?></td>
    <td><?php echo $kolomData['nm_panjang']; ?></td>
    <td><?php echo $kolomData['nm_Jenis']; ?></td>
    <td align="right"><b><?php echo format_angka($kolomData['harga_jual']); ?></b></td>
    <td align="center"><?php echo $kolomData['diskon']; ?></td>
    <td align="center"><?php echo $kolomData['stok']; ?></td>
    <td align="center"><a href="#" onclick="javascript:window.open('source/barang_view.php?Kode=<?php echo $Kode; ?>', width='900',height=330, left=0)" ><i class="icon-print"></i></a></td>
  </tr>
  <?php } ?><tr>
    <td colspan="3" ><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td colspan="5" align="right" ><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=LaporanBarangBySupplier&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
