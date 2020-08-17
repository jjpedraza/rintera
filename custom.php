
<?php
require ("rintera-config.php");
require ("components.php");
if  ($PublicIndex == TRUE){
    include("seguridad.php");   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $Cliente.": ".$ClienteInfo; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta http-equiv="x-ua-compatible" content="ie-edge">

    <script src="lib/popper.min.js"></script>
    <script src="lib/jquery-3.5.1.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="src/default.css">



<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="lib/jquery.toast.min.css">
<script type="text/javascript" src="lib/jquery.toast.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
<script type="text/javascript" src="lib/datatables.min.js"></script>
<script src="lib/jquery.modalpdz.js"></script> 
<link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />


</head>
<body>

<?php Init();?>
<div id='PreLoader'>
    <div id='Loader'>
        <img src='img/loader_classic.gif'><br>      
    </div>
</div>


<?php
//TOKENS
$MiToken = MiToken($RinteraUser, "Custom");


include ("header.php");

?>



<?php
if (UserAdmin($RinteraUser)==TRUE){
    echo "<center>";
    echo "<h4>Preferencias de Rintera</h4>";

    echo '<div id="accordion" class="Panel">
         <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        db1
                    </button>
                </h5>
            </div>';

    echo '
        <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
            x
            </div>
        </div>
    </div>';

    echo '</div>';


    echo '<div id="Grafica" class="Panel">';
    echo 'xxxx';
    echo '</div>';


    echo '<div id="Grafica" class="Panel">';
    echo 'xxxx';
    echo '</div>';


    echo '<div id="Grafica" class="Panel">';
    echo 'xxxx';
    echo '</div>';


    

    echo "</center>";
   
} else {
    LocationFull("index.php");
}
?>




</body>
</html>
