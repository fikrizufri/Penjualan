<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

date_default_timezone_set("Asia/Makassar");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Toko Puspita</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content=""> 
    <link href="images/Fiki logo.ico" rel="icon" >    
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

</head>
	<body>
     
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">        	
		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
           <a class="brand" href="index.php"><img src="images/logo.png"/></a>  
          <?php include "source/menu.php"; ?>
        </div>
      </div>
    </div>
    
    <div class="container">   
     <div class="row">
        <div class="span12">
          <?php include "source/buka_file.php"; ?>
        </div>  
      </div>
	       
      <hr>
      <footer >
        Web by <a href="hhttp://www.twitter.com/thisisahell">Anhar Safta</a></p>
      </footer>
      
	</div>
    
    
  </body>
</html>
