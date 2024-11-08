<?php 
namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class PropiedadController {
    public static function index(Router $router) {
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null; 
        
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router) {
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crea nueva instancia
            $propiedad = new Propiedad($_POST['propiedad']);

            // Generar un nombre único
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; 
            
            // Realiza un resize a la imagen con intervation
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(new Driver()); // se pasa el motor (driver) al administrador (image)
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800,600);  
                $propiedad->setImagen($nombreImagen);
            }
        
            // Validar
            $errores = $propiedad->validar();
            if(empty($errores)){
                // Crea la carpeta para subir imagenes
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen); // guarda la imagen modificada en la ruta especificada
                // Guarda la imagen en la base de datos
                $propiedad->guardar();                   
            } 
        } 
        
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores, 
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            // Realiza un resize a la imagen con intervation
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(new Driver()); // se pasa el motor (driver) al administrador (image)
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800,600);  
                $propiedad->setImagen($nombreImagen);
            }
            
            // Validar
            $errores = $propiedad->validar();
            if(empty($errores)) {
                if($_FILES['propiedad']['tmp_name']['imagen']) {
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $propiedad->guardar();                   
            } 
        }
        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad, 
            'vendedores' => $vendedores, 
            'errores' => $errores 
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if($id) {
                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}