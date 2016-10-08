<?php
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

if($_GET) {
	if(isset($_POST['btnUpdate'])){
		
		$pesanError = array();
		if (trim($_POST['txtKode'])=="") {
			$pesanError[] = "Data <b>Kode Barang</b> tidak terbaca !";		
		}
		if (trim($_POST['txtStokOpname'])=="" OR ! is_numeric(trim($_POST['txtStokOpname']))) {
			$pesanError[] = "Data <b>Stok Opname</b> jual tidak boleh kosong, harus diisi angka atau 0 !";		
		}
		
		
		if (count($pesanError)>=1 ){
            echo "<div class='mssgBox'>";
			echo "<img src='images/attention.png'> <br><hr>";
				$noPesan=0;
				foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
					echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
				} 
			echo "</div> <br>"; 
		}
		else {
			
			$txtKode		= $_POST['txtKode'];
			$txtStokOpname	= $_POST['txtStokOpname'];

			
			$mySql	= "UPDATE barang SET stok_opname='$txtStokOpname' WHERE kd_barang ='$txtKode'";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=StokBarang'>";
			}
			exit;
		}	
	} 
	$Kode	 = isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$sqlShow = "SELECT barang.*, Jenis.nm_Jenis FROM barang, Jenis WHERE barang.kd_Jenis=Jenis.kd_Jenis AND barang.kd_barang='$Kode'";
	$qryShow = mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
	$dataShow= mysql_fetch_array($qryShow);
	
		
		$dataKode	= $dataShow['kd_barang'];
		$dataStokOpname	= isset($dataShow['stok_opname']) ?  $dataShow['stok_opname'] : $_POST['txtStokOpname'];
} 
?>

<div class='hero-unit'><h2 align="left">Ubah Stok Barang</h2>
</div>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
<table class="table table-condensed" width="100%" style="margin-top:0px;"><tr>
	  <td width="14%"><b>Kode Barang </b></td>
	  <td width="1%"><b>:</b></td>
    <td width="85%"><?php echo $dataShow['kd_barang']; ?>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr><tr>
      <td><b>Barcode</b></td>
	  <td><b>:</b></td>
	  <td><?php echo $dataShow['barcode']; ?></td>
    </tr><tr>
	  <td><b>Nama  Barang </b></td>
	  <td><b>:</b></td>
	  <td><?php echo $dataShow['nm_panjang']; ?></td></tr><tr>
      <td><b>Jenis</b></td>
	  <td><b>:</b></td>
	  <td><?php echo $dataShow['nm_Jenis']; ?></td>
    </tr><tr>
      <td><b>Stok</b></td>
	  <td><b>:</b></td>
	  <td><?php echo $dataShow['stok']; ?></td>
    </tr><tr>
      <td><b>Stok Opname </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtStokOpname" value="<?php echo $dataStokOpname; ?>" size="10" maxlength="30" /></td>
    </tr><tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnUpdate" value=" Update " class="btn btn-primary"></td>
    </tr>
</table>
</form>

