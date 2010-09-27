<?php
    session_start();    
    if(isset($_SESSION['usuario'])){ 

        require_once("Clases.php");
        $t = new MiniTemplator();             
        $t->readTemplateFromFile ("../html/bo_header.html"); 

        $t->setVariable("user",$_SESSION["usuario"]);
        $t->addBlock("User");

        $t->generateOutput();     
              


    }else{
        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>";   


    }

?>
