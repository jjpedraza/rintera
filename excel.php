<?php
require ("rintera-config.php");
require ("components.php");

$id_rep = VarClean($_GET['id_rep']);
$IdUser = VarClean($_GET['IdUser']);




$Contenido = VarClean($_POST['Contenido']);
$Titulo = VarClean($_POST['Titulo']);
$Descripcion = VarClean($_POST['Descripcion']);








$Archivo = $StringFecha."_".$id_rep."_".$IdUser.".xls";

$ContenidoFinal = "<h1>".$Titulo."</h1><p>".$Descripcion."</p>".$Contenido;
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename='.$Archivo.'.xls');
echo $ContenidoFinal;




?>