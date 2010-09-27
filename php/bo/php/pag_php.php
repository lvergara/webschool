<?php
    $peso = '$';  
    $php =" <?php
    require_once('Clases.php');     
    ".$peso."t = new MiniTemplator();
    require_once('home_header.php');
    require_once('home_menu.php');
    ".$peso."t->readTemplateFromFile ('../html/".$pagina.".html');
    ".$peso."sql = new Consultas();        
    ".$peso."sql->setTable('paginas');        
    ".$peso."res = ".$peso."sql->selectPagina(".$pagina.");      

    while(".$peso."fila = mysql_fetch_array(".$peso."res)){
      
    ".$peso."t->setVariable('titulo',".$peso."fila['titulo']);
    ".$peso."t->setVariable('bajada',".$peso."fila['bajada']);
    ".$peso."t->setVariable('cuerpo',".$peso."fila['cuerpo']);
    ".$peso."t->setVariable('img',".$peso."fila['img']);   
    ".$peso."t->addBlock('Pagina');          
    }                                               


    ".$peso."t->generateOutput(); 
    require_once('home_footer.php');
    ?>";

?>
