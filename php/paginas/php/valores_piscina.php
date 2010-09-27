 <?php
    require_once('Clases.php');     
    $t = new MiniTemplator();
    require_once('home_header.php');
    require_once('home_menu.php');
    $t->readTemplateFromFile ('../html/valores_piscina.html');
    $sql = new Consultas();        
    $sql->setTable('paginas');        
    $res = $sql->selectPagina(valores_piscina);      

    while($fila = mysql_fetch_array($res)){
      
    $t->setVariable('titulo',$fila['titulo']);
    $t->setVariable('bajada',$fila['bajada']);
    $t->setVariable('cuerpo',$fila['cuerpo']);
    $t->setVariable('img',$fila['img']);   
    $t->addBlock('Pagina');          
    }                                               


    $t->generateOutput(); 
    require_once('home_footer.php');
    ?>