<?php
$sombra = "
-webkit-box-shadow: inset 0px -36px 13px -31px rgba(0,0,0,0.39);
-moz-box-shadow: inset 0px -36px 13px -31px rgba(0,0,0,0.39);
box-shadow: inset 0px -36px 13px -31px rgba(0,0,0,0.39);
";


    echo "
    <div id='Welcome' style=''>
    <table width=100% border=0><tr>
    ";

    if (Preference("VisualLogo","","")=="TRUE"){
        echo "<td width=10px style='
        background-color: ".Preference("ColorPrincipal", "", "").";
        ".$sombra."
        '>";
        echo "<a href='index.php'>";
        $ArchivoLogo = "";
         if (Preference("LogoImagePNG","","")=="TRUE"){
            $ArchivoLogo = "img/Logo.png";
         } else {
            $ArchivoLogo = "img/Logo.jpg";
         }

         if (Preference("LogoColorInverso", "", "")=='TRUE') {
            echo "<img src='".$ArchivoLogo."' style='height:50px; padding:2px; filter: invert(100%) brightness(183%);'>";
         } else {
            echo "<img src='".$ArchivoLogo."' style='height:50px; padding:2px;'>";
         }
         echo "</a>";
        echo "</td>";
    }

    echo "
    <td 
 
    style='
    background-color: ".Preference("ColorPrincipal", "", "").";
    color: white;
    font-size: 13pt;
    text-align: left;
    ".$sombra."

    '>
    ";
    echo "<a style='
    display: block;
    color: white;
    font-family: ExtraBold;
    text-transform: uppercase;
    
    font-size: 10pt;
    margin-bottom: -10px


    ' href='index.php' title='Haz clic aqui para retomar al inicio'>".Preference("RinteraName","","")."</a>
    <cite style='font-size:8pt;'>".Preference("RinteraDescription","","")."</cite>
    </td>";




    echo "<td  valing=middle  style='
    text-align: right;
    background-color: ".Preference("ColorPrincipal", "", "").";
    color: white;
    padding-right: 15px;
    ".$sombra."
    '><img src='icons/atencion.png' style='width:17px;'><span class='pc'> ".$RinteraUserName."</span> </td>";


    if (UserAdmin($RinteraUser)==TRUE){
        echo "<td width=22px align=right 
        style='
        
        background-color: ".Preference("ColorPrincipal", "", "").";
        font-size: 10pt;
        color: white;
        ".$sombra."
        '
        >";
        
        echo "<a href='custom.php?db=' title='Haga clic aqui para ajustar las preferencias'>";
        echo " <img src='icons/config.png' style='width:22px; margin:3px;'> ";
        echo "</a>";
        
        echo "</td>";
    
    }
    

    $Pendientes = 3;

    if ($Pendientes >0 ){
        echo "
        <td  style='background-color:".Preference("ColorResaltado", "", "").";color:white; font-weight:bold;     ".$sombra."' align=center title='Pendientes por checar'>
        ".$Pendientes."
        </td>";

    } else {
        echo "
        <td width=0px  style='background-color:".Preference("ColorPrincipal", "", "").";     ".$sombra."' align=center>
        
        </td>";
    }


    echo "

    <td width=10px valign=midle style='background-color:".Preference("ColorPrincipal", "", "").";     ".$sombra."'>

    <a href='logout.php'  title='Cerrar Sessión de ".$RinteraUserName."'>    
    <img src='icons/salir2.png' style='width:17px;'></a>
    
    </td></tr>
    </table></div>
    ";

?>