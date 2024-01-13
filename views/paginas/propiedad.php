<main class="contenedor seccion contenido-centrado anuncios">
    <h1><?php echo $propiedad->titulo?></h1>
    
    <img loading="lazy" src="/imagenes/propiedades/<?php echo $propiedad->imagen?>" alt="Anuncio">

    <div class="resumen-propiedad">
        <p class="precio">$ <?php echo $propiedad->precio; ?></p>

        <ul class="iconos-caracteristicas">
            <li>
                <img loading="lazy" src="build/img/icono_wc.svg" alt="Icono baños">
                <p><?php echo $propiedad->wc?></p>
            </li>
            <li>
                <img loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono estacionamiento">
                <p><?php echo $propiedad->estacionamiento?></p>
            </li>
            <li>
                <img loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono dormitorios">
                <p><?php echo $propiedad->habitaciones?></p>
            </li>
        </ul>

        <p><?php echo $propiedad->descripcion; ?></p>
        <p><?php echo $propiedad->descripcionlarga; ?></p>
    </div>
</main>