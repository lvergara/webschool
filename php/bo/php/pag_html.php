<?php
  $peso = '$';
  
  $html = "<div id='bottom'>
    <div id='izquierdaSeccion'>
    <!-- ".$peso."BeginBlock Pagina -->
        <div id='tituloSeccion'>".$peso."{titulo}
        </div>   
    
        <div id='bajadaSeccion'>".$peso."{bajada}</div>
        <div id='contenidoSeccion'>".$peso."{cuerpo}
        </div>
        
        <div id='compartir'> 
            <span class='st_sharethis'></span>
            <span class='st_facebook'></span>
            <span class='st_twitter'></span>
            <span class='st_myspace'></span>
            <span class='st_email'></span>

        </div>     
    </div>

    <div id='derechaSeccion'> 
        
        <img src='../../bo/upload/fotos/paginas/".$peso."{img}'>

    </div>    

   <!-- ".$peso."EndBlock Pagina --> 
 </div>";
?>
