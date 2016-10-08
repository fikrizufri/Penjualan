<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

if($_GET) {
	if(isset($_POST['btnUpdate'])){
		
		$pesanError = array();
		if (trim($_POST['txtJenis'])=="") {
			$pesanError[] = "Data <b>Nama Jenis</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbkategorisub'])=="BLANK") {
			$pesanError[] = "Data <b>kategori</b> belum dipilih !";		
		}
		
		
		$txtJenis	= $_POST['txtJenis'];
		$txtNmLama	= $_POST['txtNmLama'];
		$cmbkategorisub= $_POST['cmbkategorisub'];
		
		
		$cekSql="SELECT * FROM Jenis WHERE nm_Jenis='$txtJenis' AND NOT(nm_Jenis='$txtNmLama')";
		$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($cekQry)>=1){
			$pesanError[] = "Maaf, Jenis <b> $txtJenis </b> sudah ada, ganti dengan yang lain";
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
			
			$mySql	= "UPDATE Jenis SET nm_Jenis='$txtJenis', kd_subkategori='$cmbkategorisub' 
						WHERE kd_Jenis ='".$_POST['txtKode']."'";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=DataJenis'>";
			}
			exit;
		}	
		
	} 
	$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$sqlShow = "SELECT * FROM Jenis WHERE kd_Jenis='$Kode'";
	$qryShow = mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
	$dataShow = mysql_fetch_array($qryShow);

		
		$dataKode	= $dataShow['kd_Jenis'];
		$dataNama	= isset($dataShow['nm_Jenis']) ?  $dataShow['nm_Jenis'] : $_POST['txtJenis'];
		$dataNmLama	= $dataShow['nm_Jenis'];
		$DataKategorisub	= isset($dataShow['kd_subkategori']) ?  $dataShow['kd_subkategori'] : $_POST['cmbkategorisub'];
} 
?>
<div class='hero-unit'><h2 align="left">Ubah Data Jenis</h2></div>
<form action="?page=EditJenis" method="post" name="frmedit">
<table class="table table-condensed" width="100%" style="margin-top:0px;"><tr>
	 
	</tr><tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="textfield" type="text" class="input-small" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr><tr>
	  <td><b>Nama Jenis </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtJenis" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" />
      <input name="txtNmLama" type="hidden" value="<?php echo $dataNmLama; ?>" /></td></tr><tr>
      <td><strong>Sub kategori </strong></td>
	  <td><b>:</b></td>
	  <td><select name="cmbkategorisub">
        <option value="BLANK"> </option>
        <?php
	  $dataSql = "SELECT * FROM kategori_sub ORDER BY kd_subkategori";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataRow['kd_subkategori']== $DataKategorisub) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_subkategori]' $cek>$dataRow[nm_subkategori]</option>";
	  }
	  $sqlData ="";
	  ?>
      </select></td>
    </tr><tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnUpdate" value=" Update " class="btn btn-primary">
        </td>
    </tr>
</table>
</form>

