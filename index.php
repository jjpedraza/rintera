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

<table width=100%><tr><td>
    <?php

    if (isset($_GET['q'])) {

        echo '
    <input id="InputBusqueda" list="busquedas"     data-min-length="1"
    style="

        background-color: '.Preference("ColorPrincipal", "", "").';
        

    "
    class="InputBusqueda flexdatalist" type="text" placeholder="¿Que Información necesitas?"  value="' . VarClean($_GET['q']) . '">
    ';
    } else {
        echo '
    <input id="InputBusqueda" list="busquedas"  data-min-length="1"
    style="

        background-color: '.Preference("ColorPrincipal", "", "").';
       

    "
    class="InputBusqueda flexdatalist" type="text" placeholder="¿Que Información necesitas?" >
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
</td><td width=50px align=right valign=middle 
style='
background-color: <?php echo Preference("ColorPrincipal", "", ""); ?>;
'
>
<button  class="Mbtn btn-Success"  onclick="Search();" style="
background-color:  <?php echo Preference("ColorResaltado", "", ""); ?>;
box-shadow: 0 3px  #4d4c49; margin:10px;

"> 
<img src='icons/busqueda.png' style='width:50px;'></button>

</td></table>
<div style='
background-color: <?php echo Preference("ColorPrincipal", "", ""); ?>;
text-align: center;
color: white;
font-size: 10pt;  height:22px;

-webkit-box-shadow: 1px 5px 5px -3px rgba(0,0,0,0.75);
-moz-box-shadow: 1px 5px 5px -3px rgba(0,0,0,0.75);
box-shadow: 1px 5px 5px -3px rgba(0,0,0,0.75);
margin-top:  -21px;
'>
    <div id='PreloaderBuscando' style='display:none;'>
        Buscando <img src='img/loader_bar.gif'>
    </div>
</div>

<?php
if (Preference("MostrarApps", "", "")=='TRUE'){
    echo '
    <div class="row">
    <section id="Resultados" class="col-sm">
    

    </section>

    <section id="MisApp" class="col-sm">
    

    </section>
    </div>
    ';
} else {
    echo '
    
    <section id="Resultados">    

    </section>

    
    ';
}
?>


<?php

if (UserAdmin($RinteraUser) == TRUE) {
    if (Preference("NuevosReportes", "", "")=='TRUE'){
    echo "<div class='btnMas' title='Haz clic aquí para crear un nuevo reporte'>
    <a href='nuevo.php' > <img src='src/mas.png' style='width:100%;'>
    </a>
    </div>";
    }

}
?>




<?php
echo "
<script> 
$('.InputBusqueda').css('background-color','".Preference("ColorPrincipal", "", "")."');
$('.InputBusqueda').css('color','white');
</script>
";
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
    // Search();
    </script>

";?>


<canvas id="myChart" width="400" height="400"></canvas>
<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

</script>

<?php
include ("footer.php");
?>
