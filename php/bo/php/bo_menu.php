<?php
    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1'){ 

        require_once("Clases.php");
        $t = new MiniTemplator();             
        require_once("bo_header.php");  
        $t->readTemplateFromFile ("../html/bo_menu.html");

        $sql = new Consultas();  
        $sql->setTable("menu");
        $res =  $sql->despliegaMenus();                          

        While($fila = mysql_fetch_array($res)){

            $t->setVariable("id",$fila["idMenu"]);    
            $t->setVariable("nombre",$fila["nombre"]);
            $t->addBlock("Menu");

        }

        $t->generateOutput(); 

        require_once("bo_footer.php"); 
    }else{
        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>";   
    }
?>
