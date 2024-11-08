<?php 
    // Verificar login
    require '../../includes/app.php';
    use App\Propiedad;
    use App\Vendedor;

    // use Intervention\Image\ImageManagerStatic as Image;
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;

    estaAutenticado();
    $propiedad = new Propiedad; // Se genera una propiedad vacía para poder usar sus atributos en el formulario

    // Obtener todos los vendedores
    $vendedores = Vendedor::all();

    // Inicializo el arreglo con los mensajes de errores
    // $errores = Propiedad::getErrores();

    // Validacion POST, captura datos e insercion de los mismos en la bd
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
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
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <!-- Renderizado errores con php -->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>  
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data"> <!-- Este ultimo atributo es para subir archivos hacia el servidor -->
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>
            <input type="submit" value="Crear Propiedad" class="boton boton-verde">

        </form>
    </main>

<?php 
    incluirTemplate('footer')
?>
