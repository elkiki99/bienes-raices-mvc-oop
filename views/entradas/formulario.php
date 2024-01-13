<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="entrada[titulo]" placeholder="Título entrada" value="<?php echo s($entrada->titulo); ?>">

    <label for="articulo">Descripción:</label>
    <input type="text" id="descripcion" name="entrada[descripcion]" placeholder="Descripción entrada" value="<?php echo s($entrada->descripcion); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="entrada[imagen]" accept="image/jpeg, image/png">
    <?php if($entrada->imagen) { ?>
        <img src="/imagenes/entradas/<?php echo $entrada->imagen ?>" class="imagen-small"
    <?php } ?>

    <label for="articulo">Artículo:</label>
    <textarea id="articulo" name="entrada[articulo]"><?php echo s($entrada->articulo); ?></textarea>

    <label for="autor">Autor:</label>
    <input type="autor" id="autor" name="entrada[autor]" placeholder="Autor" value="<?php echo s($entrada->autor); ?>">
</fieldset>