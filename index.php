<?php include("head.php"); ?>


<?php

    $MiToken = MiToken($RinteraUser, "Search");
    if ($MiToken == '') {
        $MiToken = MiToken_Init($RinteraUser, "Search");
    }

// echo "Token: ".$MiToken."";
?>





<?php
include("header.php");
?>

<section id='Busqueda' style='
background-color: <?php echo Preference("ColorPrincipal", "", ""); ?>;
'>

    <?php

    if (isset($_GET['q'])) {

        echo '
    <input id="InputBusqueda" onkeypress="Search();"
    style="

        background-color: '.Preference("ColorPrincipal", "", "").';

    "
    class="InputBusqueda" type="text" placeholder="¿Que Información necesitas?"  value="' . VarClean($_GET['q']) . '">
    ';
    } else {
        echo '
    <input id="InputBusqueda" onkeypress="Search();"
    style="

        background-color: '.Preference("ColorPrincipal", "", "").';

    "
    class="InputBusqueda" type="text" placeholder="¿Que Información necesitas?" >
    ';
    }

    if (isset($_GET['i1'])) {
        Toast("Guardado correctamente " . VarClean($_GET['q']), 1, "");
    }
    if (isset($_GET['e1'])) {
        Toast("ERROR:Al localizar el Reporte " . VarClean($_GET['e1']), 2, "");
    }
    // Toast("No se ha localizado tu Reporte ".$IdRep,2,"");


    ?>

</section>

<div style='
background-color: <?php echo Preference("ColorPrincipal", "", ""); ?>;
text-align: center;
color: white;
font-size: 10pt;  height:22px;

-webkit-box-shadow: -2px 3px 7px 0px rgba(0,0,0,0.75);
-moz-box-shadow: -2px 3px 7px 0px rgba(0,0,0,0.75);
box-shadow: -2px 3px 7px 0px rgba(0,0,0,0.75);
'>
    <div id='PreloaderBuscando' style='display:none;'>
        Buscando <img src='img/loader_bar.gif'>
    </div>
</div>
<section id='Resultados'>
    Resutlado de la buqueda

</section>

<?php

if (UserAdmin($RinteraUser) == TRUE) {
    echo "<div class='btnMas' title='Haz clic aquí para crear un nuevo reporte'>
    <a href='nuevo.php' > <img src='src/mas.png' style='width:100%;'>
    </a>
    </div>";

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
            data: {IdUser:'" . $RinteraUser . "', Token: '" . $MiToken . "',
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

include ("footer.php");
?>
