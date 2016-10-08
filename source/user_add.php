<?php
include_once "library/inc.seslogin.php";

if($_GET) {
	if(isset($_POST['btnSave'])){
		
		$pesanError = array();
		if (trim($_POST['txtNamaUser'])=="") {
			$pesanError[] = "Data <b>Nama User</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtTelpon'])=="") {
			$pesanError[] = "Data <b>Telpon</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtUsername'])=="") {
			$pesanError[] = "Data <b>Username</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtPassword'])=="") {
			$pesanError[] = "Data <b>Password</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbLevel'])=="BLANK") {
			$pesanError[] = "Data <b>Level login</b> belum dipilih !";		
		}
				
				
		
		$txtNamaUser= $_POST['txtNamaUser'];
		$txtUsername= $_POST['txtUsername'];
		$txtPassword= $_POST['txtPassword'];
		$txtTelpon	= $_POST['txtTelpon'];
		$cmbLevel	= $_POST['cmbLevel'];
		
		
		$cekSql="SELECT * FROM user WHERE nm_user='$txtNamaUser'";
		$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($cekQry)>=1){
			$pesanError[] = "Maaf, user <b> $txtNamaUser </b> sudah ada, ganti dengan yang lain";
		}

		
		if (count($pesanError)>=1 ){
           echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button><strong>Peringatan</strong><p>";
				$noPesan=0;
				foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
					echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
				} 
			echo "</div> <br>"; 
			include_once "user_data.php";
		}
		else {
			
			$kodeBaru	= buatKode("user", "U");
			$mySql  	= "INSERT INTO user (kd_user, nm_user, no_telepon, 
											 username, password, level)
							VALUES ('$kodeBaru', 
									'$txtNamaUser', 
									'$txtTelpon', 
									'$txtUsername', 
									'$txtPassword', 
									'$cmbLevel')";
			$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=DataUser'>";
			}
			exit;
		}	
	} 
	
	$dataKode	= buatKode("user", "U");
	$dataNamaUser	= isset($_POST['txtNamaUser']) ? $_POST['txtNamaUser'] : '';
	$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
	$dataPassword	= isset($_POST['txtPassword']) ? $_POST['txtPassword'] : '';
	$dataTelpon	= isset($_POST['txtTelpon']) ? $_POST['txtTelpon'] : '';
	$dataLevel	= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : '';
} 
?>
<div id="windowTitleDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading" id="myModalLabel">Tambah Daftar User</h2>
	</div>
	<div class="modal-body">
<form action="?page=TambahUser" method="post" name="form1" target="_self">
  <table width="350" class="" border="0" cellspacing="1" cellpadding="4"><tr>
      <td width="35%"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="937"> 
      <input class="span1" type="text" name="textfield" type="text" value="<?php echo $dataKode; ?>" readonly="readonly"/>
      </td>
    </tr><tr>
      <td><b>Nama Lengkap </b></td>
      <td><b>:</b></td>
      <td>
      <input class="span13 " type="text" name="txtNamaUser" type="text" value="<?php echo $dataNamaUser; ?>" />
      </td>
    </tr><tr>
      <td><b>No. Telepon </b></td>
      <td><b>:</b></td>
      <td><input class="span2" type="text" name="txtTelpon" type="text" value="<?php echo $dataTelpon; ?>"/></td>
    </tr><tr>
      <td><b>Username</b></td>
      <td><b>:</b></td>
      <td> <input  type="text" class="input-medium"  name="txtUsername"   value="<?php echo $dataUsername; ?>"/></td>
    </tr><tr>
      <td><b>Password</b></td>
      <td><b>:</b></td>
      <td><input class="span2" name="txtPassword" type="password" value="<?php echo $dataPassword; ?>" size="60" maxlength="100" /></td>
    </tr><tr>
      <td><b>Level</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbLevel">
          <option value="BLANK">....</option>
          <?php
		  $pilihan	= array("Kasir", "Admin");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    
  </table>

</div>
	<div class="modal-footer">
    	<button class="btn btn-primary" type="submit" name="btnSave">Simpan</button>
	</div>
	</form>
</div>