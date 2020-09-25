<?php
include ("head.php");
include ("header.php");

$id_rep = VarClean($_GET['id']);
$Tipo = ReporteTipo($id_rep); // $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
// var_dump($Tipo);
echo '<div class="row">';
$ClaseDiv  = "ContenedorDeReporte"; $ClaseTabla = "tabla";
    echo "<div id='C' style='
    width:100%;
    text-align:center;
    ' class='col-9'

    >";

    //1 detectar si hay interaccion de variables
    $sql = "select * from reportes where id_rep='".$id_rep."'";    
    $Reportes = $db0->query($sql);    
    if ($db0->query($sql) == TRUE){
        if($Rep = $Reportes -> fetch_array())
        {
            if ($Rep['var1'] == 1 || $Rep['var2'] == 1  || $Rep['var2'] == 1     ) {
               
               
                echo "<form id='FormVar' action='r.php?id=".$id_rep."' method='POST' style='
                width: 100%;
                padding: 10px;
                background-color: #ffffff5c;
                margin: 7px;
                border-radius: 8px;

                '>";
                echo "<h3>".$Rep['rep_name']."</h3>";
                echo "<cite>".$Rep['rep_description']."</cite>";
                echo "<p style='
                font-size: 10pt;
                font-weight: bold;
                text-align: left;
                '>Este Reporte Requiere los siguientes datos:</p>";

                if ($Rep['var1']==1){
                    echo "<div class='Elemento'>";
                    
                    echo "<label>".$Rep['var1_label']."</label>";
                    if ($Rep['var1_type']=="option"){
                        echo "<select name='var1_str' required>";
                            if ($Rep['ConType']<=1) {
                                

                            } else { //con webservice

                                
                            }

                        // $r= $db0 -> query($sql);
                        // while($f = $r -> fetch_array()) {               
                        //     echo "<option value='".$f['IdCon']."'>".$f['ConName']."</option>";
                        // }
                
                        // echo "<option>".$Rep['']."</option>";
                        
                        echo "</select>";

                    } else {
                        echo "<input class='form-control' type='".$Rep['var1_type']."' value='' name='var1_str' required>";
                    }
                    echo "</div>";
                }
                if ($Rep['var2']==1){
                    echo "<div class='Elemento'>";
                    echo "<label>".$Rep['var2_label']."</label>";
                    echo "<input class='form-control' type='".$Rep['var2_type']."' value='' name='var2_str' required>";
                    echo "</div>";
                }

                if ($Rep['var3']==1){
                    echo "<div class='Elemento'>";
                    echo "<label>".$Rep['var3_label']."</label>";
                    echo "<input class='form-control' type='".$Rep['var3_type']."' value='' name='var3_str' required>";
                    echo "</div>";
                }


                echo "<br><br><input type='submit' value='Preparar Reporte' class=' btn btn-success' name='btnReporte'>";
                

                echo "</form>";

                if (isset($_POST['btnReporte'])){
                    $Data =  Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $RinteraUser );
                    echo $Data;
                }
            } else { // Sin Variables
                $Data =  Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $RinteraUser );
                echo $Data;
            }

        } else {
            Error("No se encontro información el reporte ".$id_rep);
        }
        

    } else {
        Error("No se encontro el reporte ".$id_rep);
    }

   
    echo "</div>";




echo "<div class='col-3'>";
    UltimasBusquedas($RinteraUser);
echo "</div>";

echo "</div>";


include ("footer.php");
?>