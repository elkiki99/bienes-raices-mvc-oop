<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $entrada->titulo?></h1>
        
    <img loading="lazy" src="/imagenes/entradas/<?php echo $entrada->imagen?>" alt="Anuncio">

    <p class="informacion-meta">Escrito el <span><?php echo $entrada->creado ?></span>

    <div class="resumen-propiedad">
        
        <p> <?php echo $entrada->articulo ?> </p>
    </div><!--.contenido-anuncio-->

    <p class="informacion-meta"> Escrito por: <span> <?php echo $entrada->autor ?> </span></p>
    
</main>