<?php
namespace App;

class ActiveRecord {
    // Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];

    public static function setDB($database) {
        self::$db = $database;
    }

    // Error que en tiempo de ejec no ocurre, debido a que id existe en las clases hijas
    public function guardar() {
        if($this->id){ 
            // Actualizar
            $this->actualizar();
        } else {
            // Crear
            $this->crear();
        }
    }

    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insercion datos mediante consulta concatenada variable tras variable para que sea mas dinamica y legible
        $query = " INSERT INTO ". static::$tabla ."( "; 
        $query .= join(', ', array_keys($atributos)); // Extraer las llaves de la lista de atributo para facilitar la creacion de la query de forma mas dinamica.
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos)); // Extraer los valores de la lista de atributo para facilitar la creacion de la query de forma mas dinamica.
        $query .= " '); ";
        // Se está utilizando $db como si fuese un objeto de la clase mysqli, ya que se fue "instanciado" desde el app.php, ejecutando la funcion setDB de abajo y pasandole a $db el valor de una conexion de base de datos.
        $resultado = self::$db->query($query);   
        
        if ($resultado) {
            if (headers_sent()) {
                die("Headers already sent."); // Verifica si se han enviado encabezados http y si es asi, los elimina.
            } // Funciona sin el pero en una de esas puede servir a futuro.
            // Redireccionar al usuario.
            header('Location: /admin?resultado=1'); 
        } 
    }

    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }
        $query = " UPDATE ". static::$tabla ." SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";
        $resultado = self::$db->query($query);
        
        if($resultado) {
            // Redireccionar al usuario.
            header('Location: /admin?resultado=2');  // Query string en el header para mandar el id por url
        }
    }

    // Eliminar un registro
    public function eliminar() {
        $query = "DELETE FROM ". static::$tabla ." WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1 "; 
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        } 
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value) {
            $sanitizado[$key] =  self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Subida de archivos
    public function setImagen($imagen){
        // Eliminar imagen previa
        if(isset($this->id)) {
            $this->borrarImagen();
        }
        // Asignar al atributo imagen el nombre de la imagen extraida con post
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Eliminacion de archivos
    public function borrarImagen() {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {    
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Validación (pienso que está de más)
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    // Lista todas los registros
    public static function all() {
        $query = "SELECT * FROM ". static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtener n°x registros 
    public static function get($cantidad) {
        $query = "SELECT * FROM ". static::$tabla. " LIMIT ". $cantidad;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca una registro por su id
    public static function find($id){ 
        $query= "SELECT * FROM ". static::$tabla ." WHERE id = ". $id. ";";
        $resultado = self::consultarSQL($query); // Devuelve un array con el objeto
        return(array_shift($resultado)); // Devuelve el primero, que que es un array que en la posicion 0 tiene el objeto
    }

    public static function consultarSQL($query) {
        // Consultad la bd
        $resultado = self::$db->query($query);
        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        // Liberar memoria
        $resultado->free();
        // Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;
        foreach($registro as $key => $value) {
            if(property_exists( $objeto, $key )){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = [] ){
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
