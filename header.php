<?php


if ($PublicIndex == TRUE){



    echo "
    <div id='Welcome' style=''>
    <table width=100%><tr>
    
    <td style='
    background-color: #16799f;
    color: white;
    font-size: 13pt;
    text-align: center;

    '>
    ";
    echo "<a style='
    display: block;
    color: white;
    font-family: ExtraBold;
    text-transform: uppercase;
    
    font-size: 13pt;


    ' href='index.php' title='Haz clic aqui para retomar al inicio'>".$Cliente."</a></td>";
    echo "<td class='pc' style='
    
    background-color: #1487b5;
    font-size: 10pt;
    color: white;
    '><cite>".$ClienteInfo."</cite></td>";
    // echo "<hr><b style='cursor:pointer;' title='No. de Empleado = ".$RinteraUser."'>".$RinteraUserName."</b>";    
    echo "
    </td>
    "."<td valing=middle  style='
    text-align: right;
    background-color: #1487b5;
    color: #fbb373;
    padding-right: 15px;
    '><img src='icons/atencion.png' style='width:17px;'><span class='pc'> ".$RinteraUserName."</span></td>";

    $Pendientes = 3;

    if ($Pendientes >0 ){
        echo "
        <td width=50px  style='background-color:#ff7800;color:white; font-weight:bold' align=center title='Pendientes por checar'>
        ".$Pendientes."
        </td>";

    } else {
        echo "
        <td width=0px  style='background-color:#1487b5;' align=center>
        
        </td>";
    }


    echo "

    <td width=10px valign=midle style='background-color:#b75906;'>

    <a href='logout.php'  title='Cerrar Sessión de ".$RinteraUserName."'>    
    <img src='icons/salir2.png' style='width:17px;'></a>
    
    </td></tr>
    </table></div>
    ";

} else {
    echo "
    <div id='Welcome'>Acceso abierto al publico</div>";
}
?>