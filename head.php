
<?php
require ("rintera-config.php");
require ("components.php");








    include("seguridad.php");   
    MiToken_CloseALL($RinteraUser);



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo Preference("RinteraName","","")." ".Preference("RinteraDescription","","")." by Rintera" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta http-equiv="x-ua-compatible" content="ie-edge">

    <script src="lib/popper.min.js"></script>
    <script src="lib/jquery-3.5.1.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="src/default.css">
    <link href="lib/jquery.flexdatalist.css" rel="stylesheet" type="text/css">
    <script src="lib/jquery.flexdatalist.js"></script>
    <!-- <script src="lib/jcanvas.min.js"></script> -->
    <!-- <script src="lib/apexcharts.min.js"></script> -->
    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="lib/jquery.toast.min.css">
    <script type="text/javascript" src="lib/jquery.toast.min.js"></script>
    <link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
    <script type="text/javascript" src="lib/datatables.min.js"></script>
    <script src="lib/jquery.modalpdz.js"></script> 
    <link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />


    <<!-- These belongs to the HTML file where you want C3 to work - put these lines into your <head> tag -->
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.css" rel="stylesheet" type="text/css">


<link rel="icon" href="data:;base64,iVBORw0KGgo=">
<link rel="shortcut icon" href="favicon.ico">
<link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
</head>
<body style="
background-color: <?php echo Preference("ColorDeFondo", "", ""); ?>;
">
<?php
// Init();
?>

<div id='PreLoader'>
    <div id='Loader'>
        <img src='img/loader_classic.gif'><br>
    </div>
</div>