<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Entrada;

class PropiedadController {
    public static function index(Router $router) {            // Static no requiere instanciarla nuevamente

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $entradas = Entrada::all();
        
        // Muestra un mensaje condicional
        $resultado = $_GET["resultado"] ?? null;

        $router->render("propiedades/admin", [          // Arreglo
            "propiedades" => $propiedades,              // Atributo del arreglo
            "vendedores" => $vendedores,
            "entradas" => $entradas,
            "resultado" => $resultado
            ]);
        }

    public static function crear(Router $router) {

        $propiedad = new Propiedad();
        $vendedores = Vendedor::all();
        
        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            // Crea una nueva instancia
            $propiedad = new Propiedad($_POST["propiedad"]);
    
            /** SUBIDA DE ARCHIVOS */
    
            // Generar un nombre nuevo para cada imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    
            // Setear la imagen
            // Realiza un resize a la imagen con intervention
            if($_FILES["propiedad"]["tmp_name"]["imagen"]) {
                $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);
                $propiedad->setImagen($nombreImagen, CARPETA_IMAGENES_PROPIEDADES);
            }
            // Validar
            $errores = $propiedad->validar();
    
            if (empty($errores)) {
                // Crear carpeta
                if(!is_dir(CARPETA_IMAGENES_PROPIEDADES)) {
                    mkdir(CARPETA_IMAGENES_PROPIEDADES);
                }
    
                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES_PROPIEDADES . $nombreImagen);
    
                // Guardar en la base de datos
                $propiedad->guardar();
            }
        }

        $router->render("/propiedades/crear", [
            "propiedad" => $propiedad,
            "errores" => $errores,
            "vendedores" => $vendedores,
        ]);
    }
    

    public static function actualizar(Router $router) {

        $id = validarORedireccionar("/admin");

        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {

            // Asignar los atributos
            $args = $_POST["propiedad"];
    
            $propiedad->sincronizar($args);
    
            // Validación
            $errores = $propiedad->validar();
    
            // Subida de archivos
            // Generar un nombre nuevo para cada imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    
            if($_FILES["propiedad"]["tmp_name"]["imagen"]) {
                $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);
                $propiedad->setImagen($nombreImagen, CARPETA_IMAGENES_PROPIEDADES);
            }
    
            // Revisar que el array de errores esté vacío
            if(empty($errores)) {
                if($_FILES["propiedad"]["tmp_name"]["imagen"]) {
                // Almacenar la imagen
                $image->save(CARPETA_IMAGENES_PROPIEDADES . $nombreImagen);
                }
            }
            
            $propiedad->guardar();
        }

        $router->render("/propiedades/actualizar", [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }

    public static function eliminar() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {

            // debuguear($_SERVER["HTTP_REFERER"]);

            // Validar id
            $id = $_POST["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) {
                $tipo = $_POST["tipo"];
                if(validarTipoContenido($tipo)) {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar(CARPETA_IMAGENES_PROPIEDADES);
                }
            }
        }
    }
}
