<?php              
    require_once("Clases.php");  
    $t = new MiniTemplator();
    $t->readTemplateFromFile ("../html/home_destacados.html");  
    $sql = new Consultas();
    $sql->setTable("destacados");
    $res = $sql->selectDestacadosPortada();

    while($fila = mysql_fetch_array($res)){

        $t->setVariable("img",$fila["nombre"]);
        $t->addBlock("Destacados"); 
    }
    
    $t->generateOutput();     
?>
