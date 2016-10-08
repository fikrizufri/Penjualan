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
				$('#ShowLaporanBarang').bind('show', function () {
					document.getElementById ("xlInput").value = document.title;
					});
				});
			function closeDialog () {
				$('#ShowLaporanBarang').modal('hide'); 
				};
			function okClicked () {
				document.title = document.getElementById ("xlInput").value;
				closeDialog ();
				};
			
 </style>

<div id="ShowLaporanBarang"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Pilih Laporan Barang</h2>
	</div>
	<div class="modal-body">
		<ul class="thumbnails">
            <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanBarang.png"  class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanBarang" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanBarang" >Laporan Barang</a>
                  </h5>
                  Terdapat laporan barang-barang di toko H.Ahmad Ridha
                </div>
              </div>
            </li>
            
             <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanBarangSupplier.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanBarangBySupplier" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanBarangBySupplier" >Laporan Barang Dari Supplier</a>
                  </h5>
                  Terdapat laporan barang-barang di toko H.Ahmad Ridha menurut supplier
                </div>
              </div>
            </li>
            
       </ul>
       <ul class="thumbnails">
           <li class="span2"
               </li>
            <li class="span3 clearfix" class="text-right">
              <div class="thumbnail clearfix">
                <img src="images/LaporanBarangKategori.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanBarangByKategori" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanBarangByKategori" >Laporan Barang Dari Kategori</a>
                  </h5>
                   Terdapat laporan barang-barang di toko H.Ahmad Ridha menurut kategori               
                </div>
              </div>
           
             </li>
             </p>
            
       </ul>
	</div>
	<div class="modal-footer">
		
	</div>		
</div>