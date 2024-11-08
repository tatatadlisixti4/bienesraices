<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error;?>
        </div>
    <?php endforeach;?>

    <form method="POST" class="formulario" action="/login" novalidate>  <!-- No recomendable el novalidate, aqui lo usamos para probar las validaciones del backend-->
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