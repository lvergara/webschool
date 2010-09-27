<?php   
    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1'){ 
        require_once("Clases.php");
        $t = new MiniTemplator();             
        require_once("bo_header.php");   

        $t->readTemplateFromFile ("../html/bo_noticias.html");
        $sql = new Consultas();  

        if(isset($_POST["botonEliminar"]))
        {
            $aryEliminaNoticia = $_POST["aryEliminaNoticia"];
            if($aryEliminaNoticia==""){
                echo "No seleccionaste nada";
            }else{
                if($aryEliminaNoticia)
                {                      
                    $sql->setTable("noticias");

                    foreach($aryEliminaNoticia as $Noticia)
                    {
                        $res = $sql->selectNoticia($Noticia);
                        $fila = mysql_fetch_array($res);
                        $img = $fila["img"]; 

                        //Elimina foto pagina     
                        unlink("../upload/fotos/noticias/$img");     
                        unlink("../upload/fotos/noticias/mini_$img");     

                        $sql->eliminarNoticia($Noticia);


                    } 
                }
            }
        }        



        $sql->setTable("noticias");
        $res = $sql->selectTodo();

        while($fila = mysql_fetch_array($res)){

            $t->setVariable("id",$fila["idNoticia"]);
            $t->setVariable("titulo",$fila["titulo"]); 
            $t->setVariable("bajada",$fila["bajada"]); 
            $t->setVariable("cuerpo",$fila["cuerpo"]);
            $t->setVariable("img",$fila["img"]); 
            $t->setVariable("fecha",$fila["fecha"]);  

            $t->addBlock("Noticias");       


        }

        $t->generateOutput(); 

        require_once("bo_footer.php");

    }else{
        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>";  

    } 
?>

