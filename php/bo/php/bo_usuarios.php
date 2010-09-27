<?php
    session_start();    
    if(isset($_SESSION['usuario']) AND $_SESSION['permiso'] == '1'){
        require_once("Clases.php");
        require_once("bo_header.php");                     

        $t = new MiniTemplator();             
        $sql = new Consultas();   
        $t->readTemplateFromFile ("../html/bo_usuarios.html");

        if(isset($_POST["btnBorrar"]))
        {              
            $id = $_POST["id"];
            $sql->setTable("usuarios");         
            $sql->eliminarUsuario($id);         

        }  

        $sql->setTable("usuarios");
        if($_POST['registrar'])
        {
            $var_rut = $_POST['rut'];
            $var_nombre = $_POST['nombre'];
            $var_apellidos = $_POST['apellidos'];
            $var_login = $_POST['login'];
            $var_clave = $_POST['clave'];
            $var_tipoUsuario = $_POST['tipousuario'];

            if($var_rut=="" || $var_nombre =="" || $var_apellidos =="" || $var_login=="" || $var_clave=="" || $var_tipoUsuario==""){

                $t->setVariable("mensaje","Error! Debe completar todos los campos");   
                $t->addBlock("Mensaje");

            }else{     

                if($var_tipoUsuario=="1")
                {
                    $validar = $sql->existeUsuario($var_rut);
                    if($validar == 0)
                    {
                        $sql->insertarUsuario($var_rut,$var_nombre,$var_apellidos,$var_login,$var_clave,$var_tipoUsuario);
                        echo "Se ha registrado Correctamente";    

                    } else {
                        echo "Ya existe este usuario";  
                    }

                }else if($var_tipoUsuario=="2"){
                        $validar = $sql->existeUsuario($var_rut);  
                        if($validar->existeUsuario() == 0)
                        {
                            $sql->insertarUsuario($var_rut,$var_nombre,$var_apellidos,$var_login,$var_clave,$var_tipoUsuario);
                            echo "Se ha registrado Correctamente";    
                        } else {
                            echo "Ya existe este usuario";  
                        } 
                    }else if($var_tipoUsuario=="3"){
                            $validar = $sql->existeUsuario($var_rut);     
                            if($validar== 0)
                            {
                                $sql->insertarUsuario($var_rut,$var_nombre,$var_apellidos,$var_login,$var_clave,$var_tipoUsuario);
                                echo "Se ha registrado Correctamente";

                            } else {
                                echo "Ya existe este usuario";  
                            } 
                        }else if($var_tipoUsuario=="4"){
                                $validar = $sql->existeUsuario($var_rut);     
                                if($validar== 0)
                                {
                                    $sql->insertarUsuario($var_rut,$var_nombre,$var_apellidos,$var_login,$var_clave,$var_tipoUsuario);
                                    echo "Se ha registrado Correctamente";

                                } else {
                                    echo "Ya existe este usuario";  
                                } 
                            }   

            }
        }

        //Mostrar Usuario   
        $sql->setTable("usuarios");
        $res = $sql->selectDestacados();

        $num_rows = mysql_num_rows($res);  

        While($fila = mysql_fetch_array($res)){ 
            $perm;
            switch ($fila["permiso"]) {
                case 1:
                    $perm = "Administrador"; 
                    break;
                case 2:
                    $perm = "Encargado Contenido";    
                    break;
                case 3:
                    $perm = "Piscina";    
                    break;
                case 4:
                    $perm = "Casino";    
                    break;     
            }




            $t->setVariable("id",$fila["id"]);  
            $t->setVariable("nombre",$fila["nombre"]);
            $t->setVariable("apellido",$fila["apellido"]); 
            $t->setVariable("rut",$fila["rut"]); 
            $t->setVariable("usuario",$fila["login"]); 
            $t->setVariable("tusuario",$perm);
            $t->addBlock("Usuario");     

        }    

        $t->generateOutput();
        require_once("bo_footer.php");
    }else{        
        echo "<script language='javascript'>";
        echo "window.location='../../../admin/'";
        echo "</script>";  
    }
?>
