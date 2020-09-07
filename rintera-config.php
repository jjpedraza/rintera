<?php


$fecha = date('Y-m-d');
$hora =  date ("H:i:s");
$SesionName="R1nT3r4";

require_once("preference.php");
//CONEXION DE LA BASE DE DATOS DE RINTERA	
$db0_host = 'localhost';	
$db0_user = 'root';
$db0_pass = '3l-1t4vu'; 
$db0_name = 'rintera';

if (function_exists('mysqli_connect')) {		
    $db0 = new mysqli($db0_host,$db0_user,$db0_pass,$db0_name);
	$acentos = $db0->query("SET NAMES 'utf8'"); // para los acentos
	// var_dump($db0);
        // global $db0;
        
    }else{			
        die ("Error en la conexion a la base de datos principal de RINTERA");
}






$UsuariosForaneaos = Preference("UsuariosForaneos", "", ""); 
$QueryUsuariosForaneos = Preference("UsuariosForaneosQuery", "", "");  //"select * from UsuariosRintera where RinteraLevel>0"; 
$UsuariosForaneosIdCon = Preference("UsuariosForaneosIdCon", "", ""); 

$UsuariosForaneosIdConType = "";
$sql = "select * from dbs WHERE Idcon='".$UsuariosForaneosIdCon."'";
$rc= $db0 -> query($sql);
// var_dump($db0);
if($f = $rc -> fetch_array())
{
	$UsuariosForaneosIdConType =  $f['ConType'];
}

$Error="";
// echo $UsuariosForaneaos;
// var_dump($UsuariosForaneosIdCon);
if ($UsuariosForaneaos == "TRUE") {
    if 	($UsuariosForaneosIdCon <> "" ){
        if ($UsuariosForaneosIdConType  <=1) {

                  
                if ($QueryUsuariosForaneos <> '') {
                    $sql = "select * from dbs where IdCon='".$UsuariosForaneosIdCon."'";        
                    $r= $db0 -> query($sql);    
                    if($Fdb = $r -> fetch_array())
                    {    
                        if ($Fdb['dbhost']<>'' &&  $Fdb['dbname']<>'' && $Fdb['dbuser']<>'' && $Fdb['dbpassword']<>'')    {
                            $dbUser_host = $Fdb['dbhost'];
                            $dbUser_user = $Fdb['dbuser'];
                            $dbUser_pass = $Fdb['dbpassword'];
                            $dbUser_name = $Fdb['dbname'];
                        
                            if (function_exists('mysqli_connect')) {		
                                $dbUser = new mysqli($dbUser_host,$dbUser_user,$dbUser_pass,$dbUser_name);
                                $acentos = $dbUser->query("SET NAMES 'utf8'"); // para los acentos                            
                                

                                
                                // echo "Exito";p
                            }else{
                                $Error = $Error."No esta activado MySQLi";    
                            }

                        } else {
                            $Error = $Error."Parametros insuficientes para conección." .$dbUser_host;    
                        }

                    } else {
                        $Error = $Error."No se localizo el registro de la conección ".$UsuariosForaneosIdCon.".";    
                    }           

                } else {
                    $Error = $Error."Sin Query para Foraneos";
                }
              
        } else {
            $Error = $Error."No es un tipo de Conección Permitida ConType=0,1. ";
        }
    } else {
        $Error = $Error."IdCon para Foraneos Vacia ";
    }



		//Validaciond e consulta
		if (isset($dbUser)) {
    	$sql = $QueryUsuariosForaneos;
        $RUser= $dbUser -> query($sql);
        if($FUser = $RUser -> fetch_array()){
            // var_dump($FUser);
            
            
        } else {
            
            $Error = $Error."Fallo de conección al Consultar los Usuarios";
		}
		} else {
			$Error = $Error."Fallo de conección";
		}
  
    

} 

else {
    //Conección a la base Local de rintera
    	$dbUser = $db0;
        $sql = "select * from users";
        $RUser= $dbUser -> query($sql);
        if($FUser = $RUser -> fetch_array()){
            // var_dump($FUser);
            
            
        } else {
            
            $Error = $Error."Fallo de conección al Consultar los Usuarios";
        }

}




echo $Error;








?>