<?php

    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1'){ 
        require_once("Clases.php");
        $t = new MiniTemplator();             
        require_once("bo_header.php");  

        $t->readTemplateFromFile ("../html/bo_paginas.html");
        $sql = new Consultas();  

        if(isset($_POST["botonEliminar"]))
        {
            $aryEliminaNoticia = $_POST["aryEliminaNoticia"];
            if($aryEliminaNoticia==""){
                echo "No seleccionaste nada";
            }else{
                if($aryEliminaNoticia)
                {                 
                            
                    $sql->setTable("paginas");   

                    foreach($aryEliminaNoticia as $Noticia)
                    {

                        $res = $sql->selectPaginaId($Noticia);
                        $fila = mysql_fetch_array($res);
                        $img = $fila["img"]; 
                        $pagina = $fila["pagina"];
                        //Elimina foto pagina   
                        unlink("../upload/fotos/paginas/$img");                              unlink("../upload/fotos/paginas/mini_$img");      
                        //Elimina archivo pagina
                        unlink("../../paginas/php/$pagina.php");  
                        unlink("../../paginas/html/$pagina.html");                              

                        $sql->eliminarPagina($Noticia);  


                    } 
                }
            }
        }       
                                 

        $sql->setTable("paginas");
        $res = $sql->selectAll();

        while($fila = mysql_fetch_array($res)){

            $t->setVariable("id",$fila["idPagina"]);
            $t->setVariable("pagina",$fila["pagina"]); 
            $t->setVariable("titulo",$fila["titulo"]); 
            $t->setVariable("bajada",$fila["bajada"]); 
            $t->setVariable("cuerpo",$fila["cuerpo"]);
            $t->setVariable("img",$fila["img"]); 

            $t->addBlock("Paginas");    
        }
        $t->generateOutput(); 

        require_once("bo_footer.php");

    }else{
        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>";  

    } 
?>

