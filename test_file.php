<?php
include ("head.php");

//consulta mediante DataFromMySQL
// $Query = "select nitavu, nombre from empleados limit 10"; 

// $ClaseDiv = "container"; $ClaseTabla = ""; 
// $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
// $id_rep = 17;
// $Tabla = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $RinteraUser,$id_rep);

// echo $Tabla;


//Consulta mediante el Webservice
// $WSTipo= 5; //0 = json del webservice, 1 = tabla html, 2 = DataTable, 3 pdf, 4=Excel, 5 = Word
// $IdCon = 4; //Conecciones de la tabla dbs
// $ClaseDiv = ""; $ClaseTabla = ""; //sugerencia= clase tabla
// $IdUser = $RinteraUser;
// echo DataFromSQLSERVERTOJSON($IdCon,"select top 15 IdLote,IdDelegacion,IdPrograma from lotes",$WSTipo,$ClaseTabla,$ClaseDiv, $RinteraUser);

$id_rep = 16; $Tipo = 0; // $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
$ClaseDiv  = ""; $ClaseTabla = "tabla";
// echo Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $RinteraUser );


$file = fopen("archivo.txt", "w");
fwrite($file, "Esto es una nueva linea de texto" . PHP_EOL);
fwrite($file, "Otra más" . PHP_EOL);
fclose($file);




include ("footer.php");
?>