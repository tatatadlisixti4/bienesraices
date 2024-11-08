<?php
namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {
        $propiedades = Propiedad::get(3);
        $router->render('paginas/index', [
            'propiedades'=>$propiedades,
            'inicio'=>true
        ]);
    }


    public static function nosotros(Router $router) {
        $router->render('paginas/nosotros');
    }
    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades'=>$propiedades
        ]);

    }
    public static function propiedad(Router $router) {
        $id = validarORedireccionar('/');
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad', [
            'propiedad'=>$propiedad
        ]);
    }
    public static function blog(Router $router) {
        $router->render('paginas/blog');
    }
    public static function entrada(Router $router) {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router) {
        $mensaje = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['contacto'];

            // Crear instancia PHP Mailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'd1d7b78938a157';
            $mail->Password = '60ac1d6d1eb04a';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com'); 
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            
            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<P>Nombre: ' . $respuestas['nombre'] . '</p>';

            // Enviar de forma condicional algunos campos de email o teléfono
            if($respuestas['contacto'] === 'telefono') {
                $contenido .= '<P>Eligió ser contactado por teléfono:</p>';
                $contenido .= '<P>Teléfono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<P>Fecha Contacto: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<P>Hora: ' . $respuestas['hora'] . '</p>';

            } else {
                $contenido .= '<P>Eligió ser contactado por E-Mail:</p>';
                $contenido .= '<P>E-Mail: ' . $respuestas['email'] . '</p>';
            }
            
            $contenido .= '<P>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<P>Vende o Compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<P>Precio o Presupuesto: $' . $respuestas['precio'] . '</p>';
            
            
            $contenido .= '</html>';
            

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            // Enviar el email
            if($mail->send()) {
                $mensaje = "Mensaje Enviado Correctamente";
            } else {
                $mensaje = "Error al enviar el mensaje";
            }
        }
        $router->render('paginas/contacto',  [
            'mensaje' => $mensaje
        ]);
    }
}