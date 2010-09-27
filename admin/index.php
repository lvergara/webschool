<?php       
    ob_start();
    session_start();      
    require_once("../php/Clases.php");
    $t = new MiniTemplator();             
    $t->readTemplateFromFile ("template.html");    
    $sql = new Consultas();                     
    if($_POST['ingresar'])
    {
        $var_login = $_POST['login'];
        $var_clave = $_POST['clave'];

        if($var_login == "")
        {
            $msj=1;
        } else {
            $var = 1;
        }

        if($var_clave == "")
        {
            $msj=1;
        } else {
            $var = $var+1;
        }
        if($msj==1){
            $t->setVariable("mensaje","Complete los campos");
            $t->addBlock("Mensaje");
        }

        if($var == 2){

            $sql->setTable("usuarios");
            $res = $sql->validarUsuario($var_login,$var_clave);
            $num = mysql_num_rows($res);
            $fila = mysql_fetch_array($res);

            if($num == ""){   
                $t->setVariable("mensaje","El usuario no existe");
                $t->addBlock("Mensaje");     

            }else{
                // Iniciar la session
                $_SESSION['usuario'] = $fila['login'];
                if($fila["permiso"]=='1'){    
                   $_SESSION['permiso'] = '1';  
                    echo "<script language='javascript'>";
                    echo "window.location='../php/bo/php/bo_admin.php'";
                    echo "</script>";   


                } 
                if($fila["permiso"]=='2'){
                    echo "<script language='javascript'>";
                    echo "window.location='../php/bo/'";
                    echo "</script>";   

                }       

            }               
        }
    }                       
    $t->generateOutput();   
?>
