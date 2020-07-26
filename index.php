
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
<div id='PreLoader'>
    <div id='Loader'>
        <img src='img/loader_classic.gif'><br>      
    </div>
</div>


<?php

if ($PublicIndex == TRUE){



    echo "
    <div id='Welcome'>
    <table width=100%><tr><td>
    ";
    echo "<b style='cursor:pointer;' title='No. de Empleado = ".$RinteraUser."'>".$RinteraUserName."</b>";    
    echo "
    </td>
    <td width=50px>
    <a href='logout.php' class='Salir'>Salir</a>
    </td></tr>
    </table></div>
    ";

} else {
    echo "
    <div id='Welcome'>Acceso abierto al publico</div>";
}

?>

<section id='Busqueda' >

<input
  style="

  "
  
  class="InputBusqueda" type="text" placeholder="¿Que Información necesitas?" >
  



</section>


<section id='Resultados'>
Resutlado de la buqueda

</section>

<?php
if (UserAdmin($RinteraUser)==TRUE){
    echo "<div class='btnMas' title='Haz clic aquí para crear un nuevo reporte'>
    <a href='#NuevoReporte' rel='MyModal:open'> <img src='src/mas.png' style='width:100%;'>
    </a>
    </div>";

    echo "<div id='NuevoReporte' class='MyModal'>";
    echo "<b class='h5'>Nuevo Reporte<b>:<br>";
    echo"</div>";
} else {

}
?>

</body>
</html>