<?php 
    require 'includes/app.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="iamge/webp">
                    <source srcset="build/img/nosotros.jpg" type="iamge/jpeg">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre Nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>
                    25 Años de experiencia
                </blockquote>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut reprehenderit sit voluptate asperiores ipsum illo corporis ipsa sapiente nemo doloremque inventore eaque, quae a possimus quo, consequuntur amet ab optio! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione, a optio cum itaque explicabo iste! Vitae libero corporis suscipit eum cum dicta veritatis, numquam laudantium ad, dolore reiciendis iure excepturi.</p>

                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illum, mollitia? Et quas, nulla, debitis natus rem nostrum pariatur quasi eum modi saepe at illo, quo inventore officia expedita alias sunt! Vel alias expedita nihil voluptas voluptatum nam iure, repudiandae quo in dolorum, temporibus quod illo. Ea officia pariatur reprehenderit, in eius quos, recusandae molestias explicabo, rem quidem hic iure earum?</p>

            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Título Página</h1>
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur explicabo tempora quisquam sit earum porro quaerat consequatur vitae voluptatibus cumque non recusandae, quidem in eaque corporis temporibus voluptatum. Quos, in!</p>
            </div>

            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur explicabo tempora quisquam sit earum porro quaerat consequatur vitae voluptatibus cumque non recusandae, quidem in eaque corporis temporibus voluptatum. Quos, in!</p>
            </div>

            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur explicabo tempora quisquam sit earum porro quaerat consequatur vitae voluptatibus cumque non recusandae, quidem in eaque corporis temporibus voluptatum. Quos, in!</p>
            </div>
        </div>
    </section>

<?php incluirTemplate('footer')?>