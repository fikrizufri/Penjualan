<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

if($_GET) {
	if(isset($_POST['btnUpdate'])){
		
		$pesanError = array();
		if (trim($_POST['txtSubkategori'])=="") {
			$pesanError[] = "Data <b>Nama Sub kategori</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbkategori'])=="BLANK") {
			$pesanError[] = "Data <b>kategori</b> belum dipilih !";		
		}
		
		
		$txtSubkategori	= $_POST['txtSubkategori'];
		$txtNmLama	= $_POST['txtNmLama'];
		$cmbkategori= $_POST['cmbkategori'];
		
		
		$cekSql="SELECT * FROM kategori_sub WHERE nm_subkategori='$txtSubkategori' AND NOT(nm_subkategori='$txtNmLama')";
		$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($cekQry)>=1){
			$pesanError[] = "Maaf, kategori_sub <b> $txtSubkategori </b> sudah ada, ganti dengan yang lain";
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
			
			$mySql	= "UPDATE kategori_sub SET nm_subkategori='$txtSubkategori', kd_kategori='$cmbkategori' 
						WHERE kd_subkategori ='".$_POST['txtKode']."'";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=DataSubKategori'>";
			}
			exit;
		}	
		
	} 
	
	
	$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT * FROM kategori_sub WHERE kd_subkategori='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);

		
		$dataKode		= $myData['kd_subkategori'];
		$dataSubkategori= isset($myData['nm_subkategori']) ?  $myData['nm_subkategori'] : $_POST['txtSubkategori'];
		$dataNama		= $myData['nm_subkategori'];
		$DataKategori	= isset($myData['kd_kategori']) ?  $myData['kd_kategori'] : $_POST['cmbkategori'];
} 
?>
<div class='hero-unit'><h2 align="left">Ubah Data Sub Kategori</h2>
</div>
<hr>
<form action="?page=EditSubKategori" method="post" name="frmedit">
<table class="table table-condensed" width="100%" style="margin-top:0px;"><tr>
	  <th colspan="3"></th>
	</tr><tr>
	  <td width="17%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="82%"><input name="textfield"  type="text" class="input-small" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr><tr>
	  <td><b>Nama Sub Kategori</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtSubkategori" type="text" value="<?php echo $dataSubkategori; ?>" size="80" maxlength="100" />
      <input name="txtNmLama" type="hidden" value="<?php echo $dataNama; ?>" /></td></tr><tr>
      <td><strong>Kategori </strong></td>
	  <td><b>:</b></td>
	  <td><select name="cmbkategori">
        <option value="BLANK"> </option>
        <?php
	  $mySql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($myData = mysql_fetch_array($myQry)) {
	  	if ($myData['kd_kategori']== $DataKategori) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$myData[kd_kategori]' $cek>$myData[nm_kategori]</option>";
	  }
	  $sqlData ="";
	  ?>
      </select></td>
    </tr><tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input name="btnUpdate" type="submit" class="btn btn-primary"  value=" Update " />
       </td>
    </tr>
</table>
</form>

