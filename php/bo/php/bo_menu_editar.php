<?php      
    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1'){ 

        require_once("Clases.php");
        $t = new MiniTemplator();             
        require_once("bo_header.php");  
        $t->readTemplateFromFile ("../html/bo_menu_editar.html");
        $id = $_GET["id"];
        $sql = new Consultas(); 

        if(isset($_POST["btnBorrar"]))
        {              
            $Noticia = $_POST["id"];
            $sql->setTable("submenu");         
            $sql->eliminarMenu($Noticia);  


        }          

        if(isset($_POST["btnSubMenu"]))
        {
            $idMenu = $id;     
            $nombre = $_POST["nombre"];
            $enlace = $_POST["enlace"];      
            $sql->setTable("submenu");   
            $sql->insertSubMenu($nombre,$enlace,$idMenu); 
            $t->setVariable("mensaje","Submenu correctamente ingresado");
            $t->addBlock("Mensaje");

        }      

        $sql->setTable("paginas");
        $res = $sql->selectAll();
        while($fila = mysql_fetch_array($res)){       
            $t->setVariable("id",$id);
            $t->addBlock("Id");            
            $t->setVariable("idPagina",$fila["idPagina"]);
            $t->setVariable("pagina",$fila["pagina"]);
            $t->addBlock("Paginas");
        }


        $sql->setTable("menu");
        $res = $sql->selectMenu($id);

        $sql->setTable("submenu");
        while($fila = mysql_fetch_array($res)){

            $t->setVariable("nombreMenu",$fila["nombre"]);      

            $res2 = $sql->selectSubMenus(); 

            while($fila2 = mysql_fetch_array($res2)){

                if($fila["idMenu"] == $fila2["idMenu"]){
                    $t->setVariable("idsubmenu",$fila2["idSubmenu"]);  
                    $t->setVariable("idMenuSub",$fila2["idMenu"]);        
                    $t->setVariable("submenu",$fila2["nombre"]);
                    $sql->setTable("paginas");
                    $res3 = $sql->selectPaginaId($fila2["idPagina"]);
                    $fila3 = mysql_fetch_array($res3);
                    $t->setVariable("pagina",$fila3["pagina"]);   
                    $t->setVariable("idPagina",$fila2["idPagina"]);    

                    $t->addBlock("SubMenu");                                        
                }                         
            }
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
