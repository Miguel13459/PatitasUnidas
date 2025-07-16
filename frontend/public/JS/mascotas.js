document.addEventListener("DOMContentLoaded", function () {
  const contenedor = document.getElementById("contenedor-mascotas");
  const botonAgregar = document.querySelector("#agregarBotonContenedor");
  const adminMenu = document.querySelector("#adminMenu"); 

  //Detecta si está en modo público o admin
  /*const urlParams = new URLSearchParams(window.location.search);
  const modoPublico = urlParams.get('modo') === 'publico';*/

  fetch("/PatitasUnidas/backend/controllers/acciones/verificarSesion.php")
    .then(res => res.json())
    .then(data => {
      const esAdmin = data.autenticado;

      // Ocultar el botón de agregar si no es admin
      if (!esAdmin && botonAgregar) {
        botonAgregar.style.display = "none";
      }

      // Ocultar menú de administrador si no hay sesión
      if (!esAdmin && adminMenu) {
        adminMenu.style.display = "none";
      }


      fetch("/PatitasUnidas/backend/controllers/acciones/mostrarMascota.php") //realiza una petición a esta direccion del servidor
        .then(response => response.json()) //guarda la respuesta
        .then(mascotas => {
          mascotas.forEach(mascota => { //recorre la respuesta con un for each, es decir, todos los objetos del archivo json
            const card = document.createElement("article");
            card.classList.add("card");

            //Valida la imagen si no hay nada en la base de datos pone la que hay en la dirección por defecto
            let imgSrc = "/PatitasUnidas/frontend/src/assets/CabezaGatito.png";
            if (mascota.fotografia && mascota.fotografia.length > 100) {
              imgSrc = `data:image/jpeg;base64,${mascota.fotografia}`;
            }

            //Condiciona botones según el modo, es decir admin o público
            let botonesHTML = `
              <button class="btn details" data-id="${mascota.idMascota}">Detalles</button>
            `;

            if (esAdmin) {
              botonesHTML = `
                <a href="Formulario-Editar.php?id=${mascota.idMascota}" class="btn edit" id='editar'>Editar</a>
                <button class="btn delete" data-id="${mascota.idMascota}">Eliminar</button>
                <button class="btn details" data-id="${mascota.idMascota}">Detalles</button>
              `;
            }

            // este pedacito contiene eliminar y editar con el id de la mascota
            // esta es la tarjeta de la mascotita
            card.innerHTML = `
              <img src="${imgSrc}" alt="${mascota.nombre}">
              <h3>${mascota.nombre}</h3>
              <p class="meta">${mascota.edad} &nbsp; ${mascota.especie}</p>
              ${botonesHTML}
            `;
            
            contenedor.appendChild(card);
          });
        })
        .catch(error => {
          console.error("Error al cargar mascotas:", error);
        });
    })
    .catch(err => {
      console.error("Error al verificar sesión:", err);
    });
});
