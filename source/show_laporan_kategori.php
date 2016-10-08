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
				$('#ShowLaporanKategori').bind('show', function () {
					document.getElementById ("xlInput").value = document.title;
					});
				});
			function closeDialog () {
				$('#ShowLaporanKategori').modal('hide'); 
				};
			function okClicked () {
				document.title = document.getElementById ("xlInput").value;
				closeDialog ();
				};
			
 </style>

<div id="ShowLaporanKategori"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Pilih Laporan Kategori</h2>
	</div>
	<div class="modal-body">
		<ul class="thumbnails">
            <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanKategori.png"  class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanKategori" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanKategori" >Laporan Kategori</a>
                  </h5>
                  Terdapat laporan barang-barang di toko H.Ahmad Ridha
                </div>
              </div>
            </li>
            
             <li class="span3 clearfix">
              <div class="thumbnail clearfix">
                <img src="images/LaporanKategoriSub.png" class="pull-left" style='margin-right:10px'>
                <div class="caption" class="pull-left">
                  <a href="?page=LaporanKategoriSub" class="btn btn-primary icon  pull-right">Lihat</a>
                  <h5>      
                  <a href="?page=LaporanKategoriSub" >Laporan Kategori Sub</a>
                  </h5>
                  Terdapat laporan barang-barang di toko H.Ahmad Ridha menurut supplier
                </div>
              </div>
            </li>
            
       </ul>
       
	</div>
	<div class="modal-footer">
		
	</div>		
</div>