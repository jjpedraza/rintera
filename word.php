<?php
require ("rintera-config.php");
require ("components.php");

$id_rep = VarClean($_GET['id_rep']);
$IdUser = VarClean($_GET['IdUser']);



//Consulta mediante el Webservice
$WSTipo= 1; //0 = json del webservice, 1 = tabla html, 2 = DataTable, 3 pdf
$IdCon = 4; //Conecciones de la tabla dbs
$ClaseDiv = ""; $ClaseTabla = ""; //sugerencia= clase tabla
$IdUser = $IdUser;
$Contenido =  DataFromSQLSERVERTOJSON($IdCon,"select top 15 IdLote,IdDelegacion,IdPrograma from lotes",$WSTipo,$ClaseTabla,$ClaseDiv, $IdUser);





// $Contenido = 
$Titulo = "El Titulo ";
$Descripcion = "La Descripcion";








$Archivo = $StringFecha."_".$id_rep."_".$IdUser.".xls";


$ContenidoFinal = "<h1>".$Titulo."</h1><p>".$Descripcion."</p>".$Contenido;



header('Content-type: application/vnd.ms-word;charset=iso-8859-15');
header('Content-Disposition: attachment; filename='.$Archivo.'.doc');
echo $ContenidoFinal;




?>