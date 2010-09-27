<?php   
    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1'){ 
        require_once("Clases.php");
        $t = new MiniTemplator();             
        require_once("bo_header.php");  
        $t->readTemplateFromFile ("../html/bo_editarPagina.html");
        $sql = new Consultas();    
        $id = $_GET["id"];

        if(isset($_POST["btnAgregar"]))                                    
        {
            $idP = $_POST["idP"];
            $pagina = $_POST["pagina"]; 
            $paginaANT = $_POST["paginaANT"]; 
            $titulo = $_POST["titulo"];
            $bajada = $_POST["bajada"];
            $cuerpo = $_POST["cuerpo"];
            $img = $_FILES['file']['name'];
            $imgANT = $_POST["imgANT"];  


            if($pagina=="" || $titulo=="" || $bajada =="" || $cuerpo ==""){

                $t->setVariable("mensaje","Error! Debe completar todos los campos");   
                $t->addBlock("Mensaje");

            }else{      
                if($img!=""){
                    //Imagen                   
                    $imgFile = $_FILES['file']['name'] ;
                    $imgFile = str_replace(' ','_',$imgName);
                    $tmp_name = $_FILES['file']['tmp_name'];
                    $tipo_archivo = $_FILES['file']['type']; 

                    if (!((strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo,"jpg")) ))
                    { 

                        $t->setVariable("mensaje","Imagen Subida Correctamente");

                    }else{

                        //subir fotos al servidor 
                        $nombre1 = $_FILES['file']['name'];    
                        $objImage = new SimpleImage();                                
                        $objImage->load($_FILES['file']['tmp_name']);
                        $objImage->setImgName($nombre1);                    
                        $objImage->save('../upload/fotos/paginas/'.$nombre1);    

                        $objImage2 = new SimpleImage();
                        $objImage2->load($_FILES['file']['tmp_name']);
                        $objImage2->setImgName($nombre1);
                        $objImage2->resize('50','50');            
                        $objImage2->save('../upload/fotos/paginas/mini_'.$nombre1);                                                   
                        @unlink($_FILES['file']['tmp_name']); 

                        $t->setVariable("mensaje","Se Guardo correctamente la imagen");
                    }

                }
                $t->addBlock("Mensaje");       

                //Fin Imagen    


                $sql->setTable("paginas");     
                if($img!=""){
                    $sql->actualizarPaginaConImg($pagina,$titulo,$bajada,$cuerpo,$img,$idP);
                    if($img!=$imgANT){
                        unlink("../../bo/upload/paginas/$imgANT"); 
                        unlink("../../bo/upload/paginas/mini_$imgANT");  

                    }

                }else{                         
                    $sql->actualizarPaginaSinImg($pagina,$titulo,$bajada,$cuerpo,$idP);          
                }

                if($pagina!=$paginaANT){
                    unlink("../../paginas/php/$paginaANT.php");  
                    unlink("../../paginas/html/$paginaANT.html");

                    //Crear Pagina html
                    require_once("pag_html.php");
                    $archivo = "../../paginas/html/$pagina.html";

                    $fp = fopen($archivo, "a");
                    $string = $html;
                    $write = fputs($fp, $string);
                    fclose($fp);  

                    //Crear Pagina php
                    require_once("pag_php.php");
                    $archivo = "../../paginas/php/$pagina.php";

                    $fp = fopen($archivo, "a");
                    $string = $php;
                    $write = fputs($fp, $string);
                    fclose($fp);  
                }



                $t->setVariable("mensaje","Página Correctamente Editada");
                $t->addBlock("Mensaje");

            }  
        }


        $sql->setTable("paginas");
        $res = $sql->selectPaginaId($id);

        while($fila = mysql_fetch_array($res)){

            $t->setVariable("id",$fila["idPagina"]);
            $t->setVariable("pagina",$fila["pagina"]);
            $t->setVariable("titulo",$fila["titulo"]);
            $t->setVariable("bajada",$fila["bajada"]);
            $t->setVariable("cuerpo",$fila["cuerpo"]);
            $t->setVariable("img",$fila["img"]);
            $t->addBlock("Pagina");       


        }

        $t->generateOutput(); 

        require_once("bo_footer.php"); 
    }else{
        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>";

    }
?>
