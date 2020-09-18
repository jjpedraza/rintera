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
    require("rintera-config.php");   
    // var_dump($dbUser);
    if (Preference("UsuariosForaneos", "", "") == "FALSE"){
        $sql = "select * from users WHERE IdUser ='".$IdUser."'";        
    } else {
        
        $sql = Preference("UsuariosForaneosQuery", "", "")." and IdUser='".$IdUser."'";
        
    }
    $rc= $dbUser -> query($sql);
    if($f = $rc -> fetch_array())
    {
        if ($f['RinteraLevel']==1)  {
            return TRUE; // es admin
        } else {
            return FALSE; // no es admin
        }
    }
        
}


function QueryReporte($id_rep){
    require("rintera-config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    // echo $sql;    
    $r= $db0 -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['sql1'];
    } else {
        return "FALSE";
    }
        
}


function IdConReporte($id_rep){
    require("rintera-config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $db0 -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['IdCon'];
    } else {
        return "FALSE";
    }
        
}


function TituloReporte($id_rep){
    require("rintera-config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $db0 -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['rep_name'];
    } else {
        return "FALSE";
    }
        
}


function DescripcionReporte($id_rep){
    require("rintera-config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $db0 -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['rep_description'];
    } else {
        return "FALSE";
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
    require("rintera-config.php");   
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
    require("rintera-config.php");   
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
    require("rintera-config.php");   
    
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
    require("rintera-config.php");   
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
        




function TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion, $id_rep, $info_leyenda ){	
    require("rintera-config.php");
    require('lib/pdf/tcpdf.php');
    $info_leyenda =  $info_leyenda. " IdUser: ".$IdUser." | ".$fecha.":".$hora;        
    $LogoFile = "Logo.png";
    $t1 = $TablaHTML;
    $t2="";
    $t3="";

    // ob_end_clean();  
    
    class PDFReporteUniversal extends TCPDF {
        public $str;
        public $titulo;
        public $descripcion;
        public $id_rep;
        public $info_leyenda;
        public $orientacion;
        public $PageSize;
    
        public function Header() {
            if ($this->PageSize == "0"){ //Configuracion CARTA
                if ($this->orientacion == 'L') { //horizontal CARTA						
                    $image_file = K_PATH_IMAGES.'../../../../img/Logo.png';
                    $icono = K_PATH_IMAGES.'user.png';		
                    $this->Image($image_file, 15, 7, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    $this->SetFont('helvetica', 'B', 10);
                    $LogitudTitulo=150;
                    $this->Text(57, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
                    $this->Text(57, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
                    $this->SetFont('helvetica', 'I', 6);
                    $LogitudTitulo=200;
                    $this->Text(57, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
                    $this->Text(57, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
                    $this->Text(57, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 
    
                } else { //VERTICAL CARTA
                    $image_file = K_PATH_IMAGES.'../../../../img/Logo.png';
                    $icono = K_PATH_IMAGES.'user.png';		
                    $this->Image($image_file, 15, 7, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    $this->SetFont('helvetica', 'B', 10);
                    $LogitudTitulo=100;
                    $this->Text(57, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
                    $this->Text(57, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
                    $this->SetFont('helvetica', 'I', 6);
                    $LogitudTitulo=140;
                    $this->Text(57, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
                    $this->Text(57, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
                    $this->Text(57, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 
                    
                }
            } else {//OFICIO
                if ($this->orientacion == 'L') { //horizontal OFICIO.
                    $image_file = K_PATH_IMAGES.'../../../../img/Logo.png';
                    $icono = K_PATH_IMAGES.'user.png';		
                    $this->Image($image_file, 15, 7, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    $this->SetFont('helvetica', 'B', 10);
                    $LogitudTitulo=220;
                    $this->Text(57, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
                    $this->Text(57, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
                    $this->SetFont('helvetica', 'I', 6);
                    $LogitudTitulo=280;
                    $this->Text(57, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
                    $this->Text(57, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
                    $this->Text(57, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 
    
                } else { //VERTICAL OFICIO
                    $image_file = K_PATH_IMAGES.'../../../../img/Logo.png';
                    $icono = K_PATH_IMAGES.'user.png';		
                    $this->Image($image_file, 15, 7, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    $this->SetFont('helvetica', 'B', 10);
                    $LogitudTitulo=100;
                    $this->Text(57, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
                    $this->Text(57, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
                    $this->SetFont('helvetica', 'I', 6);
                    $LogitudTitulo=140;
                    $this->Text(57, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
                    $this->Text(57, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
                    $this->Text(57, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 
    
                }
            }
    
    
 }    


 public function Footer() {
    if ($this->PageSize == "0"){ //Configuracion CARTA
        if ($this->orientacion == 'L') { //horizontal CARTA						
            $this->SetY(-15);		
            $this->SetFont('helvetica', 'I', 6);	 
            $this->SetTextColor(0,0,0);
            $linea= "_______________________________________________________________________________________________________________________________________________________________________________________________________________________________________";
            $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
            $this->Text(14.5,199, $linea); 	 
            $LogitudTitulo=205;
            $this->SetFont('helvetica', 'B', 9); $this->Text(15,201.5, $paginas); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,201.5, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,203.5, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 
    

        } else { //VERTICAL CARTA
            $this->SetY(-15);		
            $this->SetFont('helvetica', 'I', 6);	 
            $this->SetTextColor(0,0,0);
            $linea= "_______________________________________________________________________________________________________________________________________________________________________________________________________________________________________";
            $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
            $this->Text(14.5,262.5, $linea); 	 
            $LogitudTitulo=150;
            $this->SetFont('helvetica', 'B', 9); $this->Text(15,265, $paginas); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,265, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,267, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 
            
        }
    } else {//OFICIO
        if ($this->orientacion == 'L') { //horizontal OFICIO
            $this->SetY(-15);		
            $this->SetFont('helvetica', 'I', 6);	 
            $this->SetTextColor(0,0,0);
            $linea= "______________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________";
            $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
            $this->Text(14.5,199, $linea); 	 
            $LogitudTitulo=205;
            $this->SetFont('helvetica', 'B', 9); $this->Text(15,201.5, $paginas); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,201.5, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,203.5, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 


        } else { //VERTICAL OFICIO
            // $this->SetY(-15);		
            $this->SetFont('helvetica', 'I', 6);	 
            $this->SetTextColor(0,0,0);
            $linea= "_______________________________________________________________________________________________________________________________________________________________";
            $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
            $this->Text(14.5,325, $linea); 	 
            $LogitudTitulo=150;
            $this->SetFont('helvetica', 'B', 9); $this->Text(15,327, $paginas); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,327.5, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,329.8, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 

        }
    }


}
}
$pdf = new PDFReporteUniversal(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor($autor);
// $pdf->SetTitle("d".strtoupper($titulo));
// $pdf->SetSubject("x".$titulo);
// $pdf->SetKeywords('Reporte ITAVU');
// $pdf->SetHeaderData('pdf_logo.jpg', '30', strtoupper("".$titulo).'', $descripcion."\nImpreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu)."(".$nitavu.")");

//   $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 6));
//   $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//   $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);    
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
//   $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetHeaderMargin(20);
// $pdf->SetFooterMargin(50);

//   $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);  
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
if (@file_exists(dirname(__FILE__).'lib/pdf/lang/eng.php')) {require_once(dirname(__FILE__).'lib/pdf/lang/eng.php'); $pdf->setLanguageArray($l); }

$pdf->titulo = $titulo;
$pdf->descripcion = $descripcion;
$pdf->orientacion = $orientacion;
$pdf->PageSize = $PageSize;
$pdf->info_leyenda = $info_leyenda;
$pdf->id_rep = $id_rep;

$pdf->SetFont('helvetica', '', 7);  

//   $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
if ($PageSize == "LEGAL")  {
    if ($orientacion == "P"){
        $pdf->SetAutoPageBreak(TRUE, 30);
    } else {
        $pdf->SetAutoPageBreak(TRUE, 15);
    }
    
} else {

}


$pdf->AddPage($orientacion,$PageSize);     

$pdf->writeHTML($t1, true, false, true, 0, '');

//Est apartado se acomoda sin importar si es vertical o horizontal, asi como el tamaño de la hoja
if($t2<>'' or $t3<>'') {	//Agregamos una nueva hoja para los anexos
$pdf->AddPage($orientacion, $PageSize);
$pdf->writeHTML($t2, true, false, true, 0, ''); //Anexo1
$pdf->writeHTML($t3, true, false, true, 0, ''); //Anexo2

}



//Finalizamos el reporte
$pdf->lastPage();	  

//   $pdf->Output('reporte_'.$id_rep.'.pdf', 'I');
$directorio = __DIR__;
// $directorio = str_replace("unica", "tmp", $directorio);
$archivo = $directorio."\\tmp\\".$StringFecha."_".$id_rep."_".$IdUser.".pdf";  
$archivoWeb = "tmp/".$StringFecha."_".$id_rep."_".$IdUser.".pdf";  
$pdf->Output($archivo, 'F');   

return $archivoWeb;



}




function DataFromSQLSERVERTOJSON($id_rep, $Tipo, $ClaseTabla, $ClaseDiv, $IdUser)
{
//SQLSERVERTOJSON = https://github.com/prymecode/sqlservertojson
require("rintera-config.php");	
$Query = QueryReporte($id_rep);
    // echo "Query = ".$Query."<br>";

$IdCon = IdConReporte($id_rep); 
    // echo "IdCon=".$IdCon."<br>";


// $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
$len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
$STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
$STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdTabla = $STR;
//1.- Obtener datos de conección
$WS_Val = FALSE;
$WS_Msg = "";
$WSSQL = "select * from dbs where IdCon='".$IdCon."' AND Active=1 AND ConType =2"; //SQLSERVERTOJSON
// echo $WSSQL;
$WSCon= $db0 -> query($WSSQL);
if($WSConF = $WSCon -> fetch_array())
{
    // var_dump($RConF);
    // 1. Validacion de Datos necesarios
    if ($WSConF['wsurl'] <>'' &&  $WSConF['wsmethod']<>'' && $WSConF['wsjson']<>'' 
        // &&  $WSConF['wsP1_id'] && $WSConF['wsP1_value'] &&
        //     $WSConF['wsP2_id'] && $WSConF['wsP2_value'] &&
        //     $WSConF['wsP3_id'] && $WSConF['wsP3_value'] &&
        //     $WSConF['wsP4_id'] && $WSConF['wsP4_value']
        )    
    {
        $WSurl = $WSConF['wsurl'];
        $WSmethod = $WSConF['wsmethod'];
        $WSjson = $WSConF['wsjson'];
        $WSparametros = $WSConF['parametros'];

        $wsP1_id = $WSConF['wsP1_id'];  $wsP1_value = $WSConF['wsP1_value'];
        $wsP2_id = $WSConF['wsP2_id'];  $wsP2_value = $WSConF['wsP2_value'];
        $wsP3_id = $WSConF['wsP3_id'];  $wsP3_value = $WSConF['wsP3_value'];
        $wsP4_id = $WSConF['wsP4_id'];  $wsP4_value = $WSConF['wsP4_value'];

        $WS_Val = TRUE;
        // echo "OK";

                
        $url = $WSurl;            
        $sql = $Query;
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
    
        switch ($Tipo) {
            // case 0:
            //     return $archivo_web;
            // break;

            case 0: //HTML         
                $tabla = "";                  
                // //Recorrido del contenido
                $jsonIterator = new RecursiveIteratorIterator(
                    new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                    RecursiveIteratorIterator::SELF_FIRST
                );
            
                // var_dump( $jsonIterator);
                $tabla= "<table id='".$IdTabla."'  width=100% border=0 class='".$ClaseTabla."'>";          
                $tabla_content = ""; $tabla_th = "";  
                $row=0; $rowC = 0;
                $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows
                    // echo $limit."=".$key."=".$val."<br>";
                     $limit = 0;
                    }
                    else {
                        // echo "*".$limit."=".$key."=".$val."<br>";
                        $limit = $limit  + 1;
                    }
                    
                }
                // echo "limit=".$limit;

                //Construccion de <th>
                foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows                        
                        $rowC = 0;
                    } else {
                        if ($row < $limit){
                            if ($rowC == 0){$tabla_th.="<tr>";}                            
                            $tabla_th.="<th>".$key."</th>";
                        }                        
                    $rowC = $rowC + 1;
                    $row = $row + 1;
                    }
                }
                $tabla_th.="</tr>";
                $row =0; $rowC = 0;
                
                // echo "limit=".$limit;
                foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows                        
                        $rowC = 0;
                    }
                    else {                    
                        if ($rowC == 0){$tabla_content.="<tr>";}
                        if ($rowC == $limit){$tabla_content.="</tr>"; }                             
                        $tabla_content.="<td >".$val."</td>";                       
                    $rowC = $rowC + 1;
                    $row = $row + 1;
                    }
                
                
                }
                
                
                $tabla.=$tabla_th.$tabla_content."</table>";                
                return $tabla;
                break;
        
                case 1: // Interactivo
                    $tabla = "";
                    // //Recorrido del contenido
                    $jsonIterator = new RecursiveIteratorIterator(
                        new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                        RecursiveIteratorIterator::SELF_FIRST
                    );
                
                    // var_dump( $jsonIterator);
                    $tabla= "<table  id='".$IdTabla."' width=100% border=0 class='".$ClaseTabla."'>";          
                    $tabla_content = ""; $tabla_th = "";  
                    $row=0; $rowC = 0;
                    $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                        if (is_numeric($key)){ //rows
                        // echo $limit."=".$key."=".$val."<br>";
                        $limit = 0;
                        }
                        else {
                            // echo "*".$limit."=".$key."=".$val."<br>";
                            $limit = $limit  + 1;
                        }
                        
                    }
                    // echo "limit=".$limit;

                    //Construccion de <th>
                    foreach ($jsonIterator as $key => $val) {
                        if (is_numeric($key)){ //rows                        
                            $rowC = 0;
                        } else {
                            if ($row < $limit){
                                if ($rowC == 0){$tabla_th.="<tr>";}                            
                                
                                $tabla_th.="<td >".$key."</td>"; //cambiar th por td para datatable
                            }                        
                        $rowC = $rowC + 1;
                        $row = $row + 1;
                        }
                    }
                    $tabla_th =  "<thead>".$tabla_th."</tr></thead>";
                    // echo "<table border=1>".$tabla_th."</table>";
                    $row =1; $rowC = 1;
                    
                    // echo "limit=".$limit."<hr>";
                    foreach ($jsonIterator as $key => $val) {
                        
                        if (is_numeric($key)){ //rows                        
                            // $rowC = 1;
                        }
                        else {           
                            
                            if ($rowC == 1){
                                $tabla_content.="<tr>"; 
                                // echo "---".$limit."<br>";
                            }
                            // echo "rowC=".$rowC."(".$row.")<br>";
                            // $tabla_content.="<td>".$row."(".$rowC.")".$val."</td>";                  
                            $tabla_content.="<td>".$val."</td>";                  
                            if ($rowC == $limit){
                                $tabla_content.="</tr>";
                                $rowC = 1;
                                //  echo "===".$limit."<br>"; 
                            
                            }  else {
                                $rowC = $rowC + 1;       
                            }  
                            
                               
                            
                            $row = $row + 1;
                        
                        }
                        
                    
                    
                    }                                       
                    $tabla.=$tabla_th."<tbody class='".$ClaseTabla."'>".$tabla_content."</tbody></table>";     // tabla constuida a partir del ws
                    // echo $tabla;
                    //Escribimos en el dom
                    echo "<div id='".$IdDiv."' class='".$ClaseDiv."'>".$tabla."</div>";
                    
                    



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
        

                case 2: //PDF
                    
                        $tabla = "";
                        // //Recorrido del contenido
                        $jsonIterator = new RecursiveIteratorIterator(
                            new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                            RecursiveIteratorIterator::SELF_FIRST
                        );
                    
                        // var_dump( $jsonIterator);
                        $tabla= "<table  id='".$IdTabla."' width=100% border=0 class='".$ClaseTabla."'>";          
                        $tabla_content = ""; $tabla_th = "";  
                        $row=0; $rowC = 0;
                        $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                            if (is_numeric($key)){ //rows
                            // echo $limit."=".$key."=".$val."<br>";
                            $limit = 0;
                            }
                            else {
                                // echo "*".$limit."=".$key."=".$val."<br>";
                                $limit = $limit  + 1;
                            }
                            
                        }
                        // echo "limit=".$limit;
    
                        //Construccion de <th>
                        foreach ($jsonIterator as $key => $val) {
                            if (is_numeric($key)){ //rows                        
                                $rowC = 0;
                            } else {
                                if ($row < $limit){
                                    if ($rowC == 0){$tabla_th.="<tr>";}                            
                                    
                                    $tabla_th.='<td  bgcolor="#555555" color="white">'.strtoupper($key)."</td>"; //cambiar th por td para datatable
                                }                        
                            $rowC = $rowC + 1;
                            $row = $row + 1;
                            }
                        }
                        $tabla_th =  "<thead>".$tabla_th."</tr></thead>";
                        // echo "<table border=1>".$tabla_th."</table>";
                        $row =1; $rowC = 1; $L = 0;
                        
                        // echo "limit=".$limit."<hr>";
                        foreach ($jsonIterator as $key => $val) {
                            
                            if (is_numeric($key)){ //rows                        
                                // $rowC = 1;
                            }
                            else {           
                                
                                if ($rowC == 1){
                                    $tabla_content.="<tr>"; 
                                    $L = $L+1;
                                    
                                    // echo "---".$limit."<br>";
                                }
                                // echo "rowC=".$rowC."(".$row.")<br>";
                                // $tabla_content.="<td>".$row."(".$rowC.")".$val."</td>";                  
                                // $tabla_content.="<td>".$val."</td>";     
                               

                                if ($L%2==0){
                                    $tabla_content = $tabla_content.'<td bgcolor="white" >'.$val."</td>";    
                                    
                                    
                                }else{
                                    $tabla_content = $tabla_content.'<td  bgcolor="#F0F0E1" >'.$val."</td>";       
                                    
                                }
                                
                                if ($rowC == $limit){
                                    $tabla_content.="</tr>";
                                    $rowC = 1;
                                    //  echo "===".$limit."<br>"; 
                                
                                }  else {
                                    $rowC = $rowC + 1;       
                                }  
                                
                                   
                                
                                $row = $row + 1;
                            
                            }
                            
                        
                        
                        }                                       
                        $tabla.=$tabla_th."<tbody class='".$ClaseTabla."'>".$tabla_content."</tbody></table>";     // tabla constuida a partir del ws
                        $TablaHTML = $tabla;

                        $titulo = TituloReporte($id_rep);
                        $descripcion = DescripcionReporte($id_rep);
                        $PageSize = "0"; // 0= carta y 1 == oficio
                        $orientacion = "L";
                        $id_rep = 0;
                        $info_leyenda = "x";
                        $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
                        echo "<iframe id='pdfPresenter' src='".$ArchivoDelReporte."'
                        style='
                            width: 100%;
                            height: 94%;
                            position: absolute;
                            border: 0px;
                        '
                        >
                        
                        </iframe>";


                break;


                case 3: //Excel
                    
                    $tabla = "";
                    // //Recorrido del contenido
                    $jsonIterator = new RecursiveIteratorIterator(
                        new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                        RecursiveIteratorIterator::SELF_FIRST
                    );
                
                    // var_dump( $jsonIterator);
                    $tabla= "<table  id='".$IdTabla."' width=100% border=0 class='".$ClaseTabla."'>";          
                    $tabla_content = ""; $tabla_th = "";  
                    $row=0; $rowC = 0;
                    $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                        if (is_numeric($key)){ //rows
                        // echo $limit."=".$key."=".$val."<br>";
                        $limit = 0;
                        }
                        else {
                            // echo "*".$limit."=".$key."=".$val."<br>";
                            $limit = $limit  + 1;
                        }
                        
                    }
                    // echo "limit=".$limit;

                    //Construccion de <th>
                    foreach ($jsonIterator as $key => $val) {
                        if (is_numeric($key)){ //rows                        
                            $rowC = 0;
                        } else {
                            if ($row < $limit){
                                if ($rowC == 0){$tabla_th.="<tr>";}                            
                                
                                $tabla_th.='<td  bgcolor="#555555" color="white">'.strtoupper($key)."</td>"; //cambiar th por td para datatable
                            }                        
                        $rowC = $rowC + 1;
                        $row = $row + 1;
                        }
                    }
                    $tabla_th =  "<thead>".$tabla_th."</tr></thead>";
                    // echo "<table border=1>".$tabla_th."</table>";
                    $row =1; $rowC = 1; $L = 0;
                    
                    // echo "limit=".$limit."<hr>";
                    foreach ($jsonIterator as $key => $val) {
                        
                        if (is_numeric($key)){ //rows                        
                            // $rowC = 1;
                        }
                        else {           
                            
                            if ($rowC == 1){
                                $tabla_content.="<tr>"; 
                                $L = $L+1;
                                // echo "---".$limit."<br>";
                            }
                            // echo "rowC=".$rowC."(".$row.")<br>";
                            // $tabla_content.="<td>".$row."(".$rowC.")".$val."</td>";                  
                            // $tabla_content.="<td>".$val."</td>";     

                            if ($L%2==0){
                                $tabla_content = $tabla_content.'<td bgcolor="white"  style="background-color:white;">'.$val."</td>";       
                                
                            }else{
                                $tabla_content = $tabla_content.'<td  bgcolor="#F0F0E1" style="background-color:#F0F0E1;" >'.$val."</td>";       
                                
                            }
                            
                            if ($rowC == $limit){
                                $tabla_content.="</tr>";
                                $rowC = 1;
                                //  echo "===".$limit."<br>"; 
                            
                            }  else {
                                $rowC = $rowC + 1;       
                            }  
                            
                               
                            
                            $row = $row + 1;
                        
                        }
                        
                    
                    
                    }                                       
                    $tabla.=$tabla_th."<tbody class='".$ClaseTabla."'>".$tabla_content."</tbody></table>";     // tabla constuida a partir del ws
                    $TablaHTML = $tabla;

                    $titulo = TituloReporte($id_rep);
                    $descripcion = DescripcionReporte($id_rep);
                    $PageSize = "0"; // 0= carta y 1 == oficio
                    $orientacion = "L";
                    // $id_rep = 0;
                    $info_leyenda = "x";
                    // $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
                    $ArchivoDelReporte = "excel.php?IdUser=".$IdUser."&id_rep=".$id_rep;
                    
                    echo "<iframe id='pdfPresenter' src='".$ArchivoDelReporte."'
                    style='
                        width: 100%;
                        height: 94%;
                        position: absolute;
                        border: 0px;
                    '
                    >
                    
                    </iframe>";


            break;

            case 4: //Word
                    
                $tabla = "";
                // //Recorrido del contenido
                $jsonIterator = new RecursiveIteratorIterator(
                    new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                    RecursiveIteratorIterator::SELF_FIRST
                );
            
                // var_dump( $jsonIterator);
                $tabla= "<table  id='".$IdTabla."' width=100% border=0 class='".$ClaseTabla."'>";          
                $tabla_content = ""; $tabla_th = "";  
                $row=0; $rowC = 0;
                $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows
                    // echo $limit."=".$key."=".$val."<br>";
                    $limit = 0;
                    }
                    else {
                        // echo "*".$limit."=".$key."=".$val."<br>";
                        $limit = $limit  + 1;
                    }
                    
                }
                // echo "limit=".$limit;

                //Construccion de <th>
                foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows                        
                        $rowC = 0;
                    } else {
                        if ($row < $limit){
                            if ($rowC == 0){$tabla_th.="<tr>";}                            
                            
                            $tabla_th.='<td  bgcolor="#555555" color="white">'.strtoupper($key)."</td>"; //cambiar th por td para datatable
                        }                        
                    $rowC = $rowC + 1;
                    $row = $row + 1;
                    }
                }
                $tabla_th =  "<thead>".$tabla_th."</tr></thead>";
                // echo "<table border=1>".$tabla_th."</table>";
                $row =1; $rowC = 1;
                
                // echo "limit=".$limit."<hr>";
                foreach ($jsonIterator as $key => $val) {
                    
                    if (is_numeric($key)){ //rows                        
                        // $rowC = 1;
                    }
                    else {           
                        
                        if ($rowC == 1){
                            $tabla_content.="<tr>"; 
                            // echo "---".$limit."<br>";
                        }
                        // echo "rowC=".$rowC."(".$row.")<br>";
                        // $tabla_content.="<td>".$row."(".$rowC.")".$val."</td>";                  
                        // $tabla_content.="<td>".$val."</td>";     

                        if ($row%2==0){
                            $tabla_content = $tabla_content.'<td bgcolor="white" >'.$val."</td>";       
                            
                        }else{
                            $tabla_content = $tabla_content.'<td  bgcolor="#F0F0E1" >'.$val."</td>";       
                            
                        }
                        
                        if ($rowC == $limit){
                            $tabla_content.="</tr>";
                            $rowC = 1;
                            //  echo "===".$limit."<br>"; 
                        
                        }  else {
                            $rowC = $rowC + 1;       
                        }  
                        
                           
                        
                        $row = $row + 1;
                    
                    }
                    
                
                
                }                                       
                $tabla.=$tabla_th."<tbody class='".$ClaseTabla."'>".$tabla_content."</tbody></table>";     // tabla constuida a partir del ws
                $TablaHTML = $tabla;

                $titulo = TituloReporte($id_rep);
                $descripcion = DescripcionReporte($id_rep);
                $PageSize = "0"; // 0= carta y 1 == oficio
                $orientacion = "L";
                // $id_rep = 0;
                $info_leyenda = "x";
                // $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
                $ArchivoDelReporte = "word.php?IdUser=".$IdUser."&id_rep=".$id_rep;
                echo "<iframe id='pdfPresenter' src='".$ArchivoDelReporte."'
                style='
                    width: 100%;
                    height: 94%;
                    position: absolute;
                    border: 0px;
                '
                >
                
                </iframe>";


        break;















                default:
        }             
                
        
        
    } else {
        $WS_Msg.="Parametros insuficientes";
        return $WS_Msg;

    }
} else {
    $WS_Msg.="Error de consulta a la base de datos";
    return $WS_Msg;
}
// echo $WS_Msg;
// return $WS_Val;
    
}
















function DataFromMySQL($ClaseDiv, $ClaseTabla, $Tipo, $IdUser,$id_rep){
    require("rintera-config.php");	
    $Query = QueryReporte($id_rep); 
        // echo "Query = ".$Query."<br>";
    $IdCon = IdConReporte($id_rep); 
        // echo "IdCon=".$IdCon."<br>";

    if ($Query == "FALSE") {
        return "ERROR: Datos insuficientes en el reporte (Query).";
        exit();
    } 
    
    if ($IdCon == "FALSE") {
        return "ERROR: Datos insuficientes en el reporte (IdCon).";
        exit();
    } 

    
    $TablaHTML = "";


    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdTabla = $STR;
    
    // echo "IdDiv=".$IdDiv."<br>"."IdTabla=".$IdTabla."<br>";

    
$Con_IdCon = $IdCon; include("con_init.php");

if ($Con_Val == TRUE){    
    if ($r = $LaConeccion -> query($Query)){
        if($f = $r -> fetch_array()){
        
            // var_dump($f);

            $tbCont = '<div id="'.$IdDiv.'" class="'.$ClaseDiv.'">
            <table  id="'.$IdTabla.'"  style="width:100%; " class="'.$ClaseTabla.'" style="font-size:8pt;">';
            $tabla_titulos = ""; $cuantas_columnas = 0;
            $r2 = $LaConeccion -> query($Query); while($finfo = $r2->fetch_field())
            {//OBTENER LAS COLUMNAS

                    /* obtener posición del puntero de campo */
                    $currentfield = $r2->current_field;       
                    $tabla_titulos=$tabla_titulos.'<th bgcolor="#A5A5A5" color="white">'.strtoupper($finfo->name)."</th>";
                    $cuantas_columnas = $cuantas_columnas + 1;        
            }
            unset($r2);

            $tbCont = $tbCont."  
            <thead>
            <tr>
                ".$tabla_titulos."  
            </tr>
            </thead>"; //Encabezados
            $tbCont = $tbCont."<tbody class='".$ClaseTabla."'>";
            $cuantas_filas=0;
            $r = $LaConeccion -> query($Query); while($f = $r-> fetch_row())
            {//LISTAR COLUMNAS

                $tbCont = $tbCont."<tr>";        
                for ($i = 1; $i <= $cuantas_columnas; $i++) {      
                    if ($cuantas_filas%2==0){
                        $tbCont = $tbCont.'<td bgcolor="white" >'.$f[$i-1]."</td>";       
                        
                    }else{
                        $tbCont = $tbCont.'<td  bgcolor="#F0F0E1" >'.$f[$i-1]."</td>";       
                        
                    }

                    
                    }

                $tbCont = $tbCont."</tr>";
                $cuantas_filas = $cuantas_filas + 1;        
            }
            unset($r);
            $tbCont = $tbCont."</tbody>";
            $tbCont = $tbCont."</table></div>";
            $TablaHTML = $tbCont;

            switch ($Tipo) {
                case 0:  //HTML 
                    return $TablaHTML;    
                break;
               
                case 1: // Interactivo
                    echo $TablaHTML;
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

                case 2: // PDF
                    // $IdUser = $RinteraUser;
                    $titulo = TituloReporte($id_rep);
                    $descripcion = DescripcionReporte($id_rep);
                    $PageSize = "0"; // 0= carta y 1 == oficio
                    $orientacion = "L";
                    $id_rep = 0;
                    $info_leyenda = "x";
                    $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
                    echo "<iframe id='pdfPresenter' src='".$ArchivoDelReporte."'
                    style='
                        width: 100%;
                        height: 94%;
                        position: absolute;
                        border: 0px;
                    '
                    >
                    
                    </iframe>";

                    // echo "<script>pdf('".$ArchivoDelReporte."');</script>";

                break;

                case 3: // EXCEL
                    // $IdUser = $RinteraUser;
                    
                    $titulo = TituloReporte($id_rep);
                    $descripcion = DescripcionReporte($id_rep);
                    $PageSize = "0"; // 0= carta y 1 == oficio
                    $orientacion = "L";
                    // $id_rep = 0;
                    $info_leyenda = "x";
                    // $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
                    $ArchivoDelReporte = "excel.php?IdUser=".$IdUser."&id_rep=".$id_rep;
                    echo "<iframe id='pdfPresenter' src='".$ArchivoDelReporte."'
                    style='
                        width: 100%;
                        height: 94%;
                        position: absolute;
                        border: 0px;
                    '
                    >
                    
                    </iframe>";

                    // echo "<script>pdf('".$ArchivoDelReporte."');</script>";

                break;
                
                
                case 4: // Word
                    // $IdUser = $RinteraUser;
                    
                    $titulo = TituloReporte($id_rep);
                    $descripcion = DescripcionReporte($id_rep);
                    $PageSize = "0"; // 0= carta y 1 == oficio
                    $orientacion = "L";
                    // $id_rep = 0;
                    $info_leyenda = "x";
                    // $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
                    $ArchivoDelReporte = "word.php?IdUser=".$IdUser."&id_rep=".$id_rep;
                    echo "<iframe id='pdfPresenter' src='".$ArchivoDelReporte."'
                    style='
                        width: 100%;
                        height: 94%;
                        position: absolute;
                        border: 0px;
                    '
                    >
                    
                    </iframe>";

                    // echo "<script>pdf('".$ArchivoDelReporte."');</script>";

                break;
                
                
            

            default:

                
            }
            
            
            // return $tbCont;
        

        

        } else {
            $Con_Msg .= "Error de Consulta, (array)";
            // return FALSE;
            return $Con_Msg;
        }
    } else {
        // return FALSE;
        return "Error al consultar. ".$Con_Msg;
        // echo "Error en la base de datos";
    }
    
    
} else {
    return $Con_Msg;
    // echo "ERROR: ".$Con_Msg;
}



include("con_close.php");


}





function Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $IdUser ){
    require("rintera-config.php");	
    $IdCon = IdConReporte($id_rep);
    $ConType = ConType($IdCon);

    //Validaciones


    // $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
    $Data = "";
        switch ($ConType) {
            case 0:  //rintera
                $Data = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $IdUser, $id_rep);
                break;

            case 1:  //MySQL        
                $Data = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $IdUser,$id_rep);
                break;

            case 2:  //MSQLSERVERTOJSON      
                
                // $Data =  DataFromSQLSERVERTOJSON($IdCon, $Tipo,$ClaseTabla,$ClaseDiv, $IdUser);
                $Data =  DataFromSQLSERVERTOJSON($id_rep, $Tipo, $ClaseTabla, $ClaseDiv, $IdUser);
                break;
            
        }


        return $Data;


}