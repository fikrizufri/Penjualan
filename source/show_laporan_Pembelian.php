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
				$('#ShowLaporanPembelian').bind('show', function () {
					document.getElementById ("xlInput").value = document.title;
					});
				});
			function closeDialog () {
				$('#ShowLaporanPembelian').modal('hide'); 
				};
			function okClicked () {
				document.title = document.getElementById ("xlInput").value;
				closeDialog ();
				};
			
 </style>

<div id="ShowLaporanPembelian"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Pilih Laporan Barang</h2>
	</div>
	<div class="modal-body">
		<ul class="thumbnails">
            <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanPembelian.png"  class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanPembelian" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanPembelian" >Laporan Pembelian</a>
                  </h5>
                   Terdapat laporan penjualan dari Jenis barang di toko H.Ahmad Ridha menurut supplier
                </div>
              </div>
            </li>
            
            <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanPembelianPeriode.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanPembelianPeriode" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanPembelianPeriode" >Laporan Pembelian Perperiode</a>
                  </h5>
                  Terdapat laporan Pembelian dari Jenis barang di toko H.Ahmad Ridha menurut supplier
                </div>
              </div>
            </li>
            <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanRetur.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanRetur" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanRetur" >Laporan Retur</a>
                  </h5>
                  Terdapat laporan Retur di toko H.Ahmad Ridha menurut supplier
                </div>
              </div>
            </li>
            <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanRetur.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanPengembalianBarang" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanPengembalianBarang" >Laporan Pengembalian Barang</a>
                  </h5>
                  Terdapat Laporan Retur Dari Suppiler di toko H.Ahmad Ridha menurut supplier
                </div>
              </div>
            </li>
       </ul>
       
	</div>
	<div class="modal-footer">
		
	</div>		
</div>