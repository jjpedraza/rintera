
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
    <link rel="stylesheet" href="src/default.css">

    <!-- JQUERY -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>

    <!-- BOOTSTRAP -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">    
    <script src="node_modules/popper.js/dist/popper.min.js"></script>
    
    <!-- DATATABLE -->
    <script src="node_modules/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <link rel="stylesheet" href="node_modules/datatables.net-dt/css/jquery.dataTables.min.css">    

    <script src="node_modules/datatables.net-autofill-dt/js/autoFill.dataTables.min.js"></script>
    <link rel="stylesheet" href="node_modules/datatables.net-autofill-dt/css/autoFill.dataTables.min.css">    

    <script src="node_modules/datatables.net-buttons-dt/js/buttons.dataTables.min.js"></script>
    <link rel="stylesheet" href="node_modules/datatables.net-buttons-dt/css/buttons.dataTables.min.css">    
    

    


    
    <!-- <link href="lib/jquery.flexdatalist.css" rel="stylesheet" type="text/css">
    <script src="lib/jquery.flexdatalist.js"></script> -->
    <!-- <script src="lib/jcanvas.min.js"></script> --> 
    <!-- <script src="lib/apexcharts.min.js"></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="lib/jquery.toast.min.css">
    <script type="text/javascript" src="lib/jquery.toast.min.js"></script>
    <link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
    <script type="text/javascript" src="lib/datatables.min.js"></script>
    <script src="lib/jquery.modalpdz.js"></script> 
    <link rel="stylesheet" href="lib/jquery.modalcsspdz.css" /> -->


 

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