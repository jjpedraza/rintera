<?php
require("lib/var_clean.php");
require("tokens.php");
require_once("preference.php");

define("Version","1.0"); 

function Init(){
    if (VersionCheck() == TRUE){
    } else {
        if (VersionMaster_required() == "TRUE"){
            echo "<div id='Version' class='alert alert-danger' role='alert' style='
            height: 100%;
            display: block;
            position: fixed;
            z-index: 5000;
            width: 100%;
            text-align: center;
            '>
            <h1>Requiere Actualizacion</h1>
            <p>Por cuestiones de seguridad, se requiere una actualizacion del codigo del proyecto. Favor de comunicarse con su <b>Departamento de Informática</b> para realizar el proceso</p>
            <p>Version actual: ".Version."<br>"."Version nueva: ".VersionMaster()."
            <br>NOTA de la version: <cite>".getData()->label."</cite>
            <br><a href='".VersionMaster_url()."'>Descargala aqui</a> <hr>
            <br>
            Desarrollador por ".getData()->contact."

            </div>";

           
        } else {
            echo "<div id='Version' class='alert alert-warning' role='alert'>
            <h1>Se Recomienda actualizar Rintera</h1>
            <p>Hay nueva versión disponible, se requiere actualizacion para seguir operando </p>
            <p>Version actual: ".Version."<br>"."Version nueva: ".VersionMaster()."
            <br><a href='".VersionMaster_url()."'>Descarga aqui</a>
            </div>";
        }
       
    }
}
function VersionCheck(){
    if (Version < VersionMaster()){
        return  FALSE;
    } else {
        return TRUE;
    }
}
function VersionMaster_url(){
    return getData()-> download;
}


function VersionMaster_required(){
    return getData()-> required;
}

function VersionMaster(){
    return getData()-> version;
}
function SESSION_init($id, $user, $session_name, $session_comentario, $ip){
    require("rintera-config.php");	
    $sql = "INSERT INTO sessiones (id, session_name,  usuario, fecha, hora, comentarios,ipcliente) 
    VALUES ('".$id."', '".$session_name."', '".$user."', '".$fecha."', '".$hora."', '".$session_comentario."', '".$ip."')";
    // mensaje($sql,'login.php');
        if ($db0->query($sql) == TRUE)
            {return TRUE;}
        else {return FALSE;}
}


function SESSION_close($id){
    require("rintera-config.php");
    $sql="UPDATE sessiones  SET cierre_fecha='".$fecha."', cierre_hora='".$hora."'  WHERE id='".$id."'";
    // //echo $sql;
    if ($db0->query($sql) == TRUE)
        {return TRUE;}
    else {return FALSE;}
}




function Historia($IdUser, $IdApp, $Descripcion){
    require("rintera-config.php");
    $Descripcion = addslashes($Descripcion);    
    $sql = "INSERT INTO historia
    (IdUser, fecha, hora, Descripcion, IdApp)
        VALUES
        ('$IdUser', '$fecha', '$hora','$Descripcion','$IdApp')";
    
    if ($db0->query($sql) == TRUE)
    {	//echo "ok";
        return 'TRUE';
    }
        else
    {	////echo $sql;
        return 'FALSE';
    }
    }
    
    
    
    function Refresh($page){
        //header('location:$page');
        echo "<script> 
        
        window.location.replace('$page'); 
        
        </script>";
            
  
    }


    
