<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

$supplierSQL= "";
$kategoriSQL= "";
$kategoriSubSQL= "";
$JenisSQL	= "";


$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
$DataKategori	= isset($_POST['cmbkategori']) ? $_POST['cmbkategori'] : '';
$dataSubkategori= isset($_POST['cmbSubkategori']) ? $_POST['cmbSubkategori'] : '';
$dataJenis		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';

if($_GET) {
	
	if(isset($_POST['btnTampil'])) {
		
		if (trim($_POST['cmbSupplier']) =="BLANK") {
			$supplierSQL = "";
		}
		else {
			$supplierSQL = "AND barang.kd_supplier='$dataSupplier'";
		}
		
		
		if (trim($_POST['cmbkategori']) =="BLANK") {
			$kategoriSQL = "";
		}
		else {
			$kategoriSQL = "AND kategori.kd_kategori='$DataKategori'";
		}
		
		
		if (trim($_POST['cmbSubkategori']) =="BLANK") {
			$kategoriSubSQL = "";
		}
		else {
			$kategoriSubSQL = "AND kategori.kd_subkategori='$dataSubkategori'";
		}
		
		
		if (trim($_POST['cmbJenis']) =="BLANK") {
			$JenisSQL = "";
		}
		else {
			$kategoriSQL = "";
			$JenisSQL = "AND Jenis.kd_Jenis='$dataJenis'";
		}
	}
	else {
		
		$supplierSQL= "";
		$kategoriSQL= "";
		$kategoriSubSQL= "";
		$JenisSQL	= "";
	}
}


$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT barang.* FROM kategori, kategori_sub, Jenis, barang
			WHERE kategori.kd_kategori=kategori_sub.kd_kategori
			AND kategori_sub.kd_subkategori=Jenis.kd_subkategori
			AND Jenis.kd_Jenis=barang.kd_Jenis
			$supplierSQL $kategoriSQL $JenisSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>

<div class='hero-unit'><h2 align="left">Filter Data Barang</h2>
</div>
<form action="?page=FilterBarang" method="post" name="form1" target="_self">
<table>
<tr>
  <td><strong>Supplier </strong></td>
  <td><b>:</b></td>
  <td><select name="cmbSupplier">
    <option value="BLANK">....</option>
    <?php
	  $dataSql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataRow['kd_supplier']== $dataSupplier) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_supplier]' $cek> $dataRow[nm_supplier]</option>";
	  }
	  $sqlData ="";
	  ?>
  </select></td>
</tr>
<tr>
  <td width="35%"><b>Nama Kategori </b></td>
  <td width="5"><b>:</b></td>
  <td width="326">
  <select name="cmbkategori" onChange="javascript:submitform();">
	<option value="BLANK">....</option>
	<?php
	  $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataRow['kd_kategori'] == $DataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
	  }
	  $sqlData ="";
	  ?>
	  </select></td>
</tr>
<tr>
  <td><b>Nama Sub Kategori </b></td>
  <td><b>:</b></td>
  <td><select name="cmbSubkategori" onChange="javascript:submitform();">
	  <option value="BLANK">....</option>
	  <?php
	  $data2Sql = "SELECT * FROM kategori_sub WHERE kd_kategori='$DataKategori' ORDER BY kd_subkategori";
	  $data2Qry = mysql_query($data2Sql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($data2Row = mysql_fetch_array($data2Qry)) {
		if ($data2Row['kd_subkategori'] == $dataSubkategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$data2Row[kd_subkategori]' $cek>$data2Row[nm_subkategori]</option>";
	  }
	  $sqlData ="";
	  ?>
		</select></td>
</tr>
<tr>
  <td><b>Nama Jenis </b></td>
  <td><b>:</b></td>
  <td><select name="cmbJenis">
    <option value="BLANK">....</option>
    <?php
	  $data3Sql = "SELECT * FROM Jenis WHERE kd_subkategori='$dataSubkategori' ORDER BY kd_Jenis";
	  $data3Qry = mysql_query($data3Sql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($data3Row = mysql_fetch_array($data3Qry)) {
		if ($data3Row['kd_Jenis'] == $dataJenis) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$data3Row[kd_Jenis]' $cek>$data3Row[nm_Jenis]</option>";
	  }
	  $sqlData ="";
	  ?>
	  </select></td>
</tr>
<tr >
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><input name="btnTampil" class="btn btn-primary" type="submit" value=" Tampilkan " /></td>
</tr>
</table>
<br />
<table class="table table-condensed" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="24"><b>No</b></th>
    <th width="68"><strong>Kode</strong></th>
    <th width="371"><b>Nama Barang </b></th>
    <th width="48" align="center"><strong>Diskon</strong></th>
    <th width="49" align="center"><strong>Stok</strong></th>
    <th width="102" align="right"><b>Harga (Rp) </b></th>
    <td width="43" align="center"><strong>Print</strong></td>
    <td width="51" align="center"><strong>BCode</strong></td>
  </tr>
  <?php
	
	$mySql = "SELECT barang.* FROM kategori, kategori_sub, Jenis, barang
				WHERE kategori.kd_kategori=kategori_sub.kd_kategori
				AND kategori_sub.kd_subkategori=Jenis.kd_subkategori
				AND Jenis.kd_Jenis=barang.kd_Jenis
				$supplierSQL $kategoriSQL $JenisSQL  ORDER BY barang.stok DESC LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $hal; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_barang'];
		
		
		
	?>
  <tr >
    <td><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['kd_barang']; ?></td>
    <td><?php echo $kolomData['nm_panjang']; ?></td>
    <td align="center"><?php echo $kolomData['diskon']; ?></td>
    <td align="center"><?php echo $kolomData['stok']; ?></td>
    <td align="right"><b><?php echo format_angka($kolomData['harga_jual']); ?></b></td>
    <td align="center">
    <a href="source/barang_view.php?Kode=<?php echo $Kode; ?>" target="_blank"><i class="icon-print"></i></a></td>
    <td align="center">
    <a href="?page=Barcode&amp;Kode=<?php echo $Kode; ?>" target="_blank"><i class="icon-trash"></i></a>
    </td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" ><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td colspan="5" align="right" ><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=FilterBarang&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
</form>
