<?php
include_once "library/inc.seslogin.php";

if($_GET) {
	if(isset($_POST['btnUpdate'])){
		
		$pesanError = array();
		if (trim($_POST['txtSupplier'])=="") {
			$pesanError[] = "Data <b>Nama supplier</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtAlamat'])=="") {
			$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtTelepon'])=="") {
			$pesanError[] = "Data <b>No Telepon</b> tidak boleh kosong !";		
		}
		
		
		$txtSupplier= $_POST['txtSupplier'];
		$txtLama	= $_POST['txtLama'];
		$txtAlamat	= $_POST['txtAlamat'];
		$txtTelepon	= $_POST['txtTelepon'];
		
		
		$cekSql="SELECT * FROM supplier WHERE nm_supplier='$txtSupplier' AND NOT(nm_supplier='".$_POST['txtLama']."')";
		$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($cekQry)>=1){
			$pesanError[] = "Maaf, supplier <b> $txtSupplier </b> sudah ada, ganti dengan yang lain";
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
			
			$mySql	= "UPDATE supplier SET nm_supplier='$txtSupplier', alamat='$txtAlamat',
						no_telepon='$txtTelepon' WHERE kd_supplier ='".$_POST['txtKode']."'";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=DataSupplier'>";
			}
			exit;
		}	
	} 
	
	
	$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$sqlShow= "SELECT * FROM supplier WHERE kd_supplier='$Kode'";
	$qryShow= mysql_query($sqlShow, $koneksidb)  or die ("Query salah : ".mysql_error());
	$dataShow = mysql_fetch_array($qryShow);
	
	
	$dataKode	= $dataShow['kd_supplier'];
	$dataNama	= isset($dataShow['nm_supplier']) ?  $dataShow['nm_supplier'] : $_POST['txtSupplier'];
	$dataLama	= $dataShow['nm_supplier'];
	$dataAlamat = isset($dataShow['alamat']) ?  $dataShow['alamat'] : $_POST['txtAlamat'];
	$dataTelepon = isset($dataShow['no_telepon']) ?  $dataShow['no_telepon'] : $_POST['txtTelepon'];
} 
?>
<div class='hero-unit'><h2 align="left">Ubah Data Supplier</h2></div>
<form action="?page=EditSupplier" method="post" name="frmedit">
<table class="table table-condensed" width="100%" style="margin-top:0px;"><tr>
	</tr><tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="textfield" class="input-small" type="text" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr><tr>
	  <td><b>Nama Supplier </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtSupplier" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" />
      <input name="txtLama" type="hidden" value="<?php echo $dataLama; ?>" /></td></tr><tr>
      <td><b>Alamat Lengkap </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtAlamat" type="text" value="<?php echo $dataAlamat; ?>" size="80" maxlength="200" /></td>
    </tr><tr>
      <td><b>No Telepon </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtTelepon" type="text" value="<?php echo $dataTelepon; ?>" size="20" maxlength="20" /></td>
    </tr><tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input name="btnUpdate" type="submit" class="btn btn-primary"  value=" Update " />
        </td>
    </tr>
</table>
</form>

