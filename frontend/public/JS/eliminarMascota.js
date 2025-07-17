document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor-mascotas");
  const modalConfirmacion = document.getElementById("modalConfirmacion");
  const modalMensaje = document.getElementById("modalMensaje");
  const mensajeTexto = document.getElementById("mensajeTexto");
  const btnCerrarMensaje = document.getElementById("btnCerrarMensaje");
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

  // Mostrar modal de mensaje
  function mostrarModalMensaje(texto, recargar = false) {
    mensajeTexto.textContent = texto;
    modalMensaje.style.display = "flex";

    btnCerrarMensaje.onclick = () => {
      modalMensaje.style.display = "none";
      if (recargar) location.reload();
    };

    window.onclick = (e) => {
      if (e.target === modalMensaje) {
        modalMensaje.style.display = "none";
        if (recargar) location.reload();
      }
    };
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
          mostrarModalMensaje(data.message, true);
        } else {
          mostrarModalMensaje(data.message);
        }
      })
      .catch(err => {
        console.error("Error al eliminar mascota:", err);
        mostrarModalMensaje("Error inesperado al eliminar la mascota.");
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
