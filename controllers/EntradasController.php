<?php

namespace Controllers;

use MVC\Router;
use Model\Entrada;
use Intervention\Image\ImageManagerStatic as Image;

class EntradasController {

    public static function crear(Router $router) {

        $entrada = new Entrada();

        $errores = Entrada::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $entrada = new Entrada($_POST["entrada"]);

            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            if($_FILES["entrada"]["tmp_name"]["imagen"]) {
                $image = Image::make($_FILES["entrada"]["tmp_name"]["imagen"])->fit(800,600);
                $entrada->setImagen($nombreImagen, CARPETA_IMAGENES_ENTRADAS);
            }

            $errores = $entrada->validar();

            if (empty($errores)) {
                // Crear carpeta
                if(!is_dir(CARPETA_IMAGENES_ENTRADAS)) {
                    mkdir(CARPETA_IMAGENES_ENTRADAS);
                }
    
                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES_ENTRADAS . $nombreImagen);
    
                // Guardar en la base de datos
                $entrada->guardar();
            }
        }
        
        $router->render("/entradas/crear", [
            "entrada" => $entrada,
            "errores" => $errores
        ]);
    }

    public static function actualizar(Router $router) {

        $id = validarORedireccionar("/admin");

        $entrada = Entrada::find($id);

        $errores = Entrada::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $args = $_POST["entrada"];

            $entrada->sincronizar($args);

            $errores = $entrada->validar();

            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    
            if($_FILES["entrada"]["tmp_name"]["imagen"]) {
                $image = Image::make($_FILES["entrada"]["tmp_name"]["imagen"])->fit(800,600);
                $entrada->setImagen($nombreImagen, CARPETA_IMAGENES_ENTRADAS);
            }
    
            if (empty($errores)) {
                if($_FILES["entrada"]["tmp_name"]["imagen"]) {
                // Almacenar la imagen
                $image->save(CARPETA_IMAGENES_ENTRADAS . $nombreImagen);
                }

                $entrada->guardar();
            }
        }

        $router->render("/entradas/actualizar", [
            "entrada" => $entrada,
            "errores" => $errores
        ]);
    }

    public static function eliminar() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {

            // debuguear($_SERVER["HTTP_REFERER"]);
            
            $id = $_POST["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) {
                $tipo = $_POST["tipo"];
                if(validarTipoContenido($tipo)) {
                    $entrada = Entrada::find($id);
                    $entrada->eliminar(CARPETA_IMAGENES_ENTRADAS);
                }
            }
        }
    }
}