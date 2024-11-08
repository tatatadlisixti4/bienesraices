<?php
    require '../../includes/app.php';
    use App\Vendedor;
    estaAutenticado();

    // Validar ID
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id) {
        header('Location: /admin');
    }
    // Obtener arreglo vendedor
    $vendedor = Vendedor::find($id);

    // Arreglo con mensajes de errores;
    $errores = Vendedor::getErrores();
    

    // Validacion POST, captura datos e insercion de los mismos en la bd
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Asignar los valores
        $args = $_POST['vendedor'];
        // Sincronizar en memoria con lo que el usuario escribió 
        $vendedor->sincronizar($args);
        // Validación
        $errores = $vendedor->validar();

        if(empty($errores)){
            $vendedor->guardar();
        }  
    }
    
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Actualizar Vendedor</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <!-- Renderizado errores con php -->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>  
        <?php endforeach; ?>

        <form class="formulario" method="POST">
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>
            <input type="submit" value="Actualizar Vendedor" class="boton boton-verde">

        </form>
    </main>

<?php 
    incluirTemplate('footer')
?>
