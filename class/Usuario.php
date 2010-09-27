<?php
  class Usuario
  {
     private $rut;
     private $nombre;
     private $apellidos;
     private $login;
     private $clave;
     
     public function __construct()
     {
         $this->rut = NULL;
         $this->nombre = NULL;
         $this->apellidos = NULL;
         $this->login = NULL;
         $this->clave = NULL;
     }
     
     
  }
?>
