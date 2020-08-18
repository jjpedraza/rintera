
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
//     echo '
//     <!-- Default switch -->
// <div class="custom-control custom-switch">
//   <input type="checkbox" class="custom-control-input" id="customSwitches">
//   <label class="custom-control-label" for="customSwitches">Toggle this switch element</label>
// </div>
//     ';


if (UserAdmin($RinteraUser)==TRUE){
    echo "<center>";
    echo "<h4>Preferencias de Rintera</h4>";

    $sql="select * from dbs";
    $r= $db0 -> query($sql);    
    echo '<div id="accordion" class="Panel" 
    style="
        background-color: #f0f0f0;
        padding: 10px;
    "
    >';
    echo '<h6 style="
    font-weight:bold;
    ">Configuracion de Origen de Datos:</h6>';



    while($f = $r -> fetch_array()) {  
        if ($f['Active']==1){$Color = '#d3f0cf';} else {$Color = '#f4f4f4';}
        $IdCard='Card'.$f['IdCon'];
        $IdCollapsed = 'Coll'.$f['IdCon'] ;
        $btnText ='<table width=100% border=0><tr><td width=20px align=left><img src="icons/db.png" style="width:20px"></td><td>['.$f['IdCon'].'] '.$f['ConName'].'</td></tr></table>';
        $ContenidoDelCard = 'Esto seria el contenido';
        AcordionCard($IdCard, $btnText, $IdCollapsed, $Color);
        AcordionCard_Data($IdCard, $ContenidoDelCard, $IdCollapsed, $Color);

        // echo '
        //     <div class="card">
        //         <div class="card-header" id="headingOne">
        //             <h5 class="mb-0">
        //                 <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">';
                            
        // echo '          </button>
        //             </h5>
        //         </div>';

    // echo '
    //     <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
    //         <div class="card-body">
    //         x
    //         </div>
    //     </div>
    // </div>';

    }
    echo '</div>';


    echo '<div id="Grafica" class="Panel">';
    echo 'Panel2';
    echo '</div>';




    

    echo "</center>";
   
} else {
    LocationFull("index.php");
}
?>




</body>
</html>
