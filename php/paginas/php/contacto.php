 <?php
    require_once('Clases.php');     
    $t = new MiniTemplator();
    require_once('home_header.php');
    require_once('home_menu.php');
    $t->readTemplateFromFile ('../html/contacto.html');
    $sql = new Consultas();        



    $t->generateOutput(); 
    require_once('home_footer.php');
    ?>