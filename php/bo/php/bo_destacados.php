<?php  
    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1'){  

        require_once("Clases.php");
        $t = new MiniTemplator();        
        require_once("bo_header.php");       

        $t->readTemplateFromFile ("../html/bo_destacados.html");   

        //Rutas Imagenes
        $direct = "../upload/fotos/destacados/fullsize/";
        $mini = "../upload/fotos/destacados/mini/";    
        $directm = "../upload/fotos/destacados/thumbs/";   
        $directp = "../upload/fotos/destacados/portada/";       
        $sql = new Consultas();

        function getFileExtension($path)
        {
            $parts = pathinfo($path);
            return $parts['extension'];
        }

        //Eliminar
        if(isset($_POST["botonEliminar"]))
        {
            $aryEliminaNoticia = $_POST["aryEliminaNoticia"];
            if($aryEliminaNoticia==""){
                echo "No seleccionaste nada";
            }else{
                if($aryEliminaNoticia)
                {

                    $sql->setTable("destacados");
                    foreach($aryEliminaNoticia as $Noticia)
                    {

                        $res = $sql->selectDestacadoName($Noticia);
                        $sql->eliminarDestacado($Noticia);       
                        while($fila=mysql_fetch_array($res)){
                            unlink($direct.$fila["nombre"]);
                            $extension = getFileExtension($fila["nombre"]);
                            unlink($direct."mini_".$fila["nombre"].$extension);
                        }


                    } 
                }
            }
        }           

        //Seleccionar Fotos Portada
        if(isset($_POST["botonPortada"]))
        {
            $aryEliminaNoticia = $_POST["aryEliminaNoticia"];
            if($aryEliminaNoticia==""){
                echo "No seleccionaste nada";
            }else{
                if($aryEliminaNoticia)
                {

                    $sql->setTable("destacados");
                    foreach($aryEliminaNoticia as $Noticia)
                    {

                        $res = $sql->updateDestacado($Noticia);


                    } 
                }
            }
        }  

        //Sacar Fotos Portada
        if(isset($_POST["botonPortadaSacar"]))
        {
            $aryEliminaNoticia = $_POST["aryEliminaNoticia"];
            if($aryEliminaNoticia==""){
                echo "No seleccionaste nada";
            }else{
                if($aryEliminaNoticia)
                {

                    $sql->setTable("destacados");
                    foreach($aryEliminaNoticia as $Noticia)
                    {

                        $res = $sql->updateDestacadoSacar($Noticia);


                    } 
                }
            }
        } 


        //Insertamos Imagen
        if(isset($_POST["submit"])){

            $imgFile = $_FILES['file']['name'] ; 
            if($imgFile==""){

                $t->setVariable("mensaje","Error! Debe subir una imagen");   
                $t->addBlock("Mensaje");

            }else{                
                $imgFile = str_replace(' ','_',$imgName);
                $tmp_name = $_FILES['file']['tmp_name'];
                $tipo_archivo = $_FILES['file']['type']; 

                if (!((strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo,"jpg")) ))
                { 

                    $t->setVariable("mensaje","no se puede subir este archivo");

                }else{
                    //subir fotos al servidor
                    $sql->setTable("destacados");
                    $res = $sql->selectDestacado();
                    $fila = mysql_fetch_array($res);
                    $num = (int)$fila["id"];
                    $num = $num+1;
                    $nombre1 = $num;

                    $objImage = new SimpleImage();
                    $objImage->load($_FILES['file']['tmp_name']);
                    $objImage->setImgName($nombre1);
                    $objImage->resize('70','70');      
                    $objImage->save($mini."mini_".$nombre1); 

                    $objImage1 = new SimpleImage();
                    $objImage1->load($_FILES['file']['tmp_name']);
                    $objImage1->setImgName($nombre1);
                    $objImage1->resize('474','270');            
                    $objImage1->save($directp.$nombre1); 


                    $objImage2 = new SimpleImage();
                    $objImage2->load($_FILES['file']['tmp_name']);
                    $objImage2->setImgName($nombre1);
                    $objImage2->resize('179','100');            
                    $objImage2->save($directm.$nombre1); 


                    $sql->setTable("destacados");
                    $sql->insertDestacado($nombre1);

                    //copiar archivo
                    move_uploaded_file( $_FILES['file']['tmp_name'], $direct.$nombre1.".jpg" );
                    //borrar temp file
                    @unlink($_FILES['file']['tmp_name']); 

                    $t->setVariable("mensaje","Se Guardo correctamente la imagen");


                }

                $t->addBlock("Mensaje");   
            }




        } 
        //Mostrar Imagenes   
        $sql->setTable("destacados");
        $res = $sql->selectDestacados();

        $num_rows = mysql_num_rows($res);  

        While($fila = mysql_fetch_array($res)){
            $imagenUbicacion = $mini."mini_".$fila["nombre"];
            $t->setVariable("id_destacado",$fila["id"]);   
            $t->setVariable("imagen",$imagenUbicacion);
            if($fila["estado"]=="1"){
                $t->setVariable("mostrar","inline");
                $t->setVariable("msj","en portada");
            }else{
                $t->setVariable("mostrar","none");
            }
            $t->addBlock("Destacados");     

        }    

        $t->generateOutput(); 

        require_once("bo_footer.php"); 
    }else{
        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>";   


    }
?> 
   