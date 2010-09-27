<?php   
    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1'){ 
        require_once("Clases.php");
        $t = new MiniTemplator();             
        require_once("bo_header.php");  
        $t->readTemplateFromFile ("../html/bo_noticiasIngreso.html");
        $sql = new Consultas();    

        if(isset($_POST["btnAgregar"]))                                    
        {

            $titulo = $_POST["titulo"];
            $bajada = $_POST["bajada"];
            $cuerpo = $_POST["cuerpo"];
            $img = $_FILES['file']['name'];

            if($titulo=="" || $bajada =="" || $cuerpo =="" || $img==""){

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

                    $t->setVariable("mensaje","Error al subir la imagen");

                }else{

  
                    //subir fotos al servidor 
                    $nombre1 = $_FILES['file']['name'];    
                    $separar = explode('.',$nombre1);   

                    
                    
                    $objImage = new SimpleImage();
                    $objImage->load($_FILES['file']['tmp_name']);
                    $objImage->setImgName($nombre1);
                    $objImage->resize('52','52');           
                    $objImage->save('../upload/fotos/noticias/'."mini_".$separar[0]);   

                    $objImage->load($_FILES['file']['tmp_name']);
                    $objImage->setImgName($nombre1);                    
                    $objImage->save('../upload/fotos/noticias/'.$separar[0]);     

                    //copiar archivo
                    move_uploaded_file( $_FILES['file']['tmp_name'], $direct.$separar[0] );
                    //borrar temp file
                    @unlink($_FILES['file']['tmp_name']); 

                    $t->setVariable("mensaje","Se Guardo correctamente la imagen");

                }
                $t->addBlock("Mensaje");       

                //Fin Imagen                

                $sql->setTable("noticias");

                $sql->insertNoticia($titulo,$bajada,$cuerpo,$img); 
                $t->setVariable("mensaje","Noticia Correctamente Ingresada");
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
