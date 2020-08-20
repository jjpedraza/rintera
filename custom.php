
<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");   

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
$MiToken = MiToken($RinteraUser, "Custom");


include ("header.php");

?>



<?php
//     echo '
//     <!-- Default switch -->
// <div class="custom-control custom-switch">
//   <input type="checkbox" class="custom-control-input" id="customSwitches">
//   <label class="custom-control-label" for="customSwitches">Toggle this switch element</label>
// </div>
//     ';


if (UserAdmin($RinteraUser)==TRUE){
    echo "<center>";
    echo "<h4>Preferencias de Rintera</h4>";

    $sql="select * from dbs";
    $r= $db0 -> query($sql);    
    echo '<div id="accordion" class="Panel" 
    style="
        background-color: #f0f0f0;
        padding: 10px;
    "
    >';
    echo '<h6 style="
    font-weight:bold;
    ">Configuracion de Origen de Datos:</h6>';


    $checked = ''; $txt_checked='';
    while($f = $r -> fetch_array()) {  
        if ($f['Active']==1){$Color = '#d3f0cf';} else {$Color = '#f4f4f4';}
        $IdCard='Card'.$f['IdCon'];
        $IdCollapsed = 'Coll'.$f['IdCon'] ;
        if ($f['ConType']==0){
            $btnText ='<table width=100% border=0><tr><td width=20px align=left><img  title="Base de Datos MYSQL | Rintera" src="icons/dbr.png" style="width:20px"></td><td
            id ="Tit_'.$f['IdCon'].'"
            >['.$f['IdCon'].'] '.$f['ConName'].'</td></tr></table>';
        } 

        if ($f['ConType']==1){
            $btnText ='<table width=100% border=0><tr><td width=20px align=left><img title="Base de Datos MYSQL" src="icons/db.png" style="width:20px"></td><td
            id ="Tit_'.$f['IdCon'].'"
            >['.$f['IdCon'].'] '.$f['ConName'].'</td></tr></table>';
        }

        if ($f['ConType']==2){
            $btnText ='<table width=100% border=0><tr><td width=20px align=left><img title="WebService" src="icons/ws.png" style="width:20px"></td><td
            id ="Tit_'.$f['IdCon'].'"
            >['.$f['IdCon'].'] '.$f['ConName'].'</td></tr></table>';
        }


        if ($f['ConType']==3){
            $btnText ='<table width=100% border=0><tr><td width=20px align=left><img title="WebService: Rintera SQLSERVER-toJSON ASP" src="icons/wsms.png" style="width:20px"></td><td
            id ="Tit_'.$f['IdCon'].'"
            >['.$f['IdCon'].'] '.$f['ConName'].'</td></tr></table>';
        }

        if ($f['Active']==1){$checked = 'checked'; $txt_checked='Desactivar';} else {$checked =''; $txt_checked='Activar';}
        $ContenidoDelCard = '
            <form action="" method="">
            <div class="row ">
                <div class="custom-control custom-switch col-sm-6 ">
                    <input type="checkbox" class="custom-control-input" id="Active_'.$f['IdCon'].'" 
                    onclick="Active('.$f['IdCon'].');" '.$checked.'
                    >
                    <label 
                    onclick="Active('.$f['IdCon'].');"
                    class="custom-control-label" for="Active_'.$f['IdCon'].'">'.$txt_checked.'</label>
                </div>

                <div class="col-sm-6 form-group">
                    <label class="" for="ConName_'.$f['IdCon'].'" >Etiqueta:</label>
                    <input class="form-control" type="text" name="ConName_'.$f['IdCon'].'" id="ConName_'.$f['IdCon'].'"
                    title="Con este nombre podras identificar esta conección"
                    onkeypress="ActTit('.$f['IdCon'].');"
                    value="'.$f['ConName'].'"
                    >
                </div>
            
            </div>';
            $ContenidoDelCard =  $ContenidoDelCard.'<input type="hidden" id="ConType_'.$f['IdCon'].'" value="'.$f['ConType'].'">';
            if ($f['ConType']<=1){
                
            if ($f['ConType']==0){
                    $ContenidoDelCard =  $ContenidoDelCard.'
                    <b class="Etiqueta">* Esta conección es la base de rintera</b>
                    <div class="row ">
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbhost_'.$f['IdCon'].'" >Host:</label>
                            <input class="form-control" type="text" name="dbhost_'.$f['IdCon'].'" id="dbhost_'.$f['IdCon'].'"
                            title="URL o ip del servidor de la base de datos"                    
                            value="'.$db0_host.'"
                            >
                        </div>

                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbuser_'.$f['IdCon'].'" >Usuario:</label>
                            <input class="form-control" type="text" name="dbuser_'.$f['IdCon'].'" id="dbuser_'.$f['IdCon'].'"
                            title="Usuario para acceder a la base de datos"                    
                            value="'.$db0_user.'"
                            >
                        </div>
                    </div>
                    ';


                    $ContenidoDelCard =  $ContenidoDelCard.'
                    <div class="row ">
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbname_'.$f['IdCon'].'" >Nombre de la Base:</label>
                            <input class="form-control" type="text" name="dbname_'.$f['IdCon'].'" id="dbname_'.$f['IdCon'].'"
                            title="Nombre de la base de datos"                    
                            value="'.$db0_name .'"
                            >
                        </div>

                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbpassword_'.$f['IdCon'].'" >Password:</label>
                            <input class="form-control" type="text" name="dbpassword_'.$f['IdCon'].'" id="dbpassword_'.$f['IdCon'].'"
                            title="Password del usuario de la base de datos"                    
                            value="'.$db0_pass.'"
                            >
                        </div>
                    </div>
                    ';

            } else {
                    $ContenidoDelCard =  $ContenidoDelCard.'
                    <div class="row ">
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbhost_'.$f['IdCon'].'" >Host:</label>
                            <input class="form-control" type="text" name="dbhost_'.$f['IdCon'].'" id="dbhost_'.$f['IdCon'].'"
                            title="URL o ip del servidor de la base de datos"                    
                            value="'.$f['dbhost'].'"
                            >
                        </div>

                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbuser_'.$f['IdCon'].'" >Usuario:</label>
                            <input class="form-control" type="text" name="dbuser_'.$f['IdCon'].'" id="dbuser_'.$f['IdCon'].'"
                            title="Usuario para acceder a la base de datos"                    
                            value="'.$f['dbuser'].'"
                            >
                        </div>
                    </div>
                    ';


                    $ContenidoDelCard =  $ContenidoDelCard.'
                    <div class="row ">
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbname_'.$f['IdCon'].'" >Nombre de la Base:</label>
                            <input class="form-control" type="text" name="dbname_'.$f['IdCon'].'" id="dbname_'.$f['IdCon'].'"
                            title="Nombre de la base de datos"                    
                            value="'.$f['dbname'].'"
                            >
                        </div>

                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="dbpassword_'.$f['IdCon'].'" >Password:</label>
                            <input class="form-control" type="text" name="dbpassword_'.$f['IdCon'].'" id="dbpassword_'.$f['IdCon'].'"
                            title="Password del usuario de la base de datos"                    
                            value="'.$f['dbpassword'].'"
                            >
                        </div>
                    </div>
                    ';
                }
            } else {

                if ($f['ConType']==2){//SQLSERVERTOJON
                    $ContenidoDelCard =  $ContenidoDelCard.'
                    <b class="Etiqueta">
                    WebService: <a href="https://github.com/prymecode/sqlservertojson" title="Conecta el proyecto mediante consultas SQL a tu servidor MSSQL-Server"
                    >sqlservertojson</a>. <p>Conecta el proyecto mediante consultas SQL a tu servidor MSSQL-Server</p>
                    </b>
                    <div class="row ">                    
                        <div class="col-sm-6 form-group">
                            <label  class="" for="wsmethod_'.$f['IdCon'].'" >Metodo:</label>
                            <select class="form-control" type="text" name="wsmethod_'.$f['IdCon'].'" id="wsmethod_'.$f['IdCon'].'"
                                title="Metodo del webservice GET o POST"                                                
                                required
                            >';
                                $ContenidoDelCard =  $ContenidoDelCard.'                                                                 
                                    <option value="1" selected>POST</option>';

                            // if ($f['wsmethod'] == '0'){
                            //     $ContenidoDelCard =  $ContenidoDelCard.'
                            //         <option value="0" selected>GET</option>                                
                            //         <option value="1">POST</option>
                            //     ';
    
                            // } else {
                            //         $ContenidoDelCard =  $ContenidoDelCard.'
                            //         <option value="1" selected>POST</option>                                
                            //         <option value="0">GET</option>                                
                            //         ';
                                
                            // }
                                
    
    
                        
                        $ContenidoDelCard =  $ContenidoDelCard.'
    
                            </select>
                        </div>
    
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="wsurl_'.$f['IdCon'].'" >URL:</label>
                            <input class="form-control" type="text" name="wsurl_'.$f['IdCon'].'" id="wsurl_'.$f['IdCon'].'"
                            title="URL del Webservice"                    
                            value="'.$f['wsurl'].'"
                            >
                        </div>
                    </div>
                    ';
    
                    $ContenidoDelCard =  $ContenidoDelCard.'
                    <div class="row ">  
                    <h6>Parametros:</h6>
                    <table width=100% class="tabla">
                    <th>n</th><th>Id</th><th>Valor</th>
                    <tr>
                        <td>1</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP1_id_'.$f['IdCon'].'" id="wsP1_id_'.$f['IdCon'].'"
                            title="Id del Primer Parametro"                    
                            value="token"
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP1_value_'.$f['IdCon'].'" id="wsP1_value_'.$f['IdCon'].'"
                            title="Valor del Primer Parametro"                    
                            value="'.$f['wsP1_value'].'"
                            >
                        </td>
                    </tr>
    
                    <tr>
                        <td>2</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP2_id_'.$f['IdCon'].'" id="wsP2_id_'.$f['IdCon'].'"
                            title="Id del Segundo Parametro"                    
                            value="method"
                            readonly
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP2_value_'.$f['IdCon'].'" id="wsP2_value_'.$f['IdCon'].'"
                            title="Valor del Primer Parametro"                    
                            value="POST"
                            readonly
                            >
                        </td>
                    </tr>
    
    
                    </tr>
    
                    </table>
    
                    </div>
                    ';
    
                    
    
                } else {
                    $ContenidoDelCard =  $ContenidoDelCard.'
                    <div class="row ">                    
                        <div class="col-sm-6 form-group">
                            <label  class="" for="wsmethod_'.$f['IdCon'].'" >Metodo:</label>
                            <select class="form-control" type="text" name="wsmethod_'.$f['IdCon'].'" id="wsmethod_'.$f['IdCon'].'"
                                title="Metodo del webservice GET o POST"                                                
                                required
                            >';
    
                            if ($f['wsmethod'] == '0'){
                                $ContenidoDelCard =  $ContenidoDelCard.'
                                    <option value="0" selected>GET</option>                                
                                    <option value="1">POST</option>
                                ';
    
                            } else {
                                    $ContenidoDelCard =  $ContenidoDelCard.'
                                    <option value="1" selected>POST</option>                                
                                    <option value="0">GET</option>                                
                                    ';
                                
                            }
                                
    
    
                        
                        $ContenidoDelCard =  $ContenidoDelCard.'
    
                            </select>
                        </div>
    
                        
                        <div class="col-sm-6 form-group">
                            <label class="" for="wsurl_'.$f['IdCon'].'" >URL:</label>
                            <input class="form-control" type="text" name="wsurl_'.$f['IdCon'].'" id="wsurl_'.$f['IdCon'].'"
                            title="URL del Webservice"                    
                            value="'.$f['wsurl'].'"
                            >
                        </div>
                    </div>
                    ';
    
                    $ContenidoDelCard =  $ContenidoDelCard.'
                    <div class="row ">  
                    <h6>Parametros:</h6>
                    <table width=100% class="tabla">
                    <th>n</th><th>Id</th><th>Valor</th>
                    <tr>
                        <td>1</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP1_id_'.$f['IdCon'].'" id="wsP1_id_'.$f['IdCon'].'"
                            title="Id del Primer Parametro"                    
                            value="'.$f['wsP1_id'].'"
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP1_value_'.$f['IdCon'].'" id="wsP1_value_'.$f['IdCon'].'"
                            title="Valor del Primer Parametro"                    
                            value="'.$f['wsP1_value'].'"
                            >
                        </td>
                    </tr>
    
                    <tr>
                        <td>2</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP2_id_'.$f['IdCon'].'" id="wsP2_id_'.$f['IdCon'].'"
                            title="Id del Segundo Parametro"                    
                            value="'.$f['wsP2_id'].'"
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP2_value_'.$f['IdCon'].'" id="wsP2_value_'.$f['IdCon'].'"
                            title="Valor del Primer Parametro"                    
                            value="'.$f['wsP2_value'].'"
                            >
                        </td>
                    </tr>
    
    
                    <tr>
                        <td>3</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP3_id_'.$f['IdCon'].'" id="wsP3_id_'.$f['IdCon'].'"
                            title="Id del Tercer Parametro"                    
                            value="'.$f['wsP3_id'].'"
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP3_value_'.$f['IdCon'].'" id="wsP3_value_'.$f['IdCon'].'"
                            title="Valor del Tercer Parametro"                    
                            value="'.$f['wsP3_value'].'"
                            >
                        </td>
                    </tr>
    
                    <tr>
                        <td>4</td>
                        <td> 
                            <input class="form-control" type="text" name="wsP4_id_'.$f['IdCon'].'" id="wsP4_id_'.$f['IdCon'].'"
                            title="Id del Cuarto Parametro"                    
                            value="'.$f['wsP4_id'].'"
                            >
                        </td>
    
                        <td> 
                            <input class="form-control" type="text" name="wsP4_value_'.$f['IdCon'].'" id="wsP4_value_'.$f['IdCon'].'"
                            title="Valor del Cuarto Parametro"                    
                            value="'.$f['wsP4_value'].'"
                            >
                        </td>
                    </tr>
    
                    </table>
    
                    </div>
                    ';
    
                    
    
                }
               

            }
            


            $ContenidoDelCard =  $ContenidoDelCard.'
            <hr style="
                border-color: #9a9b9b;
                border-style: dashed;
            ">


            <table width=100%><tr><td align=left>
               
            </td>

            <td align=right>
                    <button type="button" class="btn btn-success"  onclick="Active('.$f['IdCon'].');" >
                        <img src="icons/ok2.png" style="width:22px;">
                    </button>
            </td></tr></table>

            


            </form>
        
        
        ';
        AcordionCard($IdCard, $btnText, $IdCollapsed, $Color);
        AcordionCard_Data($IdCard, $ContenidoDelCard, $IdCollapsed, $Color);

       

    }
    echo '</div>';

    


    echo '<div id="Grafica" class="Panel">';
    echo 'Panel2';
    echo '</div>';




    

    echo "</center>";
   
} else {
    LocationFull("index.php");
}
?>

