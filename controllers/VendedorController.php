<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {

    public static function crear(Router $router) {
        
        $vendedor = new Vendedor();

        $errores = Vendedor::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            // Crea una nueva instancia
            $vendedor = new Vendedor($_POST["vendedor"]);

            // Validar
            $errores = $vendedor->validar();

            if (empty($errores)) {
            // Guardar en la base de datos
            $vendedor->guardar();
            }
        }
        
        $router->render("/vendedores/crear", [
            "vendedor" => $vendedor,
            "errores" => $errores
        ]);
    }

    public static function actualizar(Router $router) {

        $errores = Vendedor::getErrores();
        $id = validarORedireccionar("/admin");

        $vendedor = Vendedor::find($id);        

        if(!$vendedor || $id < 1) {
            header("location: /admin");
        }

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            // Asignar los atributos
            $args = $_POST["vendedor"];
    
            $vendedor->sincronizar($args);
    
            // Validación
            $errores = $vendedor->validar();
    
            // Revisar que el array de errores esté vacío
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render("/vendedores/actualizar", [
            "vendedor" => $vendedor,
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
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar(null);
                }
            }
        }
    }
}
