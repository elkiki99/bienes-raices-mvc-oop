<?php

namespace Model;

class Propiedad extends ActiveRecord {
    protected static $tabla = "propiedades";
    // Creamos este arreglo de columnas, nos permite identificar qué forma va a tener los datos y poder mapear el objeto que estamos creando en crear.php
    protected static $columnasDB = ["id", "titulo", "precio", "imagen", "descripcion", "descripcionlarga", "habitaciones", "wc", "estacionamiento", "creado", "vendedores_id"];

    public $id;                        // Propiedades o atributos de la clase
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $descripcionlarga;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this-> id = $args["id"] ?? null;
        $this-> titulo = $args["titulo"] ?? "";
        $this-> precio = $args["precio"] ?? "";
        $this-> imagen = $args["imagen"] ?? "";
        $this-> descripcion = $args["descripcion"] ?? "";
        $this-> descripcionlarga = $args["descripcionlarga"] ?? "";
        $this-> habitaciones = $args["habitaciones"] ?? "";
        $this-> wc = $args["wc"] ?? "";
        $this-> estacionamiento = $args["estacionamiento"] ?? "";
        $this-> creado = date("Y/m/d");
        $this-> vendedores_id = $args["vendedores_id"] ?? "";
    }

    public function validar() {
        
        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un título";
        }

        if(!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
        }

        if( strlen($this->descripcion) < 50) {
            self::$errores[] = "La descripción es obligatoria y debe tener al menos 50 caracteres";
        }
        
        if( strlen($this->descripcionlarga) < 150) {
            self::$errores[] = "La descripción larga es obligatoria y debe tener al menos 150 caracteres";
        }

        if(!$this->habitaciones) {
            self::$errores[] = "El número de habitaciones es obligatorio";
        }

        if(!$this->wc) {
            self::$errores[] = "El número de baños es obligatorio";
        }

        if(!$this->estacionamiento) {
            self::$errores[] = "El número de estacionamientos es obligatorio";
        }

        if(!$this->vendedores_id) {
            self::$errores[] = "Elige un vendedor";
        }

        if(!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }
        
        return self::$errores;
    }
}