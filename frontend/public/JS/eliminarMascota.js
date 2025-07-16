document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor-mascotas");
  const modalConfirmacion = document.getElementById("modalConfirmacion");
  const btnCancelar = document.getElementById("btnCancelarEliminar");
  const btnConfirmar = document.getElementById("btnConfirmarEliminar");
  let idMascotaSeleccionada = null;

  // Abrir el modal de confirmación
  function abrirModalConfirmacion(idMascota) {
    idMascotaSeleccionada = idMascota;
    modalConfirmacion.style.display = "flex";
  }

  // Cerrar el modal de confirmación
  function cerrarModalConfirmacion() {
    modalConfirmacion.style.display = "none";
    idMascotaSeleccionada = null;
  }

  // Escuchar clic en botón "Cancelar" del modal
  btnCancelar.addEventListener("click", cerrarModalConfirmacion);

  // Cerrar modal si se hace clic fuera del contenido
  window.addEventListener("click", (e) => {
    if (e.target === modalConfirmacion) {
      cerrarModalConfirmacion();
    }
  });

  // Escuchar clic en botón "Eliminar" del modal
  btnConfirmar.addEventListener("click", () => {
    if (!idMascotaSeleccionada) return;

    fetch(`/PatitasUnidas/backend/controllers/acciones/eliminarMascota.php?id=${idMascotaSeleccionada}`)
      .then(res => res.json())
      .then(data => {
        if (data.message.includes("correctamente")) {
          alert("Mascota eliminada correctamente.");
          location.reload();
        } else {
          alert("No se pudo eliminar la mascota.");
        }
      })
      .catch(err => {
        console.error("Error al eliminar mascota:", err);
        alert("Error inesperado al eliminar la mascota.");
      })
      .finally(() => cerrarModalConfirmacion());
  });

  // Escuchar clic en botón Eliminar de cada tarjeta
  contenedor.addEventListener("click", (e) => {
    if (e.target.classList.contains("delete")) {
      const idMascota = e.target.getAttribute("data-id");
      abrirModalConfirmacion(idMascota);
    }
  });
});
