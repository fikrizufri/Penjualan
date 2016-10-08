<?php
include_once "library/inc.seslogin.php";

if($_GET) {
	if(isset($_POST['btnUpdate'])){
		
		$pesanError = array();
		if (trim($_POST['txtkategori'])=="") {
			$pesanError[] = "Data <b>Nama kategori</b> tidak boleh kosong !";		
		}
		
		
		$txtkategori= $_POST['txtkategori'];
		
		
		$cekSql="SELECT * FROM kategori WHERE nm_kategori='$txtkategori' AND NOT(nm_kategori='".$_POST['txtLama']."')";
		$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($cekQry)>=1){
			$pesanError[] = "Maaf, kategori <b> $txtkategori </b> sudah ada, ganti dengan yang lain";
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
			
			$mySql	= "UPDATE kategori SET nm_kategori='$txtkategori' WHERE kd_kategori ='".$_POST['txtKode']."'";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=DataKategori'>";
			}
			exit;
		}	

	} 
	
	
	$Kode	 = isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$sqlShow = "SELECT * FROM kategori WHERE kd_kategori='$Kode'";
	$qryShow = mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data  salah : ".mysql_error());
	$dataShow = mysql_fetch_array($qryShow);
	
		
		$dataKode	= $dataShow['kd_kategori'];
		$dataNama	= isset($dataShow['nm_kategori']) ?  $dataShow['nm_kategori'] : $_POST['txtkategori'];
		$dataNamaLm	= $dataShow['nm_kategori'];
} 
?>
<div class='hero-unit'><h2 align="left">Ubah Data Kategori</h2>
</div>
<form action="?page=EditKategori" method="post" name="frmedit">
<table class="table table-condensed" width="100%" style="margin-top:0px;"><tr>
	  
	</tr><tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="textfield" type="text" class="input-small" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr><tr>
	  <td><b>Nama Kategori </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtkategori" type="text" value="<?php echo $dataNama; ?>" size="60" maxlength="100" />
      <input name="txtLama" type="hidden" value="<?php echo $dataNamaLm; ?>" /></td></tr><tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input name="btnUpdate" type="submit" class="btn btn-primary"  value=" Update " />
        </td>
    </tr>
</table>
</form>

