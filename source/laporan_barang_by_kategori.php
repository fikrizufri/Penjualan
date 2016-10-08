<?php
include_once "library/inc.seslogin.php";

$kategoriSQL= "";
$kategoriSubSQL= "";
$JenisSQL	= "";

$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
$dataSubKategori= isset($_POST['cmbSubKategori']) ? $_POST['cmbSubKategori'] : '';
$dataJenis		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';

if($_GET) {
	if (isset($_POST['btnCetak'])) {
			echo "<script>";
			echo "window.open('source/cetak_barang_by_kategori.php?kodeKategori=$dataKategori&kodeKategorisub=$dataSubKategori&kodeJenis=$dataJenis', width=330,height=330,left=100, top=25)";
			echo "</script>";
	}

	if(isset($_POST['btnTampil'])) {
		if (trim($_POST['cmbKategori']) =="BLANK") {
			$kategoriSQL = "";
		}
		else {
			$kategoriSQL = "AND kategori.kd_kategori='$dataKategori'";
		}
		
		if (trim($_POST['cmbSubKategori']) =="BLANK") {
			$kategoriSubSQL = "";
		}
		else {
			$kategoriSubSQL = "AND kategori_sub.kd_subkategori='$dataSubKategori'";
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
			$kategoriSQL $kategoriSubSQL $JenisSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<div class='hero-unit'><h2 align="left">LAPORAN  BARANG - Per Kategori </h2></div>
<form action="?page=LaporanBarangByKategori" method="post" name="form1" target="_self">
  <table width="542" border="0"  >
    
    <tr>
      <td width="163"><b>Nama Kategori </b></td>
      <td width="5"><b>:</b></td>
      <td width="360"><select name="cmbKategori" onchange="javascript:submitform();">
          <option value="BLANK">....</option>
          <?php
	  $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataRow['kd_kategori'] == $dataKategori) {
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
      <td><select name="cmbSubKategori" onchange="javascript:submitform();">
          <option value="BLANK">....</option>
          <?php
	  $data2Sql = "SELECT * FROM kategori_sub WHERE kd_kategori='$dataKategori' ORDER BY kd_subkategori";
	  $data2Qry = mysql_query($data2Sql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($data2Row = mysql_fetch_array($data2Qry)) {
		if ($data2Row['kd_subkategori'] == $dataSubKategori) {
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
	  $data3Sql = "SELECT * FROM Jenis WHERE kd_subkategori='$dataSubKategori' ORDER BY kd_Jenis";
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
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " class="btn btn-primary"/>
      <input name="btnCetak" type="submit" value=" Cetak " class="btn btn-primary"/></td>
    </tr>
  </table>
</form>
<table  width="800" border="0" cellspacing="1" cellpadding="2"  class="table hover">
  <tr>
    <td width="25" ><b>No</b></td>
    <td width="72" ><strong>Kode</strong></td>
    <td width="454" ><b>Nama Barang </b></td>
    <td width="76" align="right" ><b>Harga (Rp)</b></td>
    <td width="47" align="center" ><strong>Disk</strong></td>
    <td width="45" align="center" ><b>Stok </b></td>
    <td width="45" align="center" ><strong>Print</strong></td>
  </tr>
  <?php
	$mySql = "SELECT barang.* FROM kategori, kategori_sub, Jenis, barang
				WHERE kategori.kd_kategori=kategori_sub.kd_kategori
				AND kategori_sub.kd_subkategori=Jenis.kd_subkategori
				AND Jenis.kd_Jenis=barang.kd_Jenis
				$kategoriSQL $kategoriSubSQL $JenisSQL  ORDER BY barang.stok DESC LIMIT $hal, $row";
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
    <td align="right"><b><?php echo format_angka($kolomData['harga_jual']); ?></b></td>
    <td align="center"><?php echo $kolomData['diskon']; ?></td>
    <td align="center"><?php echo $kolomData['stok']; ?></td>
    <td align="center"><a href="cetak/barang_view.php?Kode=<?php echo $Kode; ?>" target="_blank"><i class="icon-print"></i></a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" ><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td colspan="4" align="right" ><b>Halaman ke :</b>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Laporan-Barang-by-Kategori&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