function InfoEquipo()
{
    $browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
    $os=array("WIN","MAC","LINUX");
    # definimos unos valores por defecto para el navegador y el sistema operativo
    $info['browser'] = "OTHER";
    $info['os'] = "OTHER";
    # buscamos el navegador con su sistema operativo
    foreach($browser as $parent)
    {
    $s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
    $f = $s + strlen($parent);
    $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
    $version = preg_replace('/[^0-9,.]/','',$version);
    if ($s)
    {
    $info['browser'] = $parent;
    $info['version'] = $version;
    
    }
    }
    # obtenemos el sistema operativo
    foreach($os as $val)
    {
    if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
    $info['os'] = $val;
    }
    # devolvemos el array de valores
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
        } else {
        // Método por defecto de obtener la IP del usuario
        // Si se utiliza un proxy, esto nos daría la IP del proxy
        // y no la IP real del usuario.
        $ip = $_SERVER['REMOTE_ADDR'];
        }
    //echo getenv('HTTP_CLIENT_IP');
    //echo getenv('HTTP_X_FORWADED_FOR');
    //echo getenv('REMOTE_ADDR');
    $infofull="";
    //$infofull = $infofull. "Usuario: ".gethostname()."<br>";
    $infofull = $infofull. "SO:".$info['os'].",";
    $infofull = $infofull. "Navegador: ".$info['browser'].",";
    $infofull = $infofull. "Version:".$info['version']."";
    // $infofull = $infofull. "".$_SERVER['HTTP_USER_AGENT']."<br>";
    
    $red = "";
    // if ($ip <> '' ){$red = $red."ip:".$ip;	}
    if (strlen(getenv('HTTP_CLIENT_IP')) > 3 ){$red = $red." ".getenv('HTTP_CLIENT_IP');}
    if (strlen(getenv('HTTP_X_FORWADED_FOR')) > 3 ){$red = $red.", ".getenv('HTTP_X_FORWADED_FOR');}
    if (strlen(getenv('REMOTE_ADDR')) > 3 ){$red = $red.", ".getenv('REMOTE_ADDR');}

    if ($red <> ''){
        $infofull = $infofull.", Red: (".$red.")";
    }
    
    
    
    
    return $infofull;
}



function Toast($Texto,$Tipo,$img){
    switch ($Tipo) {
        case 0:
            echo "<script>";
                echo "$.toast('".$Texto."');   ";
            echo "</script>";
            break;
        case 1: //Informativo
            echo "<script>";
            echo "
            $.toast({
                heading: 'Information',
                text: '".$Texto."',
                showHideTransition: 'slide',
                icon: 'info'
            })
            ";
            echo "</script>";
            break;
       
        case 2: //Error
            echo "<script>";
            echo "
            $.toast({
                heading: 'Error',
                text: '".$Texto."',
                showHideTransition: 'slide',
                icon: 'error'
            })
            ";
            echo "</script>";
            break;

        case 3: //Warning
                echo "<script>";
                echo "
                $.toast({
                    heading: 'Warning',
                    text: '".$Texto."',
                    showHideTransition: 'slide',
                    icon: 'warning'
                })
                ";
                echo "</script>";
                break;

                

        case 4: //Success
            echo "<script>";
            echo "
            $.toast({
                heading: 'Success',
                text: '".$Texto."',
                showHideTransition: 'slide',
                icon: 'success'
            })
            ";
            echo "</script>";
            break;
    

        case 5: //fijo
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."',                
                hideAfter: false
                
            })
            ";
            echo "</script>";
            break;
        
        case 6: //imagen normal
                echo "<script>";
                echo "
                $.toast({
                    heading: '',
                    text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                    hideAfter: false
                    
                })
                ";
                echo "</script>";
        break;                


        case 7: //imagen sucess
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                hideAfter: false,
                icon:'success'
                
            })
            ";
            echo "</script>";
        break;                


        case 8: //imagen warning
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                hideAfter: false,
                icon:'warning'
                
            })
            ";
            echo "</script>";
        break;                

        case 9: //imagen error
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                hideAfter: false,
                icon:'error'
                
            })
            ";
            echo "</script>";
        break;                

        case 10: //imagen normal auto
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                showHideTransition: 'slide'
                
            })
            ";
            echo "</script>";
    break;                


    case 11: //imagen sucess auto
        echo "<script>";
        echo "
        $.toast({
            heading: '',
            text: '".$Texto."<img style=width:100% src=".$img.">"."',                
            
            icon:'success',
            showHideTransition: 'slide'
            
        })
        ";
        echo "</script>";
    break;                


    case 12: //imagen warning auto
        echo "<script>";
        echo "
        $.toast({
            heading: '',
            text: '".$Texto."<img style=width:100% src=".$img.">"."',                
           
            icon:'warning',
            showHideTransition: 'slide'
            
        })
        ";
        echo "</script>";
    break;                

    case 13: //imagen error auto
        echo "<script>";
        echo "
        $.toast({
            heading: '',
            text: '".$Texto."<img style=width:100% src=".$img.">"."',                
            
            icon:'error',
            showHideTransition: 'slide'
            
        })
        ";
        echo "</script>";
    break;                


        default:
           echo "<script>";
               echo "$.toast('".$Texto."');   ";
           echo "</script>";
    }
}

