<?php
require("lib/var_clean.php");



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
        if ($f['RinteraLevel']==2)  {
            return TRUE; // es admin
        } else {
            return FALSE; // no es admin
        }
    }
        
}
?>