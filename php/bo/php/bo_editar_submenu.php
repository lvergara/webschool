<?php
    session_start();    
    if(isset($_SESSION['usuario'])){ 

        require_once("Clases.php");
        $t = new MiniTemplator();  
        $sql = new Consultas(); 
        require_once("bo_header.php"); 
        $t->readTemplateFromFile ("../html/bo_editar_submenu.html");                                                                       
        if(isset($_POST["btnSubMenu"]))
        {                               
            $nombre = $_POST["nombre"]; 
            $enlace = $_POST["enlace"];
            $id = $_POST["id"];
            $sql->setTable("submenu");  
            $sql->updateSubMenus($nombre,$enlace,$id); 
            $t->setVariable("mensaje","Submenu correctamente ingresado");
            $t->addBlock("Mensaje");

        }          

        $sql->setTable("paginas");
        $res = $sql->selectAll();
        while($fila = mysql_fetch_array($res)){                 
            $t->setVariable("idPagina",$fila["idPagina"]);
            $t->setVariable("pagina",$fila["pagina"]);
            $t->addBlock("Paginas");
        }              



        $id = $_GET["id"];
        $submenu = $_GET["submenu"];  
        $enlace = $_GET["enlace"];
        $t->setVariable("id",$id);   
        $t->setVariable("submenu",$submenu);
        $t->setVariable("idPagina",$enlace);
        $t->addBlock("SubMenu");



        $t->generateOutput();              
        require_once("bo_footer.php"); 
    }else{                                
        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>";                
    }
?>
