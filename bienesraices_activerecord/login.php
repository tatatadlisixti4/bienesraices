<?php

    require 'includes/app.php';
    $db = conectarDB();
    $errores = [];

    // Autenticar el usuario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!$email) {
            $errores[] = "El email es obligatorio o no es válido";
        }
        if(!$password) {
            $errores[] = "El Password es obligatorio";
        }
        if(empty($errores)) {
            // Query si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '{$email}';";     
            $resultado = mysqli_query($db, $query);

            if($resultado->num_rows){
                // Se verifica mediante comparacion password escrito por usuario y password hasheado extraido de bd mediante email
                $usuario = mysqli_fetch_assoc($resultado);
                $auth = password_verify($password, $usuario['contraseña']); 
                
                if($auth){
                    /* El usuario está autenticado, se trabajará con el superglobal $_SESSION y sus metodos. */
                    // Se inicia la sesion
                    session_start();

                    // Se llena el arreglo de la sesion 
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location:/admin');

                } else {
                    $errores[] = "El password es incorrecto";
                }

            } else {
                $errores[] = "El usuario no existe";
            }
        }
    }
    

    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error;?>
            </div>
        <?php endforeach;?>

        <form method="POST" class="formulario" novalidate>  <!-- No recomendable el novalidate, aqui lo usamos para probar las validaciones del backend-->
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Ej: thadli@gmail.com" id="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu Password" id="password" required>
            </fieldset>

            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>
    </main>
    
<?php 
    incluirTemplate('footer');
?>