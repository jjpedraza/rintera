
<?php
require ("rintera-config.php");
require ("components.php");
if  ($PublicIndex == TRUE){
    include("seguridad.php");   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $Cliente.": ".$ClienteInfo; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta http-equiv="x-ua-compatible" content="ie-edge">

    <script src="lib/popper.min.js"></script>
    <script src="lib/jquery-3.5.1.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="src/default.css">



<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="lib/jquery.toast.min.css">
<script type="text/javascript" src="lib/jquery.toast.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
<script type="text/javascript" src="lib/datatables.min.js"></script>
<script src="lib/jquery.modalpdz.js"></script> 
<link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />


</head>
<body>

<?php Init();?>
<div id='PreLoader'>
    <div id='Loader'>
        <img src='img/loader_classic.gif'><br>      
    </div>
</div>


<?php
//TOKENS
$MiToken = MiToken($RinteraUser, "Users");
// if ($MiToken == ''){
//     $MiToken = MiToken_Init($RinteraUser, "Edit");
// }
// echo "Token: ".$MiToken;




include ("header.php");

?>


<?php
if (UserAdmin($RinteraUser)==TRUE){
    if ($UsuariosForaneaos == FALSE){

        if (isset($_GET['id'])){
            $IdUser = VarClean($_GET['id']);
            $sql = "select * from users WHERE IdUser ='".$IdUser."'";
            $rc= $db0 -> query($sql);
            if($f = $rc -> fetch_array())
            {
                echo "<h3 style='text-align:center; color: #28a745;' class=''>Usuario: ".$IdUser."</h3><br>";
            
            echo "
            <center>
            <form action='' method='POST' class='row container' style='
            background-color:#ececec;
            border-radius: 5px;
            padding: 5px;

            '>";
            echo "<div class='col-sm-4'><label>Nombre: <input class='form-control' type='text' name='UserName' value='".$f['UserName']."'></label></div>";
            echo "<div class='col-sm-4'><label>Nombre: <input class='form-control' type='text' name='UserName' value='".$f['UserName']."'></label></div>";
            echo "<div class='col-sm-4'><label><br><input class='btn btn-success' type='submit' name='BtnActualizar' value='Actualizar' ></label></div>";
           
            echo "</form>
            </center>
            ";
                
            } else {
                echo "<p>ERROR: Usuario no localizado</p>";
            }


            
        }
        echo "<br><br><hr><h2 style='text-align:center;'>USUARIOS REGISTRADOS:</h2><br>";
        $sql ='   select *from users_html ';
        $IdTabla = "MiTabla";
        $Clase = "container ";
        $db= 0 ;
        DynamicTable_MySQL($sql, "DivUsuarios", $IdTabla, $Clase, 0, $db);

    } else {
        echo "<p>La administración de usuarios se realiza en una base de datos externa!.</p>";
    }
    
} else {
    LocationFull("index.php");
}
?>




</body>
</html>
