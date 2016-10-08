<?php 
if($_GET) { 
	if(isset($_POST['btnLogin'])){
		$pesanError = array();
		if ( trim($_POST['txtUser'])=="") {
			$pesanError[] = "<b> User ID </b>  tidak boleh kosong !";
					
		}
		if (trim($_POST['txtPassword'])=="") {
			$pesanError[] = " <b> Password </b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbLevel'])=="BLANK") {
			$pesanError[] = " <b>Level</b> belum dipilih !";		
		}
		
		
		$txtUser 	= $_POST['txtUser'];
		$txtUser 	= str_replace("'","&acute;",$txtUser);
		
		$txtPassword=$_POST['txtPassword'];
		$txtPassword= str_replace("'","&acute;",$txtPassword);
		
		$cmbLevel	=$_POST['cmbLevel'];
		
		
		if (count($pesanError)>=1 ){
			echo"<br />";
            echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button>
				<strong>PERINGATAN !</strong>";
				
				$noPesan=0;
				foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
					echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
				} 
			echo "</div> <br>"; 
			
			
			include "source/pagelogin.php";
		}
		else {
			
			$Sql = "SELECT * FROM user WHERE username='".$txtUser."' 
						AND password='".md5($txtPassword)."' AND level='$cmbLevel'";
			$Qry = mysql_query($Sql, $koneksidb)  
						or die ("Query Salah : ".mysql_error());

			
			if($Qry){
				if (mysql_num_rows($Qry) >=1) {
					$Data = mysql_fetch_array($Qry);
					$_SESSION['SES_LOGIN'] = $Data['kd_user']; 
					$_SESSION['SES_USER'] = $Data['username']; 
					
					
					if($cmbLevel=="Admin") {
						$_SESSION['SES_ADMIN'] = "Admin";
					}
					
					
					if($cmbLevel=="Kasir") {
						$_SESSION['SES_KASIR'] = "Kasir";
					}
					
					
					echo "<meta http-equiv='refresh' content='0; url=?page=HalamanUtama'>";
				}
				else {
					 echo "<br />";					
					 echo "<div class='alert fade in'>
					 <button type='button' class='close' data-dismiss='alert'>&times;</button>";
					 echo "Login Anda bukan ".$_POST['cmbLevel'];
					 echo "</div>";
					 include "source/pagelogin.php";
				}
			}
		}
	}
}
?>
 
