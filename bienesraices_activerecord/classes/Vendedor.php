<?php 
namespace App;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    // Atributos con el mismo nombre que las columnas de la bd (Active Record patron de diseño)
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$errores[] = "Debes añadir un nombre"; 
        }
        if(!$this->apellido) {
            self::$errores[] = "Debes añadir un apellido"; 
        }
        if(!$this->telefono) {
            self::$errores[] = "Debes añadir un telefono"; 
        }
        if (!preg_match('/^\d{9}$/', $this->telefono)) {
            self::$errores[] = "Formato no válido"; 
        } // La diag al inicio y al final delimitan la exp reg, ^: inicio y $: fin de la cadena, \d: atajo a [0-9], {9}: quantificador.
        
        return self::$errores;
    }
}