<?php
    /* autor: Luis Vergara - ver0988@gmail.com
    *  Clase Consultas Base de datos
    */

    Class Consultas{

        private $result;
        private $sql;
        private $row;
        private $estado;
        private $table;

        public function __construct(){        

            $this->result = NULL;
            $this->sql = NULL;
            $this->row = NULL;
            $this->estado = NULL;
            $this->table = NULL;

        }                             


        //Noticias

        //Select Ultimas Noticias   
        public function selectUltimos($num){            
            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table ORDER BY fecha limit $num"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;
        }  

        //Select Todas Noticias    
        public function selectTodo(){            
            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table ORDER BY fecha desc"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;
        } 

        public function selectAll(){            
            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;
        } 


        //Select Todas Noticias    
        public function selectNoticia($id){            
            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table WHERE idNoticia='$id'"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;
        }  


        //Actualizar Noticia
        public function actualizarNoticiaConImg($titulo,$bajada,$cuerpo,$img,$id){

            $bd = new Conexion();
            $this->sql="UPDATE $this->table SET titulo='$titulo',bajada='$bajada',cuerpo='$cuerpo',img='$img' WHERE idNoticia='$id'";   
            $this->result = mysql_query($this->sql,$bd->conectarBD());      

        }
        public function actualizarNoticiaSinImg($titulo,$bajada,$cuerpo,$id){

            $bd = new Conexion();
            $this->sql="UPDATE $this->table SET titulo='$titulo', bajada='$bajada', cuerpo='$cuerpo' WHERE idNoticia='$id'";   
            $this->result = mysql_query($this->sql,$bd->conectarBD());        
        }


        //Insertar Noticia
        public function insertNoticia($titulo,$bajada,$cuerpo,$img){

            $bd = new Conexion();
            $this->sql="INSERT INTO $this->table (titulo,bajada,cuerpo,fecha,img) Values('$titulo','$bajada','$cuerpo',NOW(),'$img')";   

            $this->result = mysql_query($this->sql,$bd->conectarBD());      

        }
        //Delete Noticia por id
        public function eliminarNoticia($id){
            $bd = new Conexion();
            $this->sql="DELETE FROM $this->table WHERE idNoticia=$id"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD()); 

        }     

        //Paginas

        //Insertar Pagina
        public function insertarPagina($pagina,$titulo,$bajada,$cuerpo,$img){

            $bd = new Conexion();
            $this->sql="INSERT INTO $this->table (pagina,titulo,bajada,cuerpo,img) Values('$pagina','$titulo','$bajada','$cuerpo','$img')";   

            $this->result = mysql_query($this->sql,$bd->conectarBD());      

        }

        public function actualizarPaginaConImg($pagina,$titulo,$bajada,$cuerpo,$img,$id){

            $bd = new Conexion();
            $this->sql="UPDATE $this->table SET pagina='$pagina',titulo='$titulo',bajada='$bajada',cuerpo='$cuerpo',img='$img' WHERE idPagina='$id'";   
            $this->result = mysql_query($this->sql,$bd->conectarBD());      

        }
        public function actualizarPaginaSinImg($pagina,$titulo,$bajada,$cuerpo,$id){

            $bd = new Conexion();
            $this->sql="UPDATE $this->table SET pagina='$pagina',titulo='$titulo', bajada='$bajada', cuerpo='$cuerpo' WHERE idPagina='$id'";   
            $this->result = mysql_query($this->sql,$bd->conectarBD());        
        }




        //Eliminar Pagina
        public function eliminarPagina($id){
            $bd = new Conexion();
            $this->sql="DELETE FROM $this->table WHERE idPagina=$id"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD()); 

        } 

        //Select Pagina por Id
        public function selectPaginaId($id){
            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table WHERE idPagina='$id'"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;  

        }

        //Select Pagina por nombre
        public function selectPagina($pagina){
            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table WHERE pagina='$pagina'"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;  

        }

        // Piscina
        public function selectPiscina(){

            $bd = new Conexion();
            $this->sql="SELECT * FROM $this->table order by id DESC";   
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;   

        }

        //Destacados -- Galeria de Fotos del Colegio 

        public function selectDestacado(){

            $bd = new Conexion();
            $this->sql="SELECT * FROM $this->table order by id DESC";   
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;   

        }


        //Destacados Portada

        //Select Todos Destacados Portada                  
        public function selectDestacados(){
            $bd = new Conexion();
            $this->sql="SELECT * FROM $this->table";   
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;
        }

        public function selectDestacadosPortada(){
            $bd = new Conexion();
            $this->sql="SELECT * FROM $this->table WHERE estado='1'";   
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;
        }
        //Select Nombre Destacado por Id
        public function selectDestacadoName($id){
            $bd = new Conexion();
            $this->sql="SELECT nombre FROM $this->table WHERE id=$id";   
            $this->result = mysql_query($this->sql,$bd->conectarBD());                                                                     
            return $this->result;
        }

        //Insert Destacado Portada
        public function insertDestacado($nombre){

            $bd = new Conexion();
            $this->sql="INSERT INTO $this->table (nombre) Values('$nombre')";   

            $this->result = mysql_query($this->sql,$bd->conectarBD());      

        }         

        //Delete  Destacado Portada por Id
        public function eliminarDestacado($id){
            $bd = new Conexion();
            $this->sql="DELETE FROM $this->table WHERE id=$id"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());     


        }   
        //Coloca Imagen en Portada
        public function updateDestacado($id){
            $bd = new Conexion();
            $this->sql="UPDATE $this->table SET estado=1 WHERE id=$id"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());     

        }     
        //Saca imagen de portada
        public function updateDestacadoSacar($id){
            $bd = new Conexion();
            $this->sql="UPDATE $this->table SET estado=0 WHERE id=$id"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());     

        }             

        //Menu

        //Desplegar todo Menu
        public function despliegaMenus(){

            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table";
            $this->result = mysql_query($this->sql,$bd->conectarBD())or die(mysql_error());
            return $this->result;  

        }

        //Delete Menu por id
        public function eliminarMenu($id){
            $bd = new Conexion();
            $this->sql="DELETE FROM $this->table WHERE idSubmenu='$id'"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD()); 

        }   

        //Actualiza submenu
        public function updateSubMenus($nombre,$idPagina,$id){
            $bd = new Conexion();
            $this->sql="UPDATE $this->table SET nombre='$nombre', idPagina='$idPagina' WHERE idSubmenu='$id'"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());     

        }  


        //Despliega SubMenu Segun IdMenu
        public function selectSubMenu($id)
        {
            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table WHERE idMenu = $id";
            $this->result = mysql_query($this->sql,$bd->conectarBD())or die(mysql_error());
            return $this->result;

        } 

        //Despliega Menu Segun IdMenu
        public function selectMenu($id)
        {
            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table WHERE idMenu = $id";
            $this->result = mysql_query($this->sql,$bd->conectarBD())or die(mysql_error());
            return $this->result;

        }   




        public function selectSubMenus()
        {
            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table";
            $this->result = mysql_query($this->sql,$bd->conectarBD())or die(mysql_error());               
            return $this->result;

        }      

        //Cantidad de Menus
        public function contarMenus()
        {
            $link = new Conexion();
            $this->sql = "SELECT * FROM $this->table";
            $this->row = mysql_query($this->sql,$link->conectarBD())or die(mysql_error());
            $this->result = mysql_num_rows($this->row);     
            return $this->result;
        }

        //Cantidad de Menus
        public function selectMenus()
        {
            $link = new Conexion();
            $this->sql = "SELECT * FROM $this->table";
            $this->result = mysql_query($this->sql,$link->conectarBD())or die(mysql_error());
            return $this->result;
        }


        //Insertar Submenu
        public function insertSubMenu($nombre,$idPagina,$idMenu){

            $bd = new Conexion();
            $this->sql="INSERT INTO $this->table (nombre,idPagina,idMenu) Values('$nombre','$idPagina','$idMenu')";   

            $this->result = mysql_query($this->sql,$bd->conectarBD());      

        }

        //Delete Submenu por id
        public function eliminarSubmenu($id){
            $bd = new Conexion();
            $this->sql="DELETE FROM $this->table WHERE idMenu=$id"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD()); 

        }     

        public function updateSubMenu($nombre,$id){
            $bd = new Conexion();
            $this->sql = "update $this->table set nombre='$nombre' WHERE id='$id'";
            $this->result = mysql_query($this->sql,$bd->conectarBD());        
        } 


        //Usuarios              
        public function validarUsuario($login,$clave){  

            $clavemd5 = md5($clave);
            $bd = new Conexion();
            $this->sql = "SELECT * FROM $this->table WHERE login='$login' AND pass = '$clavemd5'";
            $this->result = mysql_query($this->sql,$bd->conectarBD());             
            return $this->result;
        }

        public function existeUsuario($rut)
        {
            $link = new Conexion();
            $this->sql = "SELECT rut FROM $this->table WHERE rut = '$rut' ";
            $this->row = mysql_query($this->sql,$link->conectarBD())or die(mysql_error());
            $this->result = mysql_num_rows($this->row);

            if($this->result == "")
            {
                $validar = 0;
            } else {
                $validar = 1;
            }

            return $validar;
        }


        public function insertarUsuario($rut,$nombre,$apellido,$login,$clave,$permiso)
        {
            $link = new Conexion();
            $this->sql = "INSERT INTO $this->table (`rut`, `nombre`, `apellido`, `login`, `pass`, `permiso`) 
            VALUES ('$rut', '$nombre', '$apellido', '$login', '".md5($clave)."', '$permiso');";
            mysql_query($this->sql,$link->conectarBD())or die(mysql_error());

        }
        //Delete  Usuario  Id
        public function eliminarUsuario($id){
            $bd = new Conexion();
            $this->sql="DELETE FROM $this->table WHERE id=$id"; 
            $this->result = mysql_query($this->sql,$bd->conectarBD());     


        }   



        //Setters
        public function setTable($valor){
            $this->table = $valor;
        }
        //Getters
        public function getTable($valor){
            return $this->table; 
        }

    }   
?>
