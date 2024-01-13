<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Título Propiedad" value="<?php echo s($propiedad->titulo); ?>">

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg, image/png">
    <?php if($propiedad->imagen) { ?>
        <img src="/imagenes/propiedades/<?php echo $propiedad->imagen ?>" class="imagen-small"
    <?php } ?>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>
    
    <label for="descripcionlarga">Descripción Larga:</label>
    <textarea id="descripcionlarga" name="propiedad[descripcionlarga]"><?php echo s($propiedad->descripcionlarga); ?></textarea>
</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input 
        type="number" 
        name="propiedad[habitaciones]" 
        id="habitaciones" 
        placeholder="Ej: 3"
        min="1" max="20" 
        value="<?php echo s($propiedad->habitaciones); ?>">

    <label for="wc">Baños:</label>
    <input 
        type="number" 
        name="propiedad[wc]" 
        id="wc" 
        placeholder="Ej: 2" 
        min="1" 
        max="20" 
        value="<?php echo s($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamiento:</label>
    <input 
        type="number" 
        name="propiedad[estacionamiento]" 
        id="estacionamiento" 
        placeholder="Ej: 1" 
        min="1" 
        max="20" 
        value="<?php echo s($propiedad->estacionamiento); ?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>

    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedores_id]" id="vendedor">
    <option selected disabled value="">-- Seleccione --</option>
        <?php foreach($vendedores as $vendedor) { ?>
            <option 
                <?php echo $propiedad->vendedores_id === $vendedor->id ? "selected" : ""; ?>
                value="<?php echo s($vendedor->id); ?>" ><?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?> </option>
        <?php } ?>
    </select>
</fieldset>