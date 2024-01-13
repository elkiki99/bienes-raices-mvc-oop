addEventListener("DOMContentLoaded", function() {
    eventListeners();
    darkMode();
    limpiarErrores();
});

function darkMode() {
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereDarkMode.matches);

    if (prefiereDarkMode.matches) {
        document.body.classList.add("dark-mode");
    } else {
        document.body.classList.remove("dark-mode");
    }

    prefiereDarkMode.addEventListener("change", function() {
        if (prefiereDarkMode.matches) {
            document.body.classList.add("dark-mode");
        } else {
            document.body.classList.remove("dark-mode");
        }
    })

    const botonDarkMode = document.querySelector(".dark-mode-boton");

    botonDarkMode.addEventListener("click", function() {
        document.body.classList.toggle("dark-mode");
    });
}

function navegacionResponsive() {
    const navegacion = document.querySelector(".navegacion");

    if(navegacion.classList.contains("mostrar")) {

        navegacion.classList.remove("mostrar");
    } else {
        navegacion.classList.add("mostrar");
    }
}

function darkMode(){
 
    let miStorage = window.localStorage; //Objeto para controlar el Local-Storage de Windows
    let PrefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)'); //DEVUELVE VERDADERO SI EL VALOR POR DEFECTO DEL SISTEMA ES DARK
    
    if (miStorage.getItem('oscuro')==null) { // SI NO  EXISTE ALGUNA VARIABLE GUARDADA EN STORAGE CON LA CLAVE OSCURO
        if (PrefiereDarkMode.matches) { //COMO EL VALOR POR DEFECTO DEL SISTEMA ES OSCURO LE ASIGNAMOS ESE VALOR
            miStorage.setItem('oscuro', 1); //CREAMOS ESA VARIABLE EN STORAGE CON VALOR 1=OSCURO
            document.body.classList.add('dark-mode');
        }else{ //POR DEFECTO EL SSITEMA ESTA EN CLARO , DEVUELVE FALSO
            miStorage.setItem('oscuro', 0); //CREAMOS ESA VARIABLE EN STORAGE CON VALOR 0=CLARO
            document.body.classList.remove('dark-mode');
        }
    }
    else { //SI YA EXISTE ALGUNA VARIABLE ALMACENADA CON ESE NOMBRE Y UN VALOR 
        if (miStorage.getItem('oscuro')==1) { //VERIFICAMOS SI EL VALOR ES 1 =OSCURO
            document.body.classList.add('dark-mode'); //PONEMOS MODO OSCURO
        } else {                                     //SI EL VALOR ES BLANCO
            document.body.classList.remove('dark-mode'); //PONENMOS MODO CLARO
        }
    }
 
    PrefiereDarkMode.addEventListener('change',function(){ //FUNCION SI EXISTE CAMBIO EN PREFERENCIA DE TEMA POR EL USARIO
        if (PrefiereDarkMode.matches) { //EL TEMA SIGUE SIENDO OSCURO
            miStorage.setItem('oscuro', 1); //NUEVO VALOR PARA OSCURO=1
            document.body.classList.add('dark-mode');
        } else { //TEMA BLANCO
            miStorage.setItem('oscuro', 0); //NUEVO VALOR PARA OSCURO=0
            document.body.classList.remove('dark-mode');
        }
    })
 
    const botonDarkMode=document.querySelector('.dark-mode-boton'); //EVENTO PARA EL BOTON
    botonDarkMode.addEventListener('click',function(){ //AÑÁDIMOS EVENTO
        if (document.body.classList.contains('dark-mode')) { //SI CAMBIAMOS A MODO CLARO
            miStorage.setItem('oscuro', 0); //NUEVO VALOR PARA STORAGE OSCURO=0 
            document.body.classList.remove('dark-mode'); //
        } else { //SI CAMBIAMOS A MODO OSCURO
            miStorage.setItem('oscuro', 1); //NUEVO VALOR PARA STORAGE OSCURO=1
            document.body.classList.add('dark-mode');
        }
    })
}

function limpiarErrores(){
      
    const errores = document.querySelectorAll('.alerta');
    
    if(errores.length !==null){
        errores.forEach( error => {
            setTimeout(() => {
                error.remove();
            }, 5000)
        } )
    }
}

function eventListeners() {
    const mobileMenu = document.querySelector(".mobile-menu");

    mobileMenu.addEventListener("click", navegacionResponsive);

    // Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach(input => input.addEventListener("click", mostrarMetodoContacto));
}

function mostrarMetodoContacto(e) {
    const contactoDiv = document.querySelector("#contacto");

    if(e.target.value === "Telefono") {
        contactoDiv.innerHTML = `
            <label for="telefono"></label>
            <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]" required>

            <p>Elija la fecha y la hora para ser contactado</p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]" required>

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]" required>
        `;
    } else {
        contactoDiv.innerHTML = `
            <label for="email"></label>
            <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" required>
        `;
    }
}


