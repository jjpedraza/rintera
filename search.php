<?php
require("rintera-config.php");
require("components.php");

$ElToken = VarClean($_POST['Token']);
$IdUser = VarClean($_POST['IdUser']);

$busqueda = VarClean($_POST['busqueda']);

$MiToken = MiToken($IdUser, "Search");
// echo $ElToken."|".$MiToken;
if (MiToken_valida($ElToken, $IdUser, "Search")==TRUE){//Valido

    echo "<h1 style='
        font-size: 16pt;
        text-align: center; 
    '>Resultados de <b>".$busqueda."</b>:</h1>";
    echo "<table class='tabla'>";
    $sql = "select * from reportes  WHERE
    rep_name like '%".$busqueda."%' or
    rep_description like '%".$busqueda."%' or
    id_rep like '%".$busqueda."%' 

        
    ";
    // echo $sql;
    $r= $db0 -> query($sql);
    while($f = $r -> fetch_array()) {   
        echo "<tr>";
        echo "<td>".$f['rep_name']."</td>";

        echo "</tr>";
    }
    echo "</table>";
} else {    
    
    Toast("Error vuelva a intentarlo",2,"");
}


MiToken_Close($IdUser, "Search");             



                  
                 
//Hay que cerrar el Token
?>