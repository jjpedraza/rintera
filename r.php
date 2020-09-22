<?php
include ("head.php");
include ("header.php");

$id_rep = VarClean($_GET['id']);
$Tipo = ReporteTipo($id_rep); // $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
// var_dump($Tipo);
$ClaseDiv  = "ContenedorDeReporte"; $ClaseTabla = "tabla";
echo "<div id='C' style='
width:100%;
text-align:center;
'>";
$Data =  Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $RinteraUser );
echo $Data;
echo "</div>";





include ("footer.php");
?>