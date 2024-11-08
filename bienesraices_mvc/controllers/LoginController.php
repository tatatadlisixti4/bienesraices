<?php
namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController {
    public static function login(Router $router) {;
        $errores = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);
            $errores = $auth->validar();
            
            if(empty($errores)) {
                // Verificar si el usuario existe
                $resultado = $auth->existeUsuario();
                if(!$resultado) {
                    $errores = Admin::getErrores();
                } else {
                    // Verificar el password
                    $autenticado = $auth->comprobarPassword($resultado);
                    if($autenticado) {
                        // Autenticar al usuario
                        $auth->autenticar();
                    } else {
                        // Password incorrecto (mensaje de error)
                        $errores = Admin::getErrores();
                    }
                }
            }
        }

        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }

    public static function logout(Router $router) {
        session_start();
        $_SESSION = []; // Vacío el arreglo de la sesión. Esto no significa eliminarla, ya que está on y podría usar su id y agregar nuevos datos a la sesion.
        session_destroy(); // Destruye la sesion, esto elimina tanto el id de la sesion como sus datos y la cierra al usuario inmediatamente. No se han eliminado las cookies pero son inutiles.
        header('Location: /');
    }
}


