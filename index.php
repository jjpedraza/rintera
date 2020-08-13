
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
<?php Init();
MiToken_CloseALL($RinteraUser);
$MiToken = MiToken($RinteraUser, "Search");
if ($MiToken == ''){
    $MiToken = MiToken_Init($RinteraUser, "Search");
}

// echo "Token: ".$MiToken."";
?>


<div id='PreLoader'>
    <div id='Loader'>
        <img src='img/loader_classic.gif'><br>      
    </div>
</div>


<?php
include ("header.php");
?>

<section id='Busqueda' >

<?php

if (isset($_GET['q'])){
    
    echo '
    <input id="InputBusqueda" onkeypress="Search();"
    style="
    "
    class="InputBusqueda" type="text" placeholder="¿Que Información necesitas?"  value="'.VarClean($_GET['q']).'">
    ';
} else {
    echo '
    <input id="InputBusqueda" onkeypress="Search();"
    style="
    "
    class="InputBusqueda" type="text" placeholder="¿Que Información necesitas?" >
    ';
}

if (isset($_GET['i1'])){Toast("Guardado correctamente ".VarClean($_GET['q']),1,"");}
if (isset($_GET['e1'])){Toast("ERROR:Al localizar el Reporte ".VarClean($_GET['e1']),2,"");}
// Toast("No se ha localizado tu Reporte ".$IdRep,2,"");
  

?>

</section>

<div  style='
background-color: #1895c6;
text-align: center;
color: white;
font-size: 10pt;  height:22px;
'>
    <div id='PreloaderBuscando' style='display:none;'>
    Buscando <img src='img/loader_bar.gif'>
    </div>
</div>
<section id='Resultados'>
Resutlado de la buqueda

</section>

<?php
if (UserAdmin($RinteraUser)==TRUE){
    echo "<div class='btnMas' title='Haz clic aquí para crear un nuevo reporte'>
    <a href='nuevo.php' > <img src='src/mas.png' style='width:100%;'>
    </a>
    </div>";

  
} else {

}
?>

<div id='Footer'>
<b>Rintera<b>: Es un proyecto para la gestion de reportes a traves de consultas a la base de datos con variables integradas. El entorno ideal para gestionar la data de tu proyecto

</div>

<?php
echo "
    <script>
    function Search(){
        var busqueda = $('#InputBusqueda').val();
        $('#PreloaderBuscando').show();                
        $.ajax({
            url: 'search.php',
            type: 'post',        
            data: {IdUser:'".$RinteraUser."', Token: '".$MiToken."',
                busqueda:busqueda

            },
        success: function(data){
            $('#Resultados').html(data);
            $('#PreloaderBuscando').hide();
        }
        });


            
    }
    </script>
";

?>

</body>
</html>