<?php 
    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1' or $_SESSION['permiso'] == '3'){   
        require_once("Clases.php");
        $t = new MiniTemplator();     
        require_once("bo_header.php");  
        $t->readTemplateFromFile ("../html/bo_piscina.html");   

        //rutas imagenes
        $directm = "../upload/fotos/piscina/thumbs/";
        $direct = "../upload/fotos/piscina/fullsize/";  

        $sql = new Consultas();

        function getFileExtension($path)
        {
            $parts = pathinfo($path);
            return $parts['extension'];
        }

        //Eliminar Imagen
        if(isset($_POST["botonEliminar"]))
        {
            $aryEliminaNoticia = $_POST["aryEliminaNoticia"];
            if($aryEliminaNoticia)
            {

                $sql->setTable("piscina");
                foreach($aryEliminaNoticia as $Noticia)
                {      
                    $res = $sql->selectDestacadoName($Noticia);
                    while($fila=mysql_fetch_array($res)){
                        unlink($direct.$fila["nombre"].".jpg");
                        $extension = getFileExtension( $fila["nombre"]);
                        unlink($directm.$fila["nombre"].".jpg");
                    }

                    $sql->eliminarDestacado($Noticia);      



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
                    $sql->setTable("piscina");
                    $res = $sql->selectPiscina();
                    $fila = mysql_fetch_array($res);
                    $num = (int)$fila["id"];
                    $num = $num+1;
                    $nombre1 = $num;

                    $objImage = new SimpleImage();
                    $objImage->load($_FILES['file']['tmp_name']);
                    $objImage->setImgName($nombre1);
                    $objImage->resize('179','100');      
                    $objImage->save($directm.$nombre1); 



                    $sql->setTable("piscina");
                    $sql->insertDestacado($nombre1);

                    //copiar archivo
                    move_uploaded_file( $_FILES['file']['tmp_name'], $direct.$nombre1.".jpg");
                    //borrar temp file
                    @unlink($_FILES['file']['tmp_name']); 

                    $t->setVariable("mensaje","Se Guardo correctamente la imagen");


                }

                $t->addBlock("Mensaje");   
            }


        }     
        //Mostrar Imagenes 
        $sql->setTable("piscina");
        $res = $sql->selectDestacados();

        While($fila = mysql_fetch_array($res)){
            $imagenUbicacion = $directm.$fila["nombre"];
            $t->setVariable("id_destacado",$fila["id"]);   
            $t->setVariable("imagen",$imagenUbicacion);
            $t->addBlock("Piscina");      

        }
        $t->generateOutput(); 

        require_once("bo_footer.php"); 

    }else{

        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>"; 
    }
?> 
   