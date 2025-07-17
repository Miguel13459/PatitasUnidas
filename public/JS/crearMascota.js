document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('#formulario-mascota');
  const fileInput = form.querySelector('input[type="file"]');
  const preview = document.getElementById('previewImagen');
  const modalMensaje = document.getElementById('modalMensaje');
  const mensajeTexto = document.getElementById('mensajeTexto');
  const btnCerrarMensaje = document.getElementById('btnCerrarMensaje');

  // Mostrar vista previa al seleccionar imagen
  fileInput.addEventListener('change', function () {
    const file = fileInput.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      preview.src = '';
      preview.style.display = 'none';
    }
  });

  // Mostrar modal de mensaje (éxito o error)
  function mostrarModalMensaje(texto, recargar = false, redirect = null) {
    mensajeTexto.textContent = texto;
    modalMensaje.style.display = 'flex';

    btnCerrarMensaje.onclick = () => {
      modalMensaje.style.display = 'none';
      if (redirect) {
        window.location.href = redirect;
      } else if (recargar) {
        location.reload();
      }
    };

    window.onclick = (e) => {
      if (e.target === modalMensaje) {
        modalMensaje.style.display = 'none';
        if (redirect) {
          window.location.href = redirect;
        } else if (recargar) {
          location.reload();
        }
      }
    };
  }

  // Manejar envío del formulario
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData();
    const fileInput = form.querySelector('input[type="file"]');

    const nombre = form.querySelector('input[name="nombre"]').value;
    const especie = form.querySelector('select[name="especie"]').value;
    const edad = form.querySelector('input[name="edad"]').value;
    const sexo = form.querySelector('select[name="sexo"]').value;
    const descripcion = form.querySelector('input[name="descripcion"]').value;
    const tamanio = form.querySelector('select[name="tamanio"]').value;

    formData.append('nombre', nombre);
    formData.append('especie', especie);
    formData.append('edad', edad);
    formData.append('sexo', sexo);
    formData.append('descripcion', descripcion);
    formData.append('tamanio', tamanio);
    formData.append('idCentro', 1); //cambiar el id según sea necesario
    formData.append('fotografia', fileInput.files[0]);

    fetch('/PatitasUnidas/app/controllers/acciones/crearMascota.php', {
      method: 'POST',
      body: formData,
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          mostrarModalMensaje('Mascota creada correctamente', false, 'adopcion.html');
        } else {
          mostrarModalMensaje('Error: ' + data.mensaje);
        }
      })
      .catch(err => {
        console.error('Error al crear mascota:', err);
        mostrarModalMensaje('Error inesperado.');
      });
  });
});
