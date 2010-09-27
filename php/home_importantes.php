<?php
  $t = new MiniTemplator();
    $t->readTemplateFromFile ("../html/home_importantes.html");

   // $sql = new Consultas();
   // $sql->setTable("paginas");
   // $res = $sql->selectUltimos("3");  //mandamos parametro de noticias a mostrar           
      /*
    function cortar_frase($frase_entrada,$cortar){

        $frase_corta=substr($frase_entrada,0,$cortar); // obtener la frase cortada.
        $palabras=str_word_count($frase_corta,1); // obtener array con las palabras.
        $total_palabras=count($palabras)-1; // contar total array elementos y restar 1 elementos
        $palabras=array_splice($palabras,0,$total_palabras); // le quitamos la ultima palabra.
        $frase_salida=implode(' ',$palabras); //  y concatenamos con el espacio hacia una cadena.
        $frase_salida .= "..."; // se añaden los puntos suspensivos a la cadena obtenida..

        return $frase_salida;
    }
         */
    $largo = 85;    //Largo de parrafo
  /*  while($fila = mysql_fetch_array($res)){

        if (strlen($fila["bajada"]) > $largo){
            $frase_final=cortar_frase($fila["bajada"],$largo);
        }else{
            $frase_final=$fila["bajada"];
        }          
          
        $t->setVariable("bajada",$frase_final);                         
        $t->setVariable ("id",$fila["idNoticia"]);  
        $t->addBlock ("NoticiasDestacadas");          
        
      
    }
    */                   
      $t->generateOutput();  

?>
