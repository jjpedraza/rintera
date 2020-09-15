<?php
include ("head.php");

//consulta mediante DataFromMySQL
// $Query = "select nitavu, nombre from empleados limit 10"; 
// $ClaseDiv = "container"; $ClaseTabla = ""; 
// $IdCon = 1;  // Id de coneccion, de la tabla dbs
// $Tipo = 2; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
// $Tabla = DataFromMySQL($Query, $ClaseDiv,$ClaseTabla, $IdCon,$Tipo, $RinteraUser);
// echo $Tabla;


//Consulta mediante el Webservice
$WSTipo= 3; //0 = json del webservice, 1 = tabla html, 2 = DataTable, 3 pdf
$IdCon = 4; //Conecciones de la tabla dbs
$ClaseDiv = ""; $ClaseTabla = ""; //sugerencia= clase tabla
$IdUser = $RinteraUser;
echo DataFromSQLSERVERTOJSON($IdCon,"select top 15 IdLote,IdDelegacion,IdPrograma from lotes",$WSTipo,$ClaseTabla,$ClaseDiv, $RinteraUser);





function DataFromSQLSERVERTOJSON($IdCon, $Query, $Tipo, $ClaseTabla, $ClaseDiv, $IdUser)
{
//SQLSERVERTOJSON = https://github.com/prymecode/sqlservertojson
require("rintera-config.php");	

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
            case 0:
                return $archivo_web;
            break;

            case 1:          
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
                        $tabla_content.="<td>".$val."</td>";                       
                    $rowC = $rowC + 1;
                    $row = $row + 1;
                    }
                
                
                }
                
                
                $tabla.=$tabla_th.$tabla_content."</table>";                
                return $tabla;
                break;
        
                case 2: // Interactivo
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
                                
                                $tabla_th.="<td>".$key."</td>"; //cambiar th por td para datatable
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
        

                case 3: //PDF
                    
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

                        $titulo = "Titulo del Reporte";
                        $descripcion = "La Descripcion";
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
















function DataFromMySQL($Query, $ClaseDiv, $ClaseTabla, $IdCon, $Tipo, $IdUser){
    require("rintera-config.php");	
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
                    $titulo = "Titulo del Reporte";
                    $descripcion = "La Descripcion";
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
                
            default:

                
            }
            
            
            return $tbCont;
        

        

        } else {
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


include ("footer.php");
?>