function UserAdmin($IdUser){
    require_once("rintera-config.php");   
    if ($UsuariosForaneaos == FALSE){
        $sql = "select * from users WHERE IdUser ='".$IdUser."'";
        $rc= $db0 -> query($sql);
    } else {
        //Complementmos la consulta a la base de nuestro cliente
        $sql = $QueryUsuariosForaneos." and IdUser='".$IdUser."'";

        //apuntamos la coneccion a la base de datos del cliente
        $rc= $db1 -> query($sql);
    }
    
    if($f = $rc -> fetch_array())
    {
        if ($f['RinteraLevel']==1)  {
            return TRUE; // es admin
        } else {
            return FALSE; // no es admin
        }
    }
        
}

function getData()
{    
    $url = 'https://v3nt4s.store/ws/rintera.html'; 
    $context = stream_context_create(
        array(
            "http" => array(
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
            )
        )
    );
    
    $archivo_web = file_get_contents($url, false, $context);
    $archivo = json_decode($archivo_web);    
    return $archivo;

}

function LocationFull($page){
	echo ' <script type="text/javascript">top.location.href="'.$page.'"</script>';
}

function PermisoReporte_Ver($IdUser,$IdRep){
    require_once("rintera-config.php");   
    $sql = "select count(*) as n
    
    from reportes_permisos WHERE IdUser ='".$IdUser."' and id_rep='".$IdRep."' and Ver=1";
    $rc= $db0 -> query($sql);
    
    
    if($f = $rc -> fetch_array())
    {
        if ($f['n']==1)  {
            return TRUE; // es admin
        } else {
            return FALSE; // no es admin
        }
    } else {
        return FALSE;
    }

}



function PermisoReporte_Share($IdUser,$IdRep){
    require_once("rintera-config.php");   
    $sql = "select count(*) as n
    
    from reportes_permisos WHERE IdUser ='".$IdUser."' and id_rep='".$IdRep."' and CompartirVer=1";
    $rc= $db0 -> query($sql);
    
    
    if($f = $rc -> fetch_array())
    {
        if ($f['n']==1)  {
            return TRUE; // es admin
        } else {
            return FALSE; // no es admin
        }
    } else {
        return FALSE;
    }

}



