document.addEventListener('DOMContentLoaded', function () {
  const id = new URLSearchParams(window.location.search).get('id');
  const form = document.getElementById('formulario-mascota');
  const fileInput = form.querySelector('input[type="file"]');
  const preview = document.getElementById('previewImagen');
  const btnRegresar = document.getElementById('regresar');

  //tomamos los botones de los modales
  const modal = document.getElementById('modalMensaje');
  const mensajeTexto = document.getElementById('mensajeTexto');
  const closeModalBtn = document.getElementById('btnCerrarMensaje');

  // Función para mostrar el modal con un mensaje
  function mostrarModal(mensaje, redirigir = false) {
    mensajeTexto.textContent = mensaje;
    modal.style.display = 'flex';

    closeModalBtn.onclick = () => {
      modal.style.display = 'none';
      redirigir = true;
      if (redirigir) {
        window.location.href = 'adopcion.html';
      }
    };
  }

  // Botón regresar
  btnRegresar.addEventListener('click', () => {
    window.location.href = 'adopcion.html';
  });

  // Vista previa al seleccionar imagen
  fileInput.addEventListener('change', function () {
    const file = fileInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result; // Muestra la nueva imagen en el <img>
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file); // Lee la imagen como base64 para mostrarla
    }
  });

  if (!id) {
    mostrarModalMensaje("No se proporcionó una mascota para editar");
    window.location.href = "adopcion.html";
    return;
  }

  // Cargar datos de la mascota
  fetch(`/PatitasUnidas/backend/controllers/acciones/obtenerMascota.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        mostrarModalMensaje("No se pudo cargar la mascota.");
        return;
      }

      const mascota = data.mascota;

      // Rellenar campos
      form.nombre.value = mascota.nombre;
      form.especie.value = mascota.especie.toLowerCase();
      form.edad.value = mascota.edad;
      form.sexo.value = mascota.sexo.toLowerCase();
      form.descripcion.value = mascota.descripcion;
      form.tamanio.value = mascota.tamanio.toLowerCase();

      if (mascota.fotografia && mascota.fotografia.length > 100) {
        preview.src = `data:image/jpeg;base64,${mascota.fotografia}`;
      } else {
        preview.src = "/PatitasUnidas/frontend/src/assets/CabezaGatito.png";
      }
      preview.style.display = 'block';

      // Manejar envío
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        const nombre = form.nombre.value;
        const especie = form.especie.value;
        const edad = form.edad.value;
        const sexo = form.sexo.value;
        const descripcion = form.descripcion.value;
        const tamanio = form.tamanio.value;

        formData.append('idMascota', id);
        formData.append('nombre', nombre);
        formData.append('especie', especie);
        formData.append('edad', edad);
        formData.append('sexo', sexo);
        formData.append('descripcion', descripcion);
        formData.append('tamanio', tamanio);
        formData.append('idCentro', 1); // O el que corresponda

        const file = fileInput.files[0];
        if (file) {
          formData.append('fotografia', file);
        }

        fetch('/PatitasUnidas/backend/controllers/acciones/editarMascota.php', {
          method: 'POST',
          body: formData
        })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              mostrarModal('Mascota editada correctamente');
            } else {
              mostrarModal('Error: ' + data.mensaje);
            }
          })
          .catch(err => {
            console.error("Error al editar mascota:", err);
          });
      });
    })
    .catch(err => {
      console.error("Error al obtener mascota:", err);
    });
});
