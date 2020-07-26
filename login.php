<?php
require("rintera-config.php");
require("components.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $Cliente;?></title>

	
	<script src="lib/jquery-3.3.1.js"></script> 
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">

<?php
$dir = "";
echo '

<script src="lib/jquery-3.3.1.js"></script> 
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">

<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="lib/jquery.toast.min.css">
<script type="text/javascript" src="lib/jquery.toast.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
<script type="text/javascript" src="lib/datatables.min.js"></script>
<script src="lib/jquery.modalpdz.js"></script> 
<link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />
';

?>
    <style>
        body {
            background-color: #d5d5d5;
            
        }
        #Login {
            width: 40%;
            background-color: white;
            position: absolute;
            left: 29%;
            top: 25%;
            padding: 14px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div id='Login' >


<form class="form-signin" style='text-align:center;' method='POST' action=''>
 
  <h3><b>RINTERA:</b> Identificate!</h3>
  <label for="txtIdUser" class="sr-only">IdUser</label>
  <input type="text" id="txtIdUser" name="txtIdUser" class="form-control" placeholder="IdUser" required autofocus>
  <label for="txtNIP" class="sr-only">Password</label><br>
  <input type="password" id="txtNIP"  name="txtNIP" class="form-control" placeholder="Password" required>
  <br>
  <input name='FormLogin' type='submit' class="btn btn-lg btn-primary btn-block" Value="Entrar">
  <br><br>
</form>

</div>
<?php
if (isset($_POST['FormLogin'])){

    $txtIdUser = VarClean($_POST['txtIdUser']);
    $txtNIP = VarClean($_POST['txtNIP']);
    
    //Consulta de validacion
    //Puedes usar la base de datos del cliente
    //Toma en cuenta Los campos:
    //  IdUser = Campo identificador como el no. de empleado Numerico
    //  UserName = Nombre del usuario
    //  NIP = password de acceso
    //  RinteraLevel = 1 = Usuario de consulta
    /// RinteraLevel = 2 = Administrador, para editar y crear reportes
    //  * Puedes crear una vista que haga esta consulta con tu base de datos
    // de aqui en adelante sera transparente el proceso

    //Ejemplo de Vista:
    // select 
    // a.nitavu as IdUSer,
    // a.nip as NIP,
    // a.nombre as UserName,
    // if (
    //     a.nitavu = "2809" 
    //     or a.nitavu="1533"
    // ,2,1) as RinteraLevel
    // from empleados a
    // WHERE     nitavu in(2809,1533,1733)

    // * si el usuario es 2809 o 1533 les dara acceso admin sino solo usuario de lectura
    // mientras que en el WHERE filtras los que veran reportes

    //tambien puedes usar la tabla de rintera (users)

    if ($UsuariosForaneaos == FALSE){
        $sql = "select * from users WHERE IdUser ='".$txtIdUser."'";

        $rc= $db0 -> query($sql);
                       
         
    } else {
        //Complementmos la consulta a la base de nuestro cliente
        $sql = $QueryUsuariosForaneos." and IdUser='".$txtIdUser."'";

        //apuntamos la coneccion a la base de datos del cliente
        $rc= $db1 -> query($sql);
                      
         

    }
    
    if($f = $rc -> fetch_array())
    {  
        
      if ($f['NIP']==$txtNIP){

                $IdUser = $f['IdUser'];	// variable de entorno      
                session_start();    
                session_regenerate_id();                
                

                $_SESSION['RinteraUser']=$f['IdUser']; //session		
                $_SESSION['RinteraUserName']=$f['UserName']; //session		
                $RinteraUser = $f['IdUser'];
                global $RinteraUser; //generalize       

                Historia($RinteraUser,'RinteraLogin','Acceso Rintera'.InfoEquipo().'');			    
                SESSION_init(session_id(), $RinteraUser, $SesionName, InfoEquipo(), "");    
                echo '<script>window.location.replace("index.php?home=")</script>'; 
            
        } else {
            Toast("Password  Incorrecto",2,"");
        }
        
        
        
	} else {
        Toast("Usuario No Valido",2,"");
        
	}
}

?>



<?php
echo '

<script src="lib/popper.min.js"></script>
<script src="lib/jquery-3.5.1.slim.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>';

?>
</body>
</html>