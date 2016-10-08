<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 220px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }    
</style>
<style>
			.divDemoBody  {
				width: 20%;
				margin-left: auto;
				margin-right: auto;
				margin-top: 100px;
				}
			.divDemoBody p {
				font-size: 18px;
				line-height: 120%;
				padding-top: 12px;
				}
			.divButton {
				padding-top: 12px;
				}
				
			$(document).ready(function() {
				$('#windowTitleDialog').bind('show', function () {
					document.getElementById ("xlInput").value = document.title;
					});
				});
			function closeDialog () {
				$('#windowTitleDialog').modal('hide'); 
				};
			function okClicked () {
				document.title = document.getElementById ("xlInput").value;
				closeDialog ();
				};
 </style>
	<div id="windowTitleDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Login</h2>
		</div>
		<div class="modal-body">
			<div class="divDialogElements">
			<form name="logForm" class="form-signin" method="post" action="?page=ValidasiLogin">
        	<input name="txtUser" type="text" class="input-block-level" placeholder="username">
        	<input name="txtPassword" type="password"  class="input-block-level" placeholder="Password">
        	<select name="cmbLevel">
			<option value="BLANK" >Pilih</option>
			<?php
				$pilihan = array("Kasir", "Admin");
				foreach ($pilihan as $nilai) {
				if ($_POST['cmbLevel']==$nilai) {
				$cek="selected";
				} else { $cek = ""; }
				echo "<option value='$nilai' $cek>$nilai</option>";
				}
			?>
			</select>
        	<button type="submit" name="btnLogin" value=" Login " class="btn btn-large btn-primary">Sign in</button>
     		</form>
			</div>
		</div>
		<div class="modal-footer">
	    </div>
		
	</div>
		
