<?php
include_once "library/inc.seslogin.php";


if(isset($_POST['btnTambah'])){
	$pesanError = array();
	if (trim($_POST['txtKodeBarcode'])=="") {
		$pesanError[] = "Data <b>Kode Barang / Barcode belum diisi</b>, ketik secara manual atau dari <b>Barcode Reader</b> !";		
	}
	if (trim($_POST['txtJumlah'])=="" OR ! is_numeric(trim($_POST['txtJumlah']))) {
		$pesanError[] = "Data <b>Jumlah Barang (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	
	
	$txtKodeBarcode	= $_POST['txtKodeBarcode'];
	$txtKodeBarcode	= str_replace("'","&acute;",$txtKodeBarcode);
	$txtJumlah	= $_POST['txtJumlah'];

	
	$cekSql	= "SELECT stok_opname FROM barang WHERE kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
	$cekRow = mysql_fetch_array($cekQry);
	if ($cekRow['stok_opname'] < $txtJumlah) {
		$pesanError[] = "Stok Barang untuk kode <b>$txtKodeBarcode</b> adalah <b> $cekRow[stok_opname]</b>, tidak dapat dijual!";
	}
			
	
	if (count($pesanError)>=1 ){
		echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>x</button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
			
		$cekSql ="SELECT * FROM tmp_penjualan As tmp, barang
				  WHERE barang.kd_barang=tmp.kd_barang AND ( barang.kd_barang='$txtKodeBarcode' OR barang.barcode='$txtKodeBarcode' )
				  AND tmp.kd_user='".$_SESSION['SES_LOGIN']."'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			
			$cekRow = mysql_fetch_array($cekQry);
			$kodeBarang	= $cekRow['kd_barang'];

			
			$tmpSql = "UPDATE tmp_penjualan SET jumlah=jumlah + $txtJumlah 
						WHERE kd_barang='$kodeBarang' AND kd_user='".$_SESSION['SES_LOGIN']."'";
			mysql_query($tmpSql, $koneksidb) or die ("Gagal Query : ".mysql_error());
		}
		else {
			
			$mySql ="SELECT * FROM barang WHERE kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode'";
			$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
			$myRow = mysql_fetch_array($myQry);
			if (mysql_num_rows($myQry) >= 1) {
				
				$kodeBarang	= $myRow['kd_barang'];
				
				
				$tmpSql 	= "INSERT INTO tmp_penjualan (kd_barang, jumlah, kd_user) 
							VALUES ('$kodeBarang', '$txtJumlah','".$_SESSION['SES_LOGIN']."')";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
			}
		}
	}

}

if(isset($_POST['btnSave'])){
	$pesanError = array();
	if (trim($_POST['cmbTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal transaksi</b> belum diisi, pilih pada combo !";		
	}
	if (trim($_POST['txtUangBayar'])==""  OR ! is_numeric(trim($_POST['txtUangBayar']))) {
		$pesanError[] = "Data <b> Uang Bayar</b> belum diisi, isi dengan uang (Rp) !";		
	}
	if (trim($_POST['txtUangBayar']) < trim($_POST['txtTotBayar'])) {
		$pesanError[] = "Data <b> Uang Bayar Belum Cukup</b>.  
						 Total belanja adalah <b> Rp. ".format_angka($_POST['txtTotBayar'])."</b>";		
	}
	
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_penjualan WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpRow = mysql_fetch_array($tmpQry);
	if ($tmpRow['qty'] < 1) {
		$pesanError[] = "Maaf, <b>Daftar Barang </b> belum ada yang dimasukan, <b>minimal 1 Barang</b>.";
	}
	

	$txtPelanggan	= $_POST['txtPelanggan'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtUangBayar	= $_POST['txtUangBayar'];
	$cmbTanggal 	= $_POST['cmbTanggal'];
	$txtDiskon	 	= $_POST['txtDiskon'];
			
			
	if (count($pesanError)>=1 ){
		echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>x</button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		$noTransaksi = buatKode("penjualan", "JL");
		$mySql	= "INSERT INTO penjualan SET 
						no_penjualan='$noTransaksi', 
						tgl_penjualan='".InggrisTgl($_POST['cmbTanggal'])."', 
						pelanggan='$txtPelanggan', 
						keterangan='$txtKeterangan', 
						uang_bayar='$txtUangBayar',
						kd_user='".$_SESSION['SES_LOGIN']."'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		if($myQry){
			$tmpSql ="SELECT barang.*, tmp_penjualan.jumlah 
						FROM barang, tmp_penjualan
						WHERE barang.kd_barang=tmp_penjualan.kd_barang 
						AND tmp_penjualan.kd_user='".$_SESSION['SES_LOGIN']."'";
			$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			while ($tmpRow = mysql_fetch_array($tmpQry)) {
				$dataKode 	= $tmpRow['kd_barang'];
				$dataHarga	= $tmpRow['harga_jual'];
				$dataDiskon	= $tmpRow['diskon'];
				$dataJumlah	= $tmpRow['jumlah'];
				
				$itemSql = "INSERT INTO penjualan_detail SET 
										no_penjualan='$noTransaksi', 
										kd_barang='$dataKode', 
										harga_jual='$dataHarga', 
										diskon_jual='$txtDiskon', 
										jumlah='$dataJumlah'";
				mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
				
				$stokSql = "UPDATE barang SET stok = stok - $dataJumlah, 
												   stok_opname = stok_opname - $dataJumlah
							WHERE kd_barang='$dataKode'";
				mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
			}
			
			$hapusSql = "DELETE FROM tmp_penjualan WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
			mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
			
			echo "";
			echo "<script>";
			echo "window.open('source/transaksi_penjualan_nota.php?noNota=$noTransaksi', width=330,height=330,left=100, top=25)";
			echo "</script>";
			

		}
		else{
			$pesanError[] = "Gagal penyimpanan ke database"; 
		}
	}	
}
	
$noTransaksi 	= buatKode("penjualan", "JL");
$tglTransaksi 	= isset($_POST['cmbTanggal']) ? $_POST['cmbTanggal'] : date('d-m-Y');
$dataPelanggan	= isset($_POST['txtPelanggan']) ? $_POST['txtPelanggan'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataUangBayar	= isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';



?>
<div class='hero-unit'><h2 align="left">Transaksi Penjualan</h2>
</div>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="frmadd">
<table width="43%" >
	<tr>
	  <td width="50%"><h3>DATA TRANSAKSI</h3></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td ><b>No Penjualan </b></td>
	  <td ><b>:</b></td>
	  <td><input type="text" class="input-medium" name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/></td>
	</tr>
	<tr>
      <td><b>Tanggal Transaksi </b></td>
	  <td><b>:</b></td>
	  <td class="datepicker"><input  type="text" name="cmbTanggal" value="<?php echo $tglTransaksi; ?>" id="dp2" /></td>
    </tr>
	<tr>
      <td><b>Pelanggan</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtPelanggan"  type="text" class="input-small"  placeholder="Pelanggan"
      		 	 onfocus="if (value == 'Pelanggan') {value =''}" 
	  			 onBlur="if (value == '') {value = 'Pelanggan'}" value="<?php echo $dataPelanggan; ?>" /> 
      </td>
    </tr>
	<tr>
      <td><strong>Keterangan</strong></td>
	  <td><b>:</b></td>
	  <td><input  type="text" class="input-small" name="txtKeterangan" value=""
      onblur="if (value == '') {value = '<?php echo $dataKeterangan; ?>'}" 
					onfocus="if (value == '<?php echo $dataKeterangan; ?>') {value =''}" /></td>
    </tr>
	</table>
    <hr>
    <table>
	<tr>
	  <td width="50%"><h3>INPUT BARANG </h3></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>Kode Barang / Barcode</strong></td>
	  <td><b>:</b></td>
	  <td><input  type="text" class="input-small" name="txtKodeBarcode" size="35" maxlength="20" /></td>
    </tr>
    <tr>
	   <td><b>Jumlah</b></td>
       <td><b>:</b></td>
       <td><input type="text" class="input-mini" class="angkaC" name="txtJumlah" size="3" maxlength="4" value="1" 
                   onblur="if (value == '') {value = '1'}" 
                   onfocus="if (value == '1') {value =''}"/>
      </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><b>
	    <input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " class="btn btn-small btn-primary" />
	  </b></td>
    </tr>
</table>
<hr>
<table class="table table-condensed" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th colspan="8">DAFTAR PENJUALAN  </th>
    </tr>
  <tr>
    <td width="29" align="center"><b>No</b></td>
    <td width="85" align="center"><b>Kode</b></td>
    <td width="432"><b>Nama Barang </b></td>
    <td width="85" align="right"><b>Harga(Rp) </b></td>
    <td width="58" align="center"></td>
    <td width="48" align="center"><b>Jumlah</b></td>
    <td width="100" align="right"><b>Subtotal(Rp) </b></td>
    <td width="22" align="center">&nbsp;</td>
  </tr>
<?php

$tmpSql ="SELECT barang.*, tmp_penjualan.id, tmp_penjualan.jumlah 
		FROM barang, tmp_penjualan
		WHERE barang.kd_barang=tmp_penjualan.kd_barang 
		AND tmp_penjualan.kd_user='".$_SESSION['SES_LOGIN']."'
		ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0; $hargaDiskon=0; $totalBayar = 0; $qtyItem = 0;  $dataDiskonJual = 0;
while($tmpRow = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$id			= $tmpRow['id'];
	$hargaDiskon= $tmpRow['harga_jual'] - ( $tmpRow['harga_jual'] * $tmpRow['diskon'] / 100 );
	$subSotal 	= $tmpRow['jumlah'] * $hargaDiskon;
	$totalBayar	= $totalBayar + $subSotal;
	$totalKesulurhan = $totalBayar - ($totalBayar * $dataDiskonJual / 100);
	$qtyItem	= $qtyItem + $tmpRow['jumlah'];
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><b><?php echo $tmpRow['kd_barang']; ?></b></td>
    <td><?php echo $tmpRow['nm_panjang']; ?></td>
    <td align="right"><?php echo format_angka($tmpRow['harga_jual']); ?></td>
    <td align="center"></td>
    <td align="center"><?php echo $tmpRow['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subSotal); ?></td>
    <td align="center" ><a href="?page=DeletePenjualan&amp;id=<?php echo $id; ?>" target="_self" alt="Delete" onclick="return confirm('Anda yakin menghapus <?php echo  $tmpRow['nm_panjang']; ?> ... ?')"><i class="icon-trash"></i></a></td>
  </tr>
<?php 
}?>
  <tr>
    <td colspan="5" ><p class="text-right"><b>Diskon (%) : </b></p></td>
    <td align="center" >&nbsp;</td>
    <td align="right" ><input  name="txtDiskon" value="" type="text" class="input-small" /></td>
    <td align="center" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><p class="text-right"><b>Total Bayar (Rp.) : </b></p></td>
    <td align="center" ><b><?php echo $qtyItem; ?></b></td>
    <td align="right" ><b><?php echo format_angka($totalBayar); ?></b></td>
    <td align="center" >&nbsp;</td>
  </tr>
   
  <tr>
    <td colspan="5" ><p class="text-right"><b>Uang  Bayar (Rp.) : </b></p></td>
    <td align="center" >&nbsp;</td>
    <td align="right" ><input  name="txtUangBayar" value="" type="text"
					onblur="if (value == '') {value = '<?php echo $dataUangBayar; ?>'}" 
					onfocus="if (value == '<?php echo $dataUangBayar; ?>') {value =''}"/></td>
    <td align="center" >&nbsp;</td>
  </tr>
 
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right"><input name="txtTotBayar" type="hidden" value="<?php echo $totalBayar; ?>" /></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" ><p class="text-right"><input name="btnSave" type="submit" style="cursor:pointer;" value=" SIMPAN PEMBAYARAN  " class="btn btn-small btn-primary" /></p></td>
    
  </tr>
  <tr>
    <td colspan="7">[ <a href="?page=PencarianBarang" target="_blank">Cari Barang </a> ] [ <a data-toggle="modal" href="#showPenjualan">Daftar Transaksi</a> ] </td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</form>
<script>
$(function(){
			window.prettyPrint && prettyPrint();
			$('#dp1').datepicker({
				format: 'dd-mm-yyyy',
                todayBtn: 'linked',
				
			});
            
			$('#dp2').datepicker({
				format: 'dd-mm-yyyy',
                todayBtn: 'linked',
				
			});            
            
			$('#dp3').datepicker({
			format: 'dd-mm-yyyy',
                todayBtn: 'linked',
				
			});    
			$('#dp4').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('The start date can not be greater then the end date');
					} else {
						$('#alert').hide();
						startDate = new Date(ev.date);
						$('#startDate').text($('#dp4').data('date'));
					}
					$('#dp4').datepicker('hide');
				});
			$('#dp5').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() < startDate.valueOf()){
						$('#alert').show().find('strong').text('The end date can not be less then the start date');
					} else {
						$('#alert').hide();
						endDate = new Date(ev.date);
						$('#endDate').text($('#dp5').data('date'));
					}
					$('#dp5').datepicker('hide');
				});
                
            //inline    
            $('#dp6').datepicker({
                todayBtn: 'linked'
            });
                
            $('#btn6').click(function(){
                $('#dp6').datepicker('update', '15-05-1984');
            });            
            
            $('#btn7').click(function(){
                $('#dp6').data('datepicker').date = null;
                $('#dp6').find('.active').removeClass('active');                
            });            
		});

</script>