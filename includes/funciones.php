<?php

define("TEMPLATES_URL", __DIR__ . "/templates");
define("FUNCIONES_URL", __DIR__ . "funciones.php");
define("CARPETA_IMAGENES_PROPIEDADES", $_SERVER["DOCUMENT_ROOT"] . "/imagenes/propiedades/");
define("CARPETA_IMAGENES_ENTRADAS", $_SERVER["DOCUMENT_ROOT"] . "/imagenes/entradas/");

function incluirTemplates( string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/{$nombre}.php";
}

function habilitarErrores() {
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
}

function estaAutenticado() {
    session_start();
    
    if(!$_SESSION["login"]) {
        header("Location: /");
    }
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapar / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipos de contenido
function validarTipoContenido($tipo) {
    $tipos = ["vendedor", "propiedad", "entrada"];

    return in_array($tipo, $tipos);
}

// Muestra mensajes 
function mostrarNotificacion($codigo) {
    $mensaje = "";

    switch($codigo) {
        case 1:
            $mensaje = "Creado correctamente";
            break;
        case 2:
            $mensaje = "Actualizado correctamente";
            break;    
        case 3:
            $mensaje = "Eliminado correctamente";
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}

function validarORedireccionar(string $url) {
    // Validar la URL por ID válido
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header("Location: {$url}");
    }
    return $id;
}