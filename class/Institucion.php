<?php
   class Institucion extends Usuario
  {
      private $permiso;
      private $descripcion;
      
      public function __construct($rut,$nombre,$apellidos,$login,$clave)
      {
         $this->rut = $rut;
         $this->nombre = $nombre;
         $this->apellidos = $apellidos;
         $this->login = $login;
         $this->clave = $clave;
         $this->permiso = "III";
         $this->descripcion = "Este es la Institucion";
      }
      
      public function muestraUsuario()
      {
          echo "Nombre usuario : " . $this->nombre . " " . $this->apellidos . "<br />";
          echo "Descripcion : " . $this->descripcion . " - > Tipo : " . $this->permiso;
      }
      
      public function insertaUsuario()
      {
         $link = new Conexion();
         $this->sql = "INSERT INTO usuario (`user_rut`, `user_nombre`, `user_apellido`, `user_login`, `user_pass`, `user_permiso`) 
                       VALUES ('$this->rut', '$this->nombre', '$this->apellidos', '$this->login', '".md5($this->clave)."', '$this->permiso');";
         mysql_query($this->sql,$link->conectarBD())or die(mysql_error());
           
      }
  }
?>
