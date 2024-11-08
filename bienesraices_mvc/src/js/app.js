document.addEventListener('DOMContentLoaded', function() {
    eventListener();
    darkMode();
})


function darkMode(){
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    if (prefiereDarkMode.matches){ // Gracias al addeventlistener de abajo no es necesario mantener este if
        document.body.classList.add('dark-mode');
    } 
    
    prefiereDarkMode.addEventListener('change', function(){
        if (prefiereDarkMode.matches){
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode'); 
        }
    })

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    });
}


function eventListener() {
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.addEventListener('click', navegacionResponsive);

    // Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    console.log(metodoContacto);
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));
    
    
}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');
    
    if (e.target.value === 'telefono') {
        // contactoDiv.textContent = 'Elegiste teléfono';
        contactoDiv.innerHTML = `
            <label for="telefono">Escriba su número telefónico</label>
            <input type="tel" placeholder="Ej: 9-12345678" id="telefono" name="contacto[telefono]">
            
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;

        
    } else {
        // contactoDiv.textContent = 'Elegiste E-Mail';
        contactoDiv.innerHTML = `
            <label for="email">Escriba su correo electrónico:</label>
            <input type="email" placeholder="Ej: thadli@gmail.com" id="email" name="contacto[email]" >
        `;
    }
}

function navegacionResponsive(){
    console.log('desde navResponsive');
    const navegacion = document.querySelector('.navegacion');
    
    if(navegacion.classList.contains('mostrar')) {   // se puede ahorrar todo este if else con: navegacion.classList.toggle('mostrar')
        navegacion.classList.remove('mostrar');
    } else {
        navegacion.classList.add('mostrar');
    }
}


