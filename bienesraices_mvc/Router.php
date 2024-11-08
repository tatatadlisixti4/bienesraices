<?php
namespace MVC;
class Router {
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas() { 
        // Comprobacion sesion
        session_start();
        $auth = $_SESSION['login'] ?? null;

        // Arreglo rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];
        
        $urlActual = $_SERVER['PATH_INFO'] ?? '/'; 
        $metodo = $_SERVER['REQUEST_METHOD'];
        
        if($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        // Proteger las rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /'); 
        }

        if($fn) {
            /* 
            Si la URL existe y hay funcion asociada
            - call_user_func: primer parámetro es el nombre de la función o un array que contiene el objeto y el método que se desea llamar, lo demas son parametros.
            */ 
            call_user_func($fn, $this); 
        } else  {
            echo "Página no encontrada";
        }
    }

    // Muestra una vista
    public function render($view, $datos = []) {
        foreach($datos as $key => $value) {
            $$key = $value; // Genero variables cuyos nombres son el contenido de $key. 
        }
        
        // Inicia la captura de salida, cualquier salida generada después de esto no se envía inmediatamente al navegador, sino que se almacena en un buffer.
        ob_start(); 
        include __DIR__ . "/views/{$view}.php";

        // Limpia el buffer, no se envía nada al navegador
        $contenido = ob_get_clean();
        include __DIR__ . "/views/layout.php";
    }
} 