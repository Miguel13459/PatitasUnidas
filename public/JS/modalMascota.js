document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById('modalMascota');
  const cerrarModal = document.getElementById('cerrarModal');

  // 🔥 Función para abrir modal y cargar datos
  function abrirModal(idMascota) {
    fetch(`/PatitasUnidas/app/controllers/acciones/obtenerMascota.php?id=${idMascota}`)
      .then(response => response.json())
      .then(data => {
        if (!data.success) {
          console.error('❌ Mascota no encontrada');
          return;
        }

        const mascota = data.mascota;

        document.getElementById('modalNombreMascota').textContent = mascota.nombre;
        document.getElementById('modalEdadRaza').textContent = `${mascota.edad} - ${mascota.especie}`;
        document.getElementById('modalTamanoMascota').textContent = mascota.tamanio;
        document.getElementById('modalSexoMascota').textContent = mascota.sexo;
        document.getElementById('modalDescripcionMascota').textContent = mascota.descripcion;

        let imgSrc = "/PatitasUnidas/src/assets/CabezaGatito.png";
        if (mascota.fotografia && mascota.fotografia.length > 100) {
          imgSrc = `data:image/jpeg;base64,${mascota.fotografia}`;
        }
        document.getElementById('modalFotoMascota').src = imgSrc;

        // ✅ Mostrar el modal
        modal.style.display = "block";
      })
      .catch(err => {
        console.error('❌ Error cargando detalles de la mascota:', err);
      });
  }

  // 🖱️ Escuchar clic en botones "Detalles"
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("details")) {
      const idMascota = e.target.getAttribute("data-id");
      abrirModal(idMascota);
    }
  });

  // ❌ Cerrar modal con X
  cerrarModal.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // ❌ Cerrar modal al hacer clic fuera del contenido
  window.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });
});
