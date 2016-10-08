<style>
			.divDemoBody  {
				width: 300px;
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
				$('#ShowLaporanPenjualan').bind('show', function () {
					document.getElementById ("xlInput").value = document.title;
					});
				});
			function closeDialog () {
				$('#ShowLaporanPenjualan').modal('hide'); 
				};
			function okClicked () {
				document.title = document.getElementById ("xlInput").value;
				closeDialog ();
				};
			
 </style>

<div id="ShowLaporanPenjualan"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Pilih Laporan Penjualan</h2>
	</div>
	<div class="modal-body">
		<ul class="thumbnails">
            <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanPenjualan.png"  class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanPenjualan" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanPenjualan" >Laporan Penjualan</a>
                  </h5>
                   Terdapat laporan penjualan di toko H.Ahmad Ridha menurut supplier
                </div>
              </div>
            </li>
            <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanPenjualanJenis.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanPenjualanJenis" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanPenjualanJenis" >Laporan Penjualan Dari Jenis Barang</a>
                  </h5>
                  Terdapat laporan penjualan menurut jenis barang
                </div>
              </div>
            </li>
            <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanPenjualanSupplier.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanPenjualanSupplier" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanPenjualanSupplier" >Laporan Penjualan Dari Supplier</a>
                  </h5>
                  Terdapat laporan penjualan menurut supplier
                </div>
              </div>
            </li>
       
           <li class="span3 clearfix">
           		<div class="thumbnail clearfix">
                <img src="images/Laporan Belanja.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanLabaRugi" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanLabaRugi" >Laporan Laba Rugi</a>
                  </h5>
                  Terdapat laporan Laba rugi di toko H.Ahmad Ridha menurut supplier
                </div>
              </div>
           </li>
           <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanPenjualanTanggal.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanPenjualanTanggal" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanPenjualanTanggal" >Laporan Penjualan Pertanggal</a>
                  </h5>
                  Terdapat laporan penjualan dari Jenis barang di toko H.Ahmad Ridha menurut supplier
                </div>
              </div>
            </li>
            <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanPenjualanPeriode.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanPenjualanPeriode" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanPenjualanPeriode" >Laporan Penjualan Perperiode</a>
                  </h5>
                  Terdapat laporan penjualan dari Jenis barang di toko H.Ahmad Ridha menurut supplier
                </div>
              </div>
            </li>
       </ul>
	</div>
	<div class="modal-footer">
		
	</div>		
</div>