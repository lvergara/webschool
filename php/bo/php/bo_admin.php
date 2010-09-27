<?php  
    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1'){ 

        require_once("Clases.php");
        $t = new MiniTemplator();             
        require_once("bo_header.php");   
        $t->readTemplateFromFile ("../html/bo_admin.html");   
        $t->generateOutput();
        require_once("bo_footer.php");      


    }else{
        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>";   


    }


?>                
           


