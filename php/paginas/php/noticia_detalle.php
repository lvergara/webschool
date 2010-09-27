<?php
    require_once("Clases.php");     
    $t = new MiniTemplator();
    require_once("home_header.php");
    require_once("home_menu.php");
    $t->readTemplateFromFile ("../html/noticia_detalle.html");
    $sql = new Consultas();        
    $sql->setTable("noticias");
    
    $id = $_GET["id"];
    $res = $sql->selectNoticia($id);
     
    function cambiaf_a_normal($fecha){
        ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
        $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
        return $lafecha;
    } 


    while($fila = mysql_fetch_array($res)){

        $fecha = cambiaf_a_normal($fila["fecha"]);            
        $t->setVariable("titulo",$fila["titulo"]);
        $t->setVariable("fecha",$fecha);
        $t->setVariable("bajada",$fila["bajada"]);
        $t->setVariable("cuerpo",$fila["cuerpo"]);
        $t->setVariable("img",$fila["img"]);   
        $t->addBlock("Noticia");

    }
      


    $t->generateOutput(); 
    require_once("home_footer.php");
?>