function DynamicTable_MySQL($sql, $IdDiv, $IdTabla, $Clase, $Tipo, $db){
	//Tipo == 0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
	//$sql = "select * from Colorines limit 20";
	//DynamicTable_MySQL($sql, "Colorines", "Colorines_Tabla", "Colorines_ClaseCSS", 0, 0);

	require("rintera-config.php");
	
	if ($db == 0){
        $r= $db0 -> query($sql);
        $tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'">
        <table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" style="font-size:8pt;">';
    $tabla_titulos = ""; $cuantas_columnas = 0;
        $r2 = $db0 -> query($sql); while($finfo = $r2->fetch_field())
        {//OBTENER LAS COLUMNAS

                /* obtener posición del puntero de campo */
                $currentfield = $r2->current_field;       
                $tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
                $cuantas_columnas = $cuantas_columnas + 1;        
        }

        $tbCont = $tbCont."  
        <thead>
        <tr>
            ".$tabla_titulos."  
        </tr>
        </thead>"; //Encabezados
        $tbCont = $tbCont."<tbody class='tabla'>";
        $cuantas_filas=0;
        $r = $db0 -> query($sql); while($f = $r-> fetch_row())
        {//LISTAR COLUMNAS

            $tbCont = $tbCont."<tr>";        
            for ($i = 1; $i <= $cuantas_columnas; $i++) {      
                $tbCont = $tbCont."<td style='font-size:10pt;'>".$f[$i-1]."</td>";       
                }

            $tbCont = $tbCont."</tr>";
            $cuantas_filas = $cuantas_filas + 1;        
        }

        $tbCont = $tbCont."</tbody>";
        $tbCont = $tbCont."</table></div>";
	

    }






	if ($db == 1){

        $r1= $db1 -> query($sql);
        $tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'">
        <table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" style="font-size:8pt;">';
    $tabla_titulos = ""; $cuantas_columnas = 0;
        $r1_1 = $db1 -> query($sql); while($finfo = $r1_1->fetch_field())
        {//OBTENER LAS COLUMNAS

                /* obtener posición del puntero de campo */
                $currentfield = $r1_1->current_field;       
                $tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
                $cuantas_columnas = $cuantas_columnas + 1;        
        }

        $tbCont = $tbCont."  
        <thead>
        <tr>
            ".$tabla_titulos."  
        </tr>
        </thead>"; //Encabezados
        $tbCont = $tbCont."<tbody class='tabla'>";
        $cuantas_filas=0;
        $r1 = $db1 -> query($sql); while($f1 = $r1-> fetch_row())
        {//LISTAR COLUMNAS

            $tbCont = $tbCont."<tr>";        
            for ($i = 1; $i <= $cuantas_columnas; $i++) {      
                $tbCont = $tbCont."<td style='font-size:10pt;'>".$f1[$i-1]."</td>";       
                }

            $tbCont = $tbCont."</tr>";
            $cuantas_filas = $cuantas_filas + 1;        
        }

        $tbCont = $tbCont."</tbody>";
        $tbCont = $tbCont."</table></div>";
	

    }


    if ($db == 0 OR $db==1){
	echo  $tbCont;
		switch ($Tipo) {
			case 1: //Scroll Vertical
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"scrollY":        "200px",
							"scrollCollapse": true,
							"paging":         false,
							"language": {
								"decimal": ",",
								"thousands": "."
							}
						} );
					} );
					</script>';
				break;

			case 2: //Scroll Horizontal
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"scrollX": true,
							"scrollCollapse": true,
							"paging":         true,
							"language": {
								"decimal": ",",
								"thousands": "."
							}
						} );
					} );
					</script>';
				break;
			
			default:
				echo '<script>
				$(document).ready(function() {
					$("#'.$IdTabla.'").DataTable( {
						"language": {
							"decimal": ",",
							"thousands": "."
						}
					} );
				} );
				</script>';
		}
    } else {
    	echo "Error: no se ha seleccionado una db para la Tabla Dinamica";
    }

}



//Acordeon

function AcordionCard($IdCard, $btnText, $IdCollapsed, $Color){
        echo '
            <div class="card">
                <div class="card-header" id="'.$IdCard.'" style="
                background-color:'.$Color.'

                ">
                    <h5 class="mb-0">
                        <button class="btn " data-toggle="collapse" data-target="#'.$IdCollapsed.'" aria-expanded="true" aria-controls="'.$IdCollapsed.'"
                        style="width:100%;"
                        
                        >';
        echo $btnText;                            
        echo '          </button>
                    </h5>
                </div>';
}

function AcordionCard_Data($IdCard, $Text, $IdCollapsed, $Color){
    echo '
        <div id="'.$IdCollapsed.'" class="collapse " aria-labelledby="'.$IdCard.'" data-parent="#accordion" style="opacity:0.8; background-color:'.$Color.';
        -webkit-box-shadow: inset 2px 25px 31px -25px rgba(0,0,0,0.75);
        -moz-box-shadow: inset 2px 25px 31px -25px rgba(0,0,0,0.75);
        box-shadow: inset 2px 25px 31px -25px rgba(0,0,0,0.75);
        
        ">
            <div class="card-body">';
    echo $Text;
    echo '  </div>
        </div>
    
    </div>
    ';
}


function TestConectionDB($IdCon){
require("rintera-config.php");   
$sql = "select * from dbs where IdCon='".$IdCon."'";
$rc= $db0 -> query($sql);
if($f = $rc -> fetch_array())
{
    if ($f['dbhost']<>'' &&  $f['dbname']<>'' && $f['dbuser']<>'' && $f['dbpassword']<>'')    {
        $Tdb_host = $f['dbhost'];
        $Tdb_user = $f['dbuser'];
        $Tdb_pass = $f['dbpassword'];
        $Tdb_name = $f['dbname'];

        
            $Tdb = new mysqli($Tdb_host,$Tdb_user,$Tdb_pass,$Tdb_name);
            if ($Tdb->connect_error) {
                // die("Connection failed: " . $Tdb->connect_error);
                Toast("Error al conectarse, revise los datos. ".$Tdb->connect_error,2,"");
            }
            $sql = "select @@version as Version";
            $rT= $Tdb -> query($sql);
            if($T = $rT -> fetch_array()){
                Toast("Conección Existosa a ".$f['dbname']."@".$f['dbhost'].": <b>".$T['Version'],4,"")."</b>";
            } else {
                Toast("Error al conectase, revise los datos en su conección",3,"");
            }
        
        
         
           





    } else {
        Toast("Sin datos para la coneccion",2,"");
    }


} else {
    return "FALSE";
}

}

function ConType($IdCon){
    require_once("rintera-config.php");   
    
    $sql = "select * from dbs WHERE Idcon='".$IdCon."'";
    $rc= $db0 -> query($sql);
    if($f = $rc -> fetch_array())
    {
        return $f['ConType'];
    } else{
        return "";
    }
        
}



function TestConectionWS($IdCon){
    require_once("rintera-config.php");   
    $sql = "select * from dbs where IdCon='".$IdCon."'";
    $rc= $db0 -> query($sql);
    if($f = $rc -> fetch_array())
    {
        if ($f['ConType']==2) //SQLSERVERTOJON 
        {

            $wsmethod ='POST';
            $wsjson = '1';
            $wsurl = $f['wsurl'];
            
            $wsP1_id = 'token';
            $wsP1_value = $f['wsP1_value'];
    
            $wsP2_id = 'method';
            $wsP2_value = $f['wsP2_value'];
    
            //Estos no se utilizan para este Webservice
            // $wsP3_id = $f['wsP3_id'];
            // $wsP3_value = $f['wsP3_value'];
    
            // $wsP4_id = $f['wsP4_id'];
            // $wsP4_value = $f['wsP4_value'];


            $url = $wsurl;            
            $sql = "select 'OK' as Exito";
            $token = $wsP1_value;

            //Peticion
            $myObj = new stdClass;
            $myObj->token = $token;
            $myObj->sql = $sql;
            $myJSON = json_encode($myObj,JSON_UNESCAPED_SLASHES);
            
            $datos_post = http_build_query(
                $myObj
            );

            $opciones = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $datos_post
                )
            );
            
            $context = stream_context_create($opciones);            
            $archivo_web = file_get_contents($url, false, $context);            
            $data = json_decode($archivo_web);
        

            var_dump($data);
            // echo "<hr>";

            //Recorrido
            $jsonIterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                RecursiveIteratorIterator::SELF_FIRST
            );
         
            $Exito = FALSE;
            foreach ($jsonIterator as $key => $val) {
                    if(is_array($val)) {
                        // echo $key.":<br>";
                        // $Exito = TRUE;
                    } else {
                        // echo $key.":".$val."<br>";
                        if ($key=='Exito' and $val == 'OK'){
                            $Exito = TRUE;
                        }
                    }
            }
              
            if ($Exito == TRUE){
                Toast("Conección exitosa",4,"");
                return TRUE;
            } else {
                Toast("Conección fallida",2,"");
                return FALSE;
            }
            
        } else {

        }
            
            
             
               
    
    
    
    
    } else {
        return "FALSE";
    }
    
    }


    function PingtoDb($IdCon){
        require_once("rintera-config.php");   
        $sql = "select * from dbs where IdCon='".$IdCon."'";    
        
        $rc= $db0 -> query($sql);    
        if($f = $rc -> fetch_array())
        {    
            if ($f['dbhost']<>'' &&  $f['dbname']<>'' && $f['dbuser']<>'' && $f['dbpassword']<>'')    {
                $Tdb_host = $f['dbhost'];
                $Tdb_user = $f['dbuser'];
                $Tdb_pass = $f['dbpassword'];
                $Tdb_name = $f['dbname'];
                    $Tdb = new mysqli($Tdb_host,$Tdb_user,$Tdb_pass,$Tdb_name);
                    if ($Tdb->connect_error) {
                        // die("Connection failed: " . $Tdb->connect_error);
                            Toast("Error al conectarse, revise los datos. ".$Tdb->connect_error,2,"");
                            return FALSE;
                    }
                    $sql = "select @@version as Version";
                    $rT= $Tdb -> query($sql);
                    if($T = $rT -> fetch_array()){
                        
                        return TRUE;
                    } else {
                        
                        return FALSE;
                    }
                
            } else {
               
                return FALSE;
            }
        
        
        } else {
            return FALSE;
        }
        
    }
        


    
