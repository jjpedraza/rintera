<?php
require_once("preference.php");

//TU CLIENTE:
$Cliente  = "Rintera";
$SrcLogo = "img/logo.png";

$ClienteInfo = "Reportes Interactivos basados en consultas MySQL con Variables";
$ClienteContacto = "Juan José Pedraza, printepolis@gmail.com, Whatsapp: 8343088602";


//PARAMETROS:

$UsuariosForaneaos = FALSE; // para activar consulta en la base secundaria $db1
    $QueryUsuariosForaneos = "
        select * from UsuariosRintera where RinteraLevel>0
    "; // Tomar en cuenta en tu consulta, que añadiras un and en el WHERE despues
    //para seleccionar al usuario


//CONEXION DE LA BASE DE DATOS DE RINTERA	
	$db0_host = 'localhost';	
	$db0_user = 'root';
	$db0_pass = '3l-1t4vu'; 
	$db0_name = 'rintera';

	if (function_exists('mysqli_connect')) {		
		$db0 = new mysqli($db0_host,$db0_user,$db0_pass,$db0_name);
		$acentos = $db0->query("SET NAMES 'utf8'"); // para los acentos
			global $db0;
			
		}else{			
			die ("Error en la conexion a la base de datos principal de RINTERA");
    }





$fecha = date('Y-m-d');
$hora =  date ("H:i:s");
$SesionName="R1nT3r4";
?>