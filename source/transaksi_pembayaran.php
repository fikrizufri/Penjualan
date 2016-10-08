<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include "pembayaran_list.php";


$filterSQL 	= "";


if(isset($_POST['btnSave'])){
	$pesanError = array();
	if (trim($_POST['cmbSupplier'])=="BLANK") {
		$pesanError[] = "Data <b> Nama supplier</b> belum diisi, pilih pada combo !";		
	}
	if (trim($_POST['cmbSupplier']) != trim($_POST['txtSupplierHitung'])) {
		$pesanError[] = "Data <b> Nama supplier sudah diganti</b>, klik tombol <b> Hitung</b> lagi !";		
	}
	if (trim($_POST['cmbTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada combo !";		
	}
	if (trim($_POST['txtTotBayar'])=="") {
		$pesanError[] = "Data <b>Total Pembayaran (Rp)</b> belum terbaca, lakukan filter supplier dan Tanggal Transaksi, lalu klik <b>Hitung</b> !";		
	}
	
	
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$cmbTanggal 	= $_POST['cmbTanggal'];
	$cmbTglStart 	= $_POST['cmbTglStart'];
	$cmbTglEnd 		= $_POST['cmbTglEnd'];
	$txtTotBayar 	= $_POST['txtTotBayar'];
			
	
	if (count($pesanError)>=1 ){
		echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		
		$noTransaksi = buatKode("pembayaran", "PB");
		$mySql	= "INSERT INTO pembayaran SET 
						no_pembayaran='$noTransaksi', 
						tgl_pembayaran='".InggrisTgl($_POST['cmbTanggal'])."', 
						kd_supplier='$cmbSupplier', 
						tgl_periode_start='".InggrisTgl($_POST['cmbTglStart'])."', 
						tgl_periode_end='".InggrisTgl($_POST['cmbTglEnd'])."', 
						total_bayar='$txtTotBayar', 
						keterangan='$txtKeterangan', 
						kd_user='".$_SESSION['SES_LOGIN']."'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){			
			
			echo "<script>";
			echo "window.open('source/transaksi_pembayaran_cetak.php?noBayar=$noTransaksi', width='900',height=330, left=0)";
			echo "</script>";
		}
	}	
}



if (isset($_POST['btnHitung'])) {
	$pesanError = array();
	if (trim($_POST['cmbSupplier'])=="BLANK") {
		$pesanError[] = "Data <b> Nama supplier</b> belum diisi, pilih pada combo !";		
	}

	
	if (count($pesanError)>=1 ){
		echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
		
		$filterSQL 	= "";
	}
	else {
		if ($_POST['cmbSupplier']=="ALL") {
			
			$filterSQL 	= "";
		}
		else {
			
			$filterSQL 	= "P.kd_supplier ='".$_POST['cmbSupplier']."' AND ";
		}
	}
}
else {
	if($_POST) {
		if($_POST['cmbSupplier']=="ALL") {
			
			$filterSQL 	= "";
		}
		else {
			
			$filterSQL 	= "P.kd_supplier ='".$_POST['cmbSupplier']."' AND ";
		}
	}
}



$tglStart 	= isset($_POST['cmbTglStart']) ? $_POST['cmbTglStart'] : "01-".date('m-Y');
$tglEnd 	= isset($_POST['cmbTglEnd']) ? $_POST['cmbTglEnd'] : date('d-m-Y');


$SqlPeriode = $filterSQL." ( P.tgl_Pembelian BETWEEN '".InggrisTgl($tglStart)."' AND '".InggrisTgl($tglEnd)."')";


$totSql = "SELECT PI.harga_beli * PI.jumlah As subTotal
	 FROM Pembelian As P, Pembelian_detail As PI
	 WHERE P.no_Pembelian = PI.no_Pembelian AND $SqlPeriode";
$totQry = mysql_query($totSql, $koneksidb) or die ("Error Query".mysql_error()); 
$jumlahBayar = 0;
while($totRow = mysql_fetch_array($totQry)) {
	$jumlahBayar = $jumlahBayar + $totRow['subTotal'];
}


$noTransaksi 	= buatKode("pembayaran", "PB");
$tglTransaksi 	= isset($_POST['cmbTanggal']) ? $_POST['cmbTanggal'] : date('d-m-Y');
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
?>
<div class='hero-unit'><h2 align="left">Transaksi Pembayaran</h2>
</div>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="frmadd">
<table width="700" cellspacing="1" class="table-common" style="margin-top:0px;">
	
	<tr>
	  <td width="35%"><h4>DATA TRANSAKSI </h4></td>
	  <td >&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td width="24%"><b>No. Pembayaran </b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="75%" ><input type="text" name="txtNomor" value="<?php echo $noTransaksi; ?>" /></td></tr>
	<tr>
      <td><b>Tgl.  Pembayaran </b></td>
	  <td><b>:</b></td>
	  <td class="datepicker"><input type="text" name="cmbTanggal" value="<?php echo $tglTransaksi; ?>" id="dp1"  /></td>
    </tr>
	<tr>
      <td><b>Supplier</b></td>
	  <td><b>:</b></td>
	  <td>
        <select name="cmbSupplier">
          <option value="BLANK">....</option>
          <?php
	  $mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($kolomData = mysql_fetch_array($myQry)) {
	  	if ($dataSupplier == $kolomData['kd_supplier']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$kolomData[kd_supplier]' $cek>[ $kolomData[kd_supplier] ] $kolomData[nm_supplier]</option>";
	  }
	  $mySql ="";
	  ?>
        </select>
	    <strong>
	    <input class="input-small" name="txtSupplierHitung" type="hidden" value="<?php echo $dataSupplier; ?>" />
      </strong>* <a data-toggle="modal" href="#ShowBayar">Lihat Daftar Pembayaran </a></td>
    </tr>
	<tr>
	  <td><b>Periode Pembelian </b></td>
	  <td><b>:</b></td>
	  <td class="input-append" ><input type="text" class="datepicker" name="cmbTglStart" id="dp2" value="<?php echo $tglStart; ?>" />
        <i class="add-on">s/d</i>
  <input name="cmbTglEnd" type="text" class="datepicker" id="dp3" id="cmbTglEnd" value="<?php echo $tglEnd; ?>" /></td>
    </tr>
	<tr>
      <td><strong>Keterangan</strong></td>
	  <td><b>:</b></td>
	  <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
      <td>&nbsp;</td>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input name="btnHitung" type="submit" style="cursor:pointer;" value=" Hitung " class="btn btn-small btn-primary" /></td>
    </tr>
    </table>
    <hr />
    <table>
	<tr>
	  <td ><b>PEMBAYARAN</b></td>
	  <td >&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>Total Pembayaran (Rp.)</strong></td>
	  <td><b>:</b></td>
	  <td><strong><?php echo format_angka($jumlahBayar); ?>
	    <input name="txtTotBayar" type="hidden" value="<?php echo $jumlahBayar; ?>" />
	  </strong></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><a href="pencarian_barang.php" target="_blank"></a></td>
    </tr>
	<tr>
	  <td><input name="btnSave" type="submit" style="cursor:pointer;" value=" SIMPAN PEMBAYARAN  " class="btn btn-small btn-primary" /></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
</table>
<hr>
<table class="table table-condensed" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th colspan="7">DAFTAR BARANG MASUK </th>
    </tr>
  <tr>
    <td width="32" align="center" ><b>No</b></td>
    <td width="78" align="center" ><strong>Tgl. Masuk</strong> </td>
    <td width="70" align="center" ><b>Kode</b></td>
    <td width="379" ><b>Nama Barang</b></td>
    <td width="82" align="right" ><strong>Harga(Rp)</strong> </td>
    <td width="38" align="center" ><b>Jumlah</b></td>
    <td width="85" align="right" ><strong>Subtotal(Rp)</strong></td>
  </tr>
  <?php
	$dataSql = "SELECT P.tgl_Pembelian, PI.*, barang.kd_barang, barang.nm_panjang, Jenis.nm_Jenis 
		 FROM barang, Jenis, Pembelian As P, Pembelian_detail As PI
		 WHERE barang.kd_barang = PI.kd_barang AND barang.kd_Jenis=Jenis.kd_Jenis
		 AND P.no_Pembelian = PI.no_Pembelian AND $SqlPeriode
		 ORDER BY P.tgl_Pembelian, PI.kd_barang ASC";
	$dataQry = mysql_query($dataSql, $koneksidb) or die ("Error Query".mysql_error());
	$nomor = 0; $subSotal = 0; $totalBayar = 0;
	while ($dataRow = mysql_fetch_array($dataQry)) {
		$nomor++;
		$subSotal 	= $dataRow['harga_beli'] * $dataRow['jumlah'];
		$totalBayar	= $totalBayar + $subSotal;

		
		
	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><strong><?php echo IndonesiaTgl($dataRow['tgl_Pembelian']); ?></strong></td>
    <td align="center"><?php echo $dataRow['kd_barang']; ?></td>
    <td><?php echo $dataRow['nm_panjang']; ?></td>
    <td align="right"><?php echo format_angka($dataRow['harga_beli']); ?></td>
    <td align="center"><?php echo $dataRow['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subSotal); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="6" align="right" ><p class="text-right"><strong>Gran Total (Rp) :</strong></p></td>
    <td align="right" ><strong><?php echo format_angka($totalBayar); ?></strong></td>
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