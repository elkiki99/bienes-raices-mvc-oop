<div class="contenedor">
<?php foreach($entradas as $entrada) { ?>

    <article class="entrada-blog">
        <div class="imagen">

            <img loading="lazy" src="/imagenes/entradas/<?php echo $entrada->imagen;?>" alt="Entrada Blog">

        </div>

        <div class="texto-entrada">

            <a href="/entrada?id=<?php echo $entrada->id;?>">
                <h4><?php echo $entrada->titulo ?></h4>

                <p class="informacion-meta">Escrito el <span> <?php echo $entrada->creado ?> </span> por: <span> <?php echo $entrada->autor ?> </span> </p>
                <p> <?php echo $entrada->descripcion ?> </p>

            </a>
        </div>
    </article>
<?php } ?>
</div><!--.contenedor-->