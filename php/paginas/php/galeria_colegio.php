  <?php
    require_once("../../../class/MiniTemplator.class.php");
    require_once("../../../class/Consultas.php");
    require_once("../../../class/Conexion.php");     
    $t = new MiniTemplator();
    require_once("home_header.php");
    require_once("home_menu.php");
    $t->readTemplateFromFile ("../html/galeria_colegio.html");

    $sql = new Consultas();
    $sql->setTable("destacados");
    $res= $sql->selectDestacados();
    while($fila = mysql_fetch_array($res)){
        
        $t->setVariable("id",$fila["id"]);
        $t->setVariable("nombre", $fila["nombre"]);        
        $t->addBlock("Thumbs");
        
    }
    
    $t->generateOutput();
        require_once("home_footer.php");   

?>


