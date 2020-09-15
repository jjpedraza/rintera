<?php
require ("rintera-config.php");
require ("components.php");

$id_rep = VarClean($_GET['id_rep']);
$IdUser = VarClean($_GET['IdUser']);



//Consulta mediante el Webservice
$WSTipo= 1; //0 = json del webservice, 1 = tabla html, 2 = DataTable, 3 pdf

$ClaseDiv = ""; $ClaseTabla = ""; //sugerencia= clase tabla
$IdUser = $IdUser;
$Query =  QueryReporte($id_rep);
$IdCon = IdConReporte($id_rep); 


if ($Query == "FALSE") {
    echo "<img src='icons/excel.png' style='width:15px'>ERROR: Reporte ".$id_rep." con datos insuficientes";    
} else {
    // 0 = Base de mysql de rintera
    // 1 = MySQL
    // 2 = WebService SQLSERVERTOJSON
    // 3 = Webservice MSSQL ASP (este envia por post o get sql con la consulta)
    switch ($IdCon) {
        case 0:
            $ClaseDiv = "container"; $ClaseTabla = ""; 
            $Tipo = 0; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word            
            $Contenido = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $RinteraUser,$id_rep);
            break;
        case 1:
            $ClaseDiv = "container"; $ClaseTabla = ""; 
            $Tipo = 0; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word            
            $Contenido = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $RinteraUser,$id_rep);
            break;
        case 2:
            $Contenido =  DataFromSQLSERVERTOJSON($IdCon,$Query,$WSTipo,$ClaseTabla,$ClaseDiv, $IdUser);
            break;
        
        case 3:
            echo "en el abismo programatico...";

            break;
    }
    
    
    $Titulo = "El Titulo ";
    $Descripcion = "La Descripcion";
    $Archivo = $StringFecha."_".$id_rep."_".$IdUser.".xls";
    $ContenidoFinal = "<h1>".$Titulo."</h1><p>".$Descripcion."</p>".$Contenido;
    header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
    header('Content-Disposition: attachment; filename='.$Archivo.'.xls');
    echo $ContenidoFinal;


}








?>