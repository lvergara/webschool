<?php    
    require_once("Clases.php"); 
    require_once("home_header.php");
    $t = new MiniTemplator();
    $t->readTemplateFromFile ("../html/home_menu.html");     

    //Accesos a Base de datos
    $sql = new Consultas();

    $sql->setTable("menu");
    $res = $sql->selectMenus();


    while($fila = mysql_fetch_array($res)){
        $sql->setTable("submenu");
        $t->setVariable("menu",$fila["nombre"]);     
        $t->setVariable("link",$fila["enlace"]); 

        $res2 = $sql->selectSubMenus(); 

        while($fila2 = mysql_fetch_array($res2)){

            if($fila["idMenu"] == $fila2["idMenu"]){

                $sql->setTable("paginas");                    
                $res3 = $sql->selectPaginaId($fila2["idPagina"]);  
                $pagina = mysql_fetch_array($res3);
                $t->setVariable("enlace",$pagina["pagina"]);    
                $t->setVariable("submenu",$fila2["nombre"]); 
                $t->addBlock("SubMenu");                                        

            }       


        }
        $t->addBlock("Menu");         
    }                                                                       
    $t->generateOutput();              


?>
