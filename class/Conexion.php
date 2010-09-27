<?php         
    /* autor: Luis Vergara
    *  Clase Conexion a Base de Datos
    */   

    class Conexion
    {
        private $bd_host;
        private $user_db;
        private $pass_db;
        private $name_db;  
        private $link;                          

        public function __construct(){

            $this->bd_host = "localhost";
            $this->user_db = "root";
            $this->pass_db = "123456";
            $this->name_db = "schoolsite";     

        }

        //Metodo Conecta BD
        public function conectarBD(){ 

            if(!($this->link=mysql_connect($this->bd_host, $this->user_db, $this->pass_db))) {
                echo "Error conectando a la base de datos.". $this->bd_host;
                exit();             
            }                

            if(!mysql_select_db($this->name_db,$this->link))
            {                      
                echo "Error seleccionando la base de datos.";
                exit();
            }
            //Codifica en UTF8
            mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'",$this->link);

            return $this->link;
        }
    }
?>