<script>
    function Active(IdCon){
        var IdUser = '<?php echo $RinteraUser; ?>'
        var Active = 0
        if( $('#Active_' + IdCon).prop('checked') ) {
            Active = 1
            $('#Card'+ IdCon).css('background-color','#d3f0cf')
            $('#Coll'+ IdCon).css('background-color','#d3f0cf')
            $('#Tit_'+ IdCon).html('['+IdCon+'] '+''+$('#ConName_'+IdCon).val())
            
        } else {      
            Active = 0      
            $('#Card'+ IdCon).css('background-color','#f4f4f4')
            $('#Coll'+ IdCon).css('background-color','#f4f4f4')
            $('#Tit_'+ IdCon).html('['+IdCon+'] '+''+$('#ConName_'+IdCon).val())
        }
        
        var ConType = $('#ConType_'+ IdCon).val();

        if (ConType <=1) {
            var dbhost = $('#dbhost_'+ IdCon).val();
            var dbuser = $('#dbuser_'+ IdCon).val();
            var dbname = $('#dbname_'+ IdCon).val();
            var dbpassword = $('#dbpassword_'+ IdCon).val();
            $('#PreLoader').show();
            var ConName = $('#ConName_'+IdCon).val();

                $.ajax({
                    url: 'custom_data.php',
                    type: 'post',        
                    data: {IdUser:IdUser, IdCon: IdCon, ConName: ConName, Active:Active, dbhost:dbhost, dbuser:dbuser, dbname:dbname, dbpassword:dbpassword},
                    success: function(data){
                        $('#R').html(data);
                        $('#PreLoader').hide();
                    }
                });
        } else {
            var wsmethod = $('#wsmethod_'+ IdCon).val();
            var wsurl = $('#wsurl_'+ IdCon).val();
            var ConName = $('#ConName_'+IdCon).val();

            var wsP1_id = $('#wsP1_id_'+IdCon).val();
            var wsP1_value = $('#wsP1_value_'+IdCon).val();

            var wsP2_id = $('#wsP2_id_'+IdCon).val();
            var wsP2_value = $('#wsP2_value_'+IdCon).val();

            var wsP3_id = $('#wsP3_id_'+IdCon).val();
            var wsP3_value = $('#wsP3_value_'+IdCon).val();

            var wsP4_id = $('#wsP4_id_'+IdCon).val();
            var wsP4_value = $('#wsP4_value_'+IdCon).val();

            
            $('#PreLoader').show();
                $.ajax({
                    url: 'custom_data.php',
                    type: 'post',        
                    data: {IdCon: IdCon, ConName: ConName, Active:Active, wsmethod:wsmethod, wsurl:wsurl,
                        wsP1_id:wsP1_id, wsP1_value: wsP1_value,
                        wsP2_id:wsP2_id, wsP2_value: wsP2_value,
                        wsP3_id:wsP3_id, wsP3_value: wsP3_value,
                        wsP4_id:wsP4_id, wsP4_value: wsP4_value

                        
                    },
                    success: function(data){
                        $('#R').html(data);
                        $('#PreLoader').hide();
                    }
                });
        }
        

       
    }

    function ActTit(IdCon){
        $('#Tit_'+ IdCon).html('['+IdCon+'] '+''+$('#ConName_'+IdCon).val())

    }
</script>
<div id='R' style='display:none;' >
</div>

</body>
</html>
