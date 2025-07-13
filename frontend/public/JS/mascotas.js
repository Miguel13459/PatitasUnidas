document.addEventListener("DOMContentLoaded", function () {
  const contenedor = document.getElementById("contenedor-mascotas");

  fetch("/PatitasUnidas/backend/controllers/acciones/mostrarMascota.php")
    .then(response => response.json())
    .then(mascotas => {
      mascotas.forEach(mascota => {
        const card = document.createElement("article");
        card.classList.add("card");

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

        card.innerHTML = `
          <img src="${imgSrc}" alt="${mascota.nombre}">
          <h3>${mascota.nombre}</h3>
          <p class="meta">${mascota.edad} semanas &nbsp; ${mascota.especie}</p>
          <button class="btn edit">Editar</button>
          <button class="btn delete">Eliminar</button>
        `;

        //Evento para editar
        card.querySelector('.edit').addEventListener('click', () => {
          localStorage.setItem('mascotaEditar', JSON.stringify(mascota));
          window.location.href = '/PatitasUnidas/frontend/public/Formulario-Editar.html';
        });

        contenedor.appendChild(card);
      });
    })
    .catch(error => {
      console.error("Error al cargar mascotas:", error);
    });
});
