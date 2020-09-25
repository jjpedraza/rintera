<?php     include("head.php"); ?>
<div id='PreLoader'>
    <div id='Loader'>
        <img src='img/loader_classic.gif'><br>      
    </div>
</div>


<?php
//TOKENS
$MiToken = MiToken($RinteraUser, "Edit");
// if ($MiToken == ''){
//     $MiToken = MiToken_Init($RinteraUser, "Edit");
// }
// echo "Token: ".$MiToken;




include ("header.php");

?>


<?php
if (UserAdmin($RinteraUser)==TRUE){
  if (isset($_GET['id'])){
    $IdRep = VarClean($_GET['id']);
  }
  else {
    LocationFull("index.php");
  }
    

  $sql = "select * from reportes WHERE id_rep='".$IdRep."'";
  
  $rP= $db0 -> query($sql);  
  if($fRep = $rP -> fetch_array())
  {
      
    echo "<div id='NuevoReporte' >";
    echo "<h3 style='text-align: center;
    color: #fff;
    background-color: rgb(24, 149, 198);
    font-size: 13pt;
    padding: 10px; margin-bottom:0px;
    font-family: ExtraBold' title='ID de Reporte = ".$fRep['id_rep']."'>Reporte ".$fRep['rep_name']."</h3>";
    echo "<div id='R' style='background-color: #fdf6e7;
    padding: 10px;'></div>";

    
   echo '
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8" style="" >
        
        ';

        echo "<br><label>Nombre del Reporte:</label>";
        echo "<input class='form-control' type='text' name='rep_name' id='rep_name' value='".$fRep['rep_name']."'>";

        echo "<br><label>Descripción del Reporte:</label>";
        echo "<input class='form-control' type='text' name='rep_description' id='rep_description' value='".$fRep['rep_description']."'>";

        echo '<br>
        <label>Consulta a la Base de Datos: (solo comillas dobles ) <br>
        
        <b>Ejemplo:</b> 
        <cite>select * from mitabla where parametro=<b style="color:blue">{var1}</b>  and otroparametro=1</cite>
        </label>
        <textarea  id="rep_query" rows=10 style="background-color: #272822;
        color: #cccc82;"
        class="Query form-control">'.$fRep['sql1'].'</textarea>
        ';

        
        echo "<br><label>¿Que base de datos usara la consulta? </label> <select id='db' class='form-control' name='db'>";      
        
        $r= $db0 -> query("select * from dbs where Active=1");    
        while($finfo = $r -> fetch_array()) {   
            echo "<option value='".$finfo['IdCon']."'>".$finfo['ConName']."</opion>";
        }
        echo "<option style='background-color:orange;color:white;' 
        value='".$fRep['IdCon']."' selected>".ConName($fRep['IdCon'])."</opion>";
        echo "</select>";
        unset($r); unset($finfo);
        


        echo "<br><label>Orientación</label><br>";
        
        echo "<select name='Orientacion' class='form-control' id='Orientacion'>";
        if ($fRep['orientacion']=='L'){
            echo "<option value='L' selected>Horizontal</option>";
        } else {
            echo "<option value='L'>Horizontal</option>";
        }

        if ($fRep['orientacion']=='P'){
            echo "<option value='P' selected>Vertical</option>";
        } else {
            echo "<option value='P'>Vertical</option>";
        }

        
        
        
        echo "</select>";

        echo "<br><label>Tamaño de Pagina</label><br>";
        echo "<select name='PageSize' class='form-control' id='PageSize'>";
        if ($fRep['PageSize']=='0'){
            echo "<option value='0' selected>Carta</option>";
        } else {
            echo "<option value='0'>Carta</option>";
        }


        if ($fRep['PageSize']=='1'){
            echo "<option value='1' selected>Oficio</option>";
        } else {
            echo "<option value='1'>Oficio</option>";
        }



        
        echo "</select>
        
        
        
        ";
        
        echo '
        </div>
        <div class="col-sm-4" 
        style="
        background-color: #eceeee;
        height:100%;
        "
        >
        <center><b style="color: #ff7800;
        font-size: 10pt;">Configuracion de las variables:</b></center>
        <div id="accordion">
        <div class="card">
        <div class="card-header DivVar1" id="headingOne">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
            style="
                display: block;
                width: 100%;
            "
            >
                {var1}
            </button>
            </h5>
        </div>
    
        <div id="collapseOne" style="background-color:rgb(218, 220, 221);"
         class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
            
            <br><label>¿Utilizaras var1?</label>
            <select name="var1" class="form-control"  style="background-color:orange; color:white;" id="var1" onclick="Var1_ON();">
            ';
            if ($fRep['var1']=='0'){
                echo '<option value="0" selected>NO</option>';
            } else {
                echo '<option value="0" >NO</option>';
            }
            if ($fRep['var1']=='1'){
                echo '<option value="1" selected>SI</option>';
               
            } else {
                echo '<option value="1" >SI</option>';
            }
            


            echo '
            </select>';

            echo '
            <script>
                function Var1_ON(){
                    Var1 =  $("#var1").val();
                    console.log(Var1);
                    if ( Var1 == 1 ){
                        $(".DivVar1").css("background-color", "#bbdb76");                
                    } else {
                        $(".DivVar1").css("background-color", "white");                
                    }
                }
                Var1_ON();

            </script>';

            echo '
            

            <br><label>Tipo:</label>
            <select name="var1_type"  id="var1_type" class="form-control" onclick="Activardb1();">';

            
            if ($fRep['var1_type']=='text'){
                echo '<option value="text" selected>Texto</option>';
            } else {
                echo '<option value="text" >Texto</option>';
            }

            if ($fRep['var1_type']=='number'){
                echo '<option value="number" selected>Numero</option>';
            } else {
                echo '<option value="number" >Numero</option>';
            }

            if ($fRep['var1_type']=='date'){
                echo '<option value="date" selected>Fecha</option>';
            } else {
                echo '<option value="date" >Fecha</option>';
            }

            if ($fRep['var1_type']=='option'){
                echo '<option value="option"  selected>Lista desplegable</option>';
            } else {
                echo '<option value="option">Lista desplegable</option>';
            }

            

            echo '
          
            </select>';

            


            echo "<span id='db1'><br><label>¿Desde que base de datos? </label> <select id='var1_IdCon' class='form-control' name='var1_IdCon'>";      
        
            $rg= $db0 -> query("select * from dbs where Active=1");    
            while($finfo = $rg -> fetch_array()) {   
                echo "<option value='".$finfo['IdCon']."'>".$finfo['ConName']."</opion>";
            }
            echo "<option style='background-color:orange;color:white;' 
            value='".$fRep['var1_IdCon']."' selected>".ConName($fRep['var1_IdCon'])."</opion>";
            echo "</select></span>";
            unset($rg); unset($finfo);
            
    

            echo '




            <br><label>Texto para mostrar:</label>';

            echo '
            <input type="text" class="form-control" name="var1_label" id="var1_label" value="'.$fRep['var1_label'].'">

            <br><label>Consulta de llenado (MySQL): <cite>Los controles buscaran value y data, tomalo en cuenta</cite></label>
            <textarea name="var1_sql" id="var1_sql" class="Query form-control" style="background-color: #c3c6b1;
            color: #304a4d;">'.$fRep['var1_sql'].'</textarea>';

            echo '
            <script>
            function Activardb1(){
                // console.log($("#var1_type option:selected").val());
                if ($("#var1_type option:selected").val() == "option"){
                    $("#db1").show();
                } else {
                    $("#db1").hide();
                }    
                
            }
            Activardb1();
            </script>
            ';


            echo '






            </div>
        </div>
        </div>


        <div class="card">
        <div class="card-header DivVar2" id="headingTwo">
            <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
            style="
                display: block;
                width: 100%;
            "
            >
                {var2}
            </button>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="background-color:rgb(218, 220, 221);">
            <div class="card-body">

            <br><label>¿Utilizaras var2?</label>
            <select name="var1" class="form-control"  style="background-color:orange; color:white;" id="var2" onclick="Var2_ON();">
            ';
            if ($fRep['var2']=='0'){
                echo '<option value="0" selected>NO</option>';
            } else {
                echo '<option value="0" >NO</option>';
            }
            if ($fRep['var2']=='1'){
                echo '<option value="1" selected>SI</option>';
            } else {
                echo '<option value="1" >SI</option>';
            }
            
            echo '
            </select>';

            echo '
            <script>
                function Var2_ON(){
                    Var2 =  $("#var2").val();
                    console.log(Var2);
                    if ( Var2 == 1 ){
                        $(".DivVar2").css("background-color", "#bbdb76");                
                    } else {
                        $(".DivVar2").css("background-color", "white");                
                    }
                }
                Var2_ON();

            </script>';

            echo '
            

            <br><label>Tipo:</label>
            <select name="var2_type"  id="var2_type" class="form-control"  onclick="Activardb2();">';

            
            if ($fRep['var2_type']=='text'){
                echo '<option value="text" selected>Texto</option>';
            } else {
                echo '<option value="text" >Texto</option>';
            }

            if ($fRep['var2_type']=='number'){
                echo '<option value="number" selected>Numero</option>';
            } else {
                echo '<option value="number" >Numero</option>';
            }

            if ($fRep['var2_type']=='date'){
                echo '<option value="date" selected>Fecha</option>';
            } else {
                echo '<option value="date" >Fecha</option>';
            }

            if ($fRep['var2_type']=='option'){
                echo '<option value="option" selected>Lista desplegable</option>';
            } else {
                echo '<option value="option" >Lista desplegable</option>';
            }

            echo "</select>";

            echo "<span id='db2'><br><label>¿Desde que base de datos? </label> 
            <select id='var2_IdCon' class='form-control' name='var2_IdCon''>";      
        
            $rg= $db0 -> query("select * from dbs where Active=1");    
            while($finfo = $rg -> fetch_array()) {   
                echo "<option value='".$finfo['IdCon']."'>".$finfo['ConName']."</opion>";
            }
            echo "<option style='background-color:orange;color:white;' 
            value='".$fRep['var2_IdCon']."' selected>".ConName($fRep['var2_IdCon'])."</opion>";
            echo "</select></span>";
            unset($rg); unset($finfo);

            echo '
            <script>
            function Activardb2(){
                // console.log($("#var1_type option:selected").val());
                if ($("#var2_type option:selected").val() == "option"){
                    $("#db2").show();
                } else {
                    $("#db2").hide();
                }    
                
            }
            Activardb2();
            </script>
            ';

            echo '
          
           

            <br><label>Texto para mostrar:</label>';

            echo '
            <input type="text" class="form-control" name="var2_label" id="var2_label" value="'.$fRep['var2_label'].'">

            <br><label>Consulta de llenado (MySQL): <cite>Los controles buscaran value y data, tomalo en cuenta</cite></label>
            <textarea name="var2_sql" id="var2_sql" class="Query form-control" style="background-color: #c3c6b1;
            color: #304a4d;">'.$fRep['var2_sql'].'</textarea>








            </div>
        </div>
        </div>
        <div class="card">
        <div class="card-header DivVar3" id="headingThree">
            <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"
            style="
                display: block;
                width: 100%;
            "
            >
                {var3}
            </button>
            </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion" style="background-color:rgb(218, 220, 221);"> 
            <div class="card-body">
            <br><label>¿Utilizaras var3?</label>
            <select name="var3" class="form-control"  style="background-color:orange; color:white;" id="var3" onclick="Var3_ON();">
            ';
            if ($fRep['var3']=='0'){
                echo '<option value="0" selected>NO</option>';
            } else {
                echo '<option value="0" >NO</option>';
            }
            if ($fRep['var3']=='1'){
                echo '<option value="1" selected>SI</option>';
            } else {
                echo '<option value="1" >SI</option>';
            }
            
            echo '
            </select>';

            echo '
            <script>
                function Var3_ON(){
                    Var3 =  $("#var3").val();
                    console.log(Var3);
                    if ( Var3 == 1 ){
                        $(".DivVar3").css("background-color", "#bbdb76");                
                    } else {
                        $(".DivVar3").css("background-color", "white");                
                    }
                }
                Var3_ON();

            </script>';

            echo '
            

            <br><label>Tipo:</label>
            <select name="var3_type"  id="var3_type" class="form-control" onclick="Activardb3();">';

            
            if ($fRep['var3_type']=='text'){
                echo '<option value="text" selected>Texto</option>';
            } else {
                echo '<option value="text" >Texto</option>';
            }

            if ($fRep['var3_type']=='number'){
                echo '<option value="number" selected>Numero</option>';
            } else {
                echo '<option value="number" >Numero</option>';
            }

            if ($fRep['var3_type']=='date'){
                echo '<option value="date" selected>Fecha</option>';
            } else {
                echo '<option value="date" >Fecha</option>';
            }

            if ($fRep['var3_type']=='option'){
                echo '<option value="option" selected>Lista desplegable</option>';
            } else {
                echo '<option value="option" >Lista desplegable</option>';
            }
            echo "</select>";
            
            echo "<span id='db3'><br><label>¿Desde que base de datos? </label>
             <select id='var3_IdCon' class='form-control' name='var3_IdCon' >";      
        
            $rg= $db0 -> query("select * from dbs where Active=1");    
            while($finfo = $rg -> fetch_array()) {   
                echo "<option value='".$finfo['IdCon']."'>".$finfo['ConName']."</opion>";
            }
            echo "<option style='background-color:orange;color:white;' 
            value='".$fRep['var3_IdCon']."' selected>".ConName($fRep['var3_IdCon'])."</opion>";
            echo "</select></span>";
            unset($rg); unset($finfo);


            echo '
            <script>
            function Activardb3(){
                // console.log($("#var1_type option:selected").val());
                if ($("#var3_type option:selected").val() == "option"){
                    $("#db3").show();
                } else {
                    $("#db3").hide();
                }    
                
            }
            Activardb3();
            </script>
            ';

            echo '
          
           

            <br><label>Texto para mostrar:</label>';

            echo '
            <input type="text" class="form-control" name="var3_label" id="var3_label" value="'.$fRep['var3_label'].'">

            <br><label>Consulta de llenado (MySQL): <cite>Los controles buscaran value y data, tomalo en cuenta</cite></label>
            <textarea name="var3_sql" id="var3_sql" class="Query form-control" style="background-color: #c3c6b1;
            color: #304a4d;">'.$fRep['var3_sql'].'</textarea>









            </div>
        </div>
        </div>

        
    </div>';
    echo "<br><label>Formato:</label><br>";
    echo "<select name='Formato' id='Formato' class='form-control'>";
    echo "<option value='0'>HTML</option>";
    echo "<option value='1'>DataTable</option>";
    echo "<option value='2'>PDF</option>";
    echo "<option value='3'>Excel</option>";
    echo "<option value='4'>Word</option>";


    switch ($fRep['out_type']) {
        case 0:
            echo "<option value='0' selected >HTML</option>";
            break;
        case 1:
            echo "<option value='1' selected>DataTable</option>";
            break;
        case 2:
            echo "<option value='2' selected>PDF</option>";
            break;
        case 3:
            echo "<option value='3' selected>Excel</option>";
            break;
        case 4:
            echo "<option value='4' selected>Word</option>";
            break;
    }


    
    echo "</select>";




    if ($UsuariosForaneaos == "FALSE"){
        echo "<br><label>Usuario Administrador: <a href='users.php' title='Haga clic para administrar los usuarios'><img src='icons/user_add.png' style='width:17px;'></a></label><br>";
        echo "<select name='ReporteIdUser' id='ReporteIdUser' class='form-control'>";
        echo "<option value=''>Seleccione</option>";         
    } else {
        echo "<br><label>Usuario Administrador: </label><br>";
        echo "<select name='ReporteIdUser' id='ReporteIdUser' class='form-control'>";
        echo "<option value=''>Seleccione</option>";        
    }
       

    if ($UsuariosForaneaos == "FALSE") {
        $sql = "select * from users";
    } else {
        $sql = $QueryUsuariosForaneos . " order by UserName";
    }
    echo $sql;
    $rc = $dbUser->query($sql); 
    $SelUser_IdUser = "";
    $SelUser_Name = "";
    if ($dbUser->query($sql) == TRUE){
        // echo "OK";
        while($fu= $rc -> fetch_array()) {   
            echo "<option value='".$fu['IdUser']."' title='IdUser=".$fu['IdUser']."'>".$fu['UserName']."</option>";
            if ($fu['IdUser']==$fRep['admin']){
                $SelUser_IdUser = $fu['IdUser'];
                $SelUser_Name = $fu['UserName'];
            }
        }
        
        echo "<option value='".$SelUser_IdUser."' title='IdUser seleccionado=".$SelUser_IdUser."' selected>".$SelUser_Name."</option>";

    } else {
        Toast("ERROR al obtener la lista de usuarios",3,"");
    }

    

    
    
    
    echo "</select>";


    echo '
        <br><br><br>';
        echo "
        <script>
        
        function SendData(){   
            var rep_name = $('#rep_name').val();
            var rep_descripcion = $('#rep_description').val();
            var rep_query = $('#rep_query').val();
            var db = $('#db').val();
            var Orientacion = $('#Orientacion').val();
            var PageSize = $('#PageSize').val();
            var Formato = $('#Formato').val();

            //Var1
            var var1 = $('#var1').val();
            var var1_type = $('#var1_type').val();
            var var1_label = $('#var1_label').val();
            var var1_sql = $('#var1_sql').val();


            //Var2
            var var2 = $('#var2').val();
            var var2_type = $('#var2_type').val();
            var var2_label = $('#var2_label').val();
            var var2_sql = $('#var2_sql').val();


            //Var3
            var var3 = $('#var3').val();
            var var3_type = $('#var3_type').val();
            var var3_label = $('#var3_label').val();
            var var3_sql = $('#var3_sql').val();


            var var1_IdCon = $('#var1_IdCon').val();
            var var2_IdCon = $('#var2_IdCon').val();
            var var3_IdCon = $('#var3_IdCon').val();

            var ReporteIdUser = $('#ReporteIdUser').val();

            

            


            $('#PreLoader').show();
            $.ajax({
                url: 'editdata.php',
                type: 'post',        
                data: {IdUser:'".$RinteraUser."', Token: '".$MiToken."', IdRep:'".$IdRep."',
                    ReporteIdUser: ReporteIdUser,
                    rep_name: rep_name,
                    rep_descripcion: rep_descripcion,
                    rep_query: rep_query,
                    db: db,
                    Orientacion: Orientacion,
                    PageSize: PageSize,
                    var1:var1,
                    var1_type:var1_type,
                    var1_label:var1_label,
                    var1_sql:var1_sql,

                    var2:var2,
                    var2_type:var2_type,
                    var2_label:var2_label,
                    var2_sql:var2_sql,

                    var3:var3,
                    var3_type:var3_type,
                    var3_label:var3_label,
                    var3_sql:var3_sql,
                    Formato:Formato,

                    var1_IdCon: var1_IdCon,
                    var2_IdCon: var2_IdCon,
                    var3_IdCon: var3_IdCon,
                    ReporteIdUser:ReporteIdUser


        
                },
                success: function(data){
                    $('#R').html(data);
                    $('#PreLoader').hide();
                }
            });
            
        }
        
        
        </script>
        ";

        
        // if (MiToken_valida($MiToken, $RinteraUser, "Nuevo")==TRUE){//Valido
            echo '
                <center><button class="Mbtn btn-Primary" style="font-size:13pt;font-family:ExtraBold" onclick="SendData();">Actualizar</button></center>
                ';
        
        // } else { //No Valido
            

        // }
    
    echo '
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
    </div>
</div>';
    //echo "</form>";
} else {
    // Toast("No se ha localizado tu Reporte ".$IdRep,2,"");
    LocationFull("index.php?e1=".$IdRep."");
}
    
} else {
    LocationFull("index.php");
}
?>



<?php include ("footer.php"); ?>