document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor-mascotas");

  contenedor.addEventListener("click", function (e) {
    if (e.target.classList.contains("delete")) {
      const idMascota = e.target.getAttribute("data-id");

      const confirmar = confirm("¿Estás seguro de que quieres eliminar esta mascota?");
      if (!confirmar) return;

      fetch(`/PatitasUnidas/backend/controllers/acciones/eliminarMascota.php?id=${idMascota}`)
        .then(res => res.json())
        .then(data => {
          if (data.message.includes("correctamente")) {
            alert("Mascota eliminada correctamente.");
            location.reload(); // o puedes eliminar visualmente la tarjeta sin recargar
          } else {
            alert("No se pudo eliminar la mascota.");
          }
        })
        .catch(err => {
          console.error("Error al eliminar mascota:", err);
          alert("Error inesperado al eliminar la mascota.");
        });
    }
  });
});
