<?php
include ("head.php");

$Query = "select nitavu, nombre from empleados"; $ClaseDiv = "container"; $ClaseTabla = ""; $IdCon = 1; 
$Tipo = 1; // 0 = html, 1= build, 2 = PDF, 3 = Excel, 4 = Word
$Tabla = TableFromMySQL($Query, $ClaseDiv,$ClaseTabla, $IdCon,$Tipo);
if ($Tabla <> FALSE){
    echo $Tabla;
} else {
    echo "Error";
}



function TableFromMySQL($Query, $ClaseDiv, $ClaseTabla, $IdCon, $Tipo){
    require("rintera-config.php");	
    $TablaHTML = "";


    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ; 
    $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdTabla = $STR;
    
    // echo "IdDiv=".$IdDiv."<br>"."IdTabla=".$IdTabla."<br>";

    
$Con_IdCon = $IdCon; include("con_init.php");

if ($Con_Val == TRUE){    
    if ($r = $LaConeccion -> query($Query)){
        if($f = $r -> fetch_array()){
        
            // var_dump($f);

            $tbCont = '<div id="'.$IdDiv.'" class="'.$ClaseDiv.'">
            <table id="'.$IdTabla.'"  style="width:100%" class="'.$ClaseTabla.'" style="font-size:8pt;">';
            $tabla_titulos = ""; $cuantas_columnas = 0;
            $r2 = $LaConeccion -> query($Query); while($finfo = $r2->fetch_field())
            {//OBTENER LAS COLUMNAS

                    /* obtener posición del puntero de campo */
                    $currentfield = $r2->current_field;       
                    $tabla_titulos=$tabla_titulos."<th >".$finfo->name."</th>";
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
                    $tbCont = $tbCont."<td >".$f[$i-1]."</td>";       
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
                
            default:

                
            }
            
            
            return $tbCont;
        

        

        } else {
            return FALSE;
        }
    } else {
        return FALSE;
        // echo "Error en la base de datos";
    }
    
    
} else {
    return FALSE;
    // echo "ERROR: ".$Con_Msg;
}



include("con_close.php");





	
	// if ($db == 0){
    //     $r= $db0 -> query($sql);
    





	// if ($db == 1){

    //     $r1= $db1 -> query($sql);
    //     $tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'">
    //     <table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" style="font-size:8pt;">';
    // $tabla_titulos = ""; $cuantas_columnas = 0;
    //     $r1_1 = $db1 -> query($sql); while($finfo = $r1_1->fetch_field())
    //     {//OBTENER LAS COLUMNAS

    //             /* obtener posición del puntero de campo */
    //             $currentfield = $r1_1->current_field;       
    //             $tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
    //             $cuantas_columnas = $cuantas_columnas + 1;        
    //     }

    //     $tbCont = $tbCont."  
    //     <thead>
    //     <tr>
    //         ".$tabla_titulos."  
    //     </tr>
    //     </thead>"; //Encabezados
    //     $tbCont = $tbCont."<tbody class='tabla'>";
    //     $cuantas_filas=0;
    //     $r1 = $db1 -> query($sql); while($f1 = $r1-> fetch_row())
    //     {//LISTAR COLUMNAS

    //         $tbCont = $tbCont."<tr>";        
    //         for ($i = 1; $i <= $cuantas_columnas; $i++) {      
    //             $tbCont = $tbCont."<td style='font-size:10pt;'>".$f1[$i-1]."</td>";       
    //             }

    //         $tbCont = $tbCont."</tr>";
    //         $cuantas_filas = $cuantas_filas + 1;        
    //     }

    //     $tbCont = $tbCont."</tbody>";
    //     $tbCont = $tbCont."</table></div>";
	

    // }


    // if ($db == 0 OR $db==1){
	// echo  $tbCont;
	// 	switch ($Tipo) {
	// 		case 1: //Scroll Vertical
	// 				echo '<script>
	// 				$(document).ready(function() {
	// 					$("#'.$IdTabla.'").DataTable( {
	// 						"scrollY":        "200px",
	// 						"scrollCollapse": true,
	// 						"paging":         false,
	// 						"language": {
	// 							"decimal": ",",
	// 							"thousands": "."
	// 						}
	// 					} );
	// 				} );
	// 				</script>';
	// 			break;

	// 		case 2: //Scroll Horizontal
	// 				echo '<script>
	// 				$(document).ready(function() {
	// 					$("#'.$IdTabla.'").DataTable( {
	// 						"scrollX": true,
	// 						"scrollCollapse": true,
	// 						"paging":         true,
	// 						"language": {
	// 							"decimal": ",",
	// 							"thousands": "."
	// 						}
	// 					} );
	// 				} );
	// 				</script>';
	// 			break;
			
	// 		default:
	// 			echo '<script>
	// 			$(document).ready(function() {
	// 				$("#'.$IdTabla.'").DataTable( {
	// 					"language": {
	// 						"decimal": ",",
	// 						"thousands": "."
	// 					}
	// 				} );
	// 			} );
	// 			</script>';
	// 	}
    // } else {
    // 	echo "Error: no se ha seleccionado una db para la Tabla Dinamica";
    // }

}

include ("footer.php");
?>