document.addEventListener('DOMContentLoaded', function() {
    eventListener();
    darkMode();
})


function darkMode(){
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    console.log(prefiereDarkMode.matches);

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

