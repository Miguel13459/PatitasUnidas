document.addEventListener("DOMContentLoaded", function () {
  const contenedor = document.getElementById("contenedor-mascotas");

  fetch("/PatitasUnidas/backend/controllers/acciones/mostrarMascota.php")
    .then(response => response.json())
    .then(mascotas => {
      mascotas.forEach(mascota => {
        const card = document.createElement("article");
        card.classList.add("card");

        const imgSrc = `data:image/jpeg;base64,${mascota.fotografia}`;

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