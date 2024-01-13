<?php

namespace Model;

class Entrada extends ActiveRecord {
    protected static $tabla = "entradas";

    protected static $columnasDB = ["id", "titulo", "descripcion", "imagen", "articulo", "autor", "creado"];

    public $id;
    public $titulo;
    public $descripcion;
    public $imagen;
    public $articulo;
    public $autor;
    public $creado;  

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->titulo = $args["titulo"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->imagen = $args["imagen"] ?? "";
        $this->articulo = $args["articulo"] ?? "";
        $this->autor = $args["autor"] ?? "";
        $this-> creado = date("Y/m/d");
    }

    public function validar() {

        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un título";
        }
        
        if(!$this->descripcion) {
            self::$errores[] = "La descripción es obligatoria";
        }

        if(!$this->imagen) {
            self::$errores[] = "La imaagen es obligatoria";
        }
        
        if(!$this->articulo) {
            self::$errores[] = "El artículo es obligatorio";
        }
        
        if(!$this->autor) {
            self::$errores[] = "Debes añadir un nombre de autor";
        }
        
        return self::$errores;
    }
}