<?php

namespace Model;
 
class ActiveRecord{
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];

    // Definir la conexión a la base de datos
    public static function setDB($database) {
        self::$db = $database;                          // self:: hace referencia a los atributos estáticos de una misma clase
    }

    public function guardar() {
        if(!is_null($this->id)) {
            // Actualizando
            $this->actualizar();
        } else {
            // Creando un nuevo registro
            $this->crear();
        }
    }

    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(", ", array_keys($atributos));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        // Mensaje de éxito o error
        if($resultado) {
            // Redireccionamos al usuario para que no envíen varias veces datos duplicados
            header("Location: /admin?resultado=1");
        }
    }

    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key} ='{$value}'";
        }

        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= join (", ", $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);
        
        if($resultado) {
            header("Location: /admin?resultado=2");
        }
        return $resultado;
    }

    // Eliminar un registro
    public function eliminar($carpeta) {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen($carpeta);
            header("location: /admin?resultado=3");
        }
    }

    // Identificar y unir los atributos de la base de datos en un nuevo arreglo llamado "atributos"
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === "id") continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los atributos
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);                   // Arreglo ya sanitizado que es el que se va a insertar en la BD
        }
        return $sanitizado;
    }

    // Subida de archivos
    public function setImagen($imagen, $carpeta) {
        // Elimina la imagen previa
        if(!is_null($this->id)) {
            $this->borrarImagen($carpeta);
        }

        // Asignar al atributo de imagen el nombre de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Elimina un archivo
    public function borrarImagen($carpeta) {
        // Comprobar si existe el archivo
        $existeArchivo = file_exists($carpeta . $this->imagen);
        if($existeArchivo) {
            unlink($carpeta . $this->imagen);
        }
    }

    // Validación
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    // Lista todas las propiedades
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Obtiene determinado número de registros
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }


    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        
        $resultado = self::consultarSQL($query);

        return (array_shift($resultado));
    }

    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro) {       // Transformamos un array a un objeto
        $objeto = new static;

        foreach($registro as $key => $value) {
            if(property_exists($objeto, $key))
            $objeto->$key = $value;
        }
        return $objeto;
    }

    // Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}