<?php 
namespace App;


class Propiedad extends ActiveRecord {
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    // Atributos con el mismo nombre que las columnas de la bd (Active Record patron de diseño)
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }


    public function validar() {
        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo"; // Añade al final del array, sintaxis solo de php, no está en js
        }
        if(!$this->precio) {
            self::$errores[] = "Debes añadir un precio";
        }
        if(strlen($this->descripcion) < 50) {
            self::$errores[] = "Debes añadir una descripcion y debe tener max. 50 caracteres";
        }
        if(!$this->habitaciones) {
            self::$errores[] = "El numero de habitaciones es obligatorio";
        }
        if(!$this->wc) {
            self::$errores[] = "El numero de baños es obligatorio";
        }
        if(!$this->estacionamiento) {
            self::$errores[] = "El numero de lugares de estacionamiento es obligatorio";
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