<?php 
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;

    require '../../includes/app.php';
    use App\Propiedad;
    use App\Vendedor;

    estaAutenticado();

    // Validar Id mandado por Url (metodo get)
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    // Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);
    // Consultar para obtener los vendedores
    $vendedores = Vendedor::all();
    // Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    // Ejecutar el código después de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Asignar los atributos
        $args = $_POST['propiedad'];
        $propiedad->sincronizar($args);
        
        // Generar un nombre único
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
            // Almacenar la imagen
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }

            $propiedad->guardar();
        }
    }

    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <!-- Renderizado errores con php -->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>  
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>
            <input type="submit" value="Actualiza propiedad" class="boton boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer')
?>
