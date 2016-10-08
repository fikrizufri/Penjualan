<?php
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pembayaran";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<style>
			.divDemoBody  {
				width: 60%;
				margin-left: auto;
				margin-right: auto;
				margin-top: 100px;
				}
			.divDemoBody p {
				font-size: 18px;
				line-height: 140%;
				padding-top: 12px;
				}
			.divButton {
				padding-top: 12px;
				}
				
			$(document).ready(function() {
				$('#ShowModal').bind('show', function () {
					document.getElementById ("xlInput").value = document.title;
					});
				});
			function closeDialog () {
				$('#ShowModal').modal('hide'); 
				};
			function okClicked () {
				document.title = document.getElementById ("xlInput").value;
				closeDialog ();
				};
 </style>

<div id="ShowBayar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Daftar Transaksi Pembayaran</h2>
	</div>
	<div class="modal-body">
<table class="table table-condensed" width="750" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="31" align="center"><b>No</b></th>
    <th width="85" align="center"><b>No. Bayar </b></th>
    <th width="85">Tgl. Bayar </th>
    <th width="169"><b>Tgl. Periode </b></th>
    <th width="168">Supplier</th>
    <th width="95" align="right"> Bayar (Rp) </th>
    <td width="42" align="center" ><b>Delete</b></td>
    <td width="34" align="center" ><strong>View</strong></td>
  </tr>
  <?php
	  // Menampilkan daftar pembayaran
	$mySql = "SELECT pembayaran.*, supplier.nm_supplier FROM pembayaran, supplier 
				WHERE pembayaran.kd_supplier=supplier.kd_supplier 
				ORDER BY pembayaran.no_pembayaran DESC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = $hal; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$noBayar = $kolomData['no_pembayaran'];
		
		// gradasi warna
		
	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo $kolomData['no_pembayaran']; ?></td>
    <td><?php echo IndonesiaTgl($kolomData['tgl_pembayaran']); ?></td>
    <td><?php echo IndonesiaTgl($kolomData['tgl_periode_start']); ?> <b>s/d</b> <?php echo IndonesiaTgl($kolomData['tgl_periode_end']); ?></td>
    <td><?php echo $kolomData['nm_supplier']; ?></td>
    <td align="right"><?php echo format_angka($kolomData['total_bayar']); ?></td>
    <td align="center"><a href="?page=DeletePembelian&amp;noBayar=<?php echo $noBayar; ?>" target="_self" alt="Delete Data" onClick="return confirm('nda yakin menghapus <?php echo $kolomData['no_pembayaran']; ?> ... ?')"> <i class="icon-trash"></i></a></td>
    <td align="center"><a href="#" onClick="javascript:window.open('source/transaksi_pembayaran_cetak.php?noBayar=<?php echo $noBayar; ?>', width='900',height=330, left=0)" ><i class="icon-print"></i></a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" align="left" ><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="5" align="right" ><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
</div>
			<div class="modal-footer">
			<a href="?page=PagePembayaran" target="_blank" >
			<button class="btn btn-primary" name="btnSave">Lihat Selengkapnya</button>
			</a>
			</div>
		</form>
</div>
	