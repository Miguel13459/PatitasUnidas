document.addEventListener("DOMContentLoaded", function () {
  const contenedor = document.getElementById("contenedor-mascotas");

  fetch("/PatitasUnidas/backend/controllers/acciones/mostrarMascota.php")
    .then(response => response.json())
    .then(mascotas => {
      mascotas.forEach(mascota => {
        const card = document.createElement("article");
        card.classList.add("card");

        //console.log(response);
        console.log(mascota);
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

        console.log(imgSrc);
        //console.log("Imagen base64 (truncada):", mascota.fotografia.substring(0, 100));

        card.innerHTML = `
          <img src="${imgSrc}" alt="${mascota.nombre}">
          <h3>${mascota.nombre}</h3>
          <p class="meta">${mascota.edad} semanas &nbsp; ${mascota.especie}</p>
          <a href="formulario-editar.html" class="btn edit">Editar</a>
          <button class="btn delete">Eliminar</button>
        `;

        contenedor.appendChild(card);
      });
    })
    .catch(error => {
      console.error("Error al cargar mascotas:", error);
    });
});
