<?php   
    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1'){ 
        require_once("Clases.php");
        $t = new MiniTemplator();             
        require_once("bo_header.php");  
        $t->readTemplateFromFile ("../html/bo_ingresarPagina.html");
        $sql = new Consultas();    

        if(isset($_POST["btnAgregar"]))                                    
        {
            $pagina = $_POST["pagina"]; 
            $titulo = $_POST["titulo"];
            $bajada = $_POST["bajada"];
            $cuerpo = $_POST["cuerpo"];
            $img = $_FILES['file']['name'];


            if($pagina=="" || $titulo=="" || $bajada =="" || $cuerpo =="" || $img==""){

                $t->setVariable("mensaje","Error! Debe completar todos los campos");   
                $t->addBlock("Mensaje");

            }else{      

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
                    $separar = explode('.',$nombre1);   


                    $objImage = new SimpleImage();                                
                    $objImage->load($_FILES['file']['tmp_name']);
                    $objImage->setImgName($nombre1);        
                    $objImage->getFileName();                                    
                    $objImage->save('../upload/fotos/paginas/'.$separar[0]);    

                    $objImage2 = new SimpleImage();
                    $objImage2->load($_FILES['file']['tmp_name']);
                    $objImage2->setImgName($nombre1);
                    $objImage2->resize('50','50');            
                    $objImage2->save('../upload/fotos/paginas/mini_'.$separar[0]); 


                    //copiar archivo
                    // move_uploaded_file( $_FILES['file']['tmp_name'], $direct.$nombre1 );
                    //borrar temp file
                    @unlink($_FILES['file']['tmp_name']); 

                    $t->setVariable("mensaje","Se Guardo correctamente la imagen");

                }
                $t->addBlock("Mensaje");       

                //Fin Imagen          

                $sql->setTable("paginas");     
                $sql->insertarPagina($pagina,$titulo,$bajada,$cuerpo,$img); 


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




                $t->setVariable("mensaje","Página Correctamente Ingresada");
                $t->addBlock("Mensaje");

            }  
        }

        $t->generateOutput(); 

        require_once("bo_footer.php"); 
    }else{
        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>";

    }
?>
