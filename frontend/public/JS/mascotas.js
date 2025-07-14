document.addEventListener("DOMContentLoaded", function () {
  const contenedor = document.getElementById("contenedor-mascotas");

  fetch("/PatitasUnidas/backend/controllers/acciones/mostrarMascota.php") //realiza una petición a esta direccion del servidor
    .then(response => response.json()) //guarda la respuesta
    .then(mascotas => {
      mascotas.forEach(mascota => { //recorre la respuesta con un for each, es decir, todos los objetos del archivo json
        const card = document.createElement("article");
        card.classList.add("card");

        //valida lo que ingreses de la imagen
        let imgSrc;
        try {
          if (mascota.fotografia && mascota.fotografia.length > 100) {
            imgSrc = `data:image/jpeg;base64,${mascota.fotografia}`;
          } else {
            throw new Error("Imagen vacía o inválida");
          }
        } catch (e) {
          imgSrc = "/PatitasUnidas/frontend/src/assets/CabezaGatito.png";
        }

        // este pedacito contiene eliminar y editar con el id de la mascota
        // esta es la tarjeta de la mascotita
        card.innerHTML = `
          <img src="${imgSrc}" alt="${mascota.nombre}">
          <h3>${mascota.nombre}</h3>
          <p class="meta">${mascota.edad} &nbsp; ${mascota.especie}</p>
          <a href="Formulario-Editar.html?id=${mascota.idMascota}" class="btn edit" id='editar'>Editar</a>
          <button class="btn delete">Eliminar</button>
        `;

        /*
        //Evento para editar
        card.querySelector('#editar').addEventListener('click', () => {
          localStorage.setItem('mascotaEditar', JSON.stringify(mascota));
          window.location.href = '/PatitasUnidas/frontend/public/Formulario-Editar.html';
        });*/

        contenedor.appendChild(card);
      });
    })
    .catch(error => {
      console.error("Error al cargar mascotas:", error);
    });
});
