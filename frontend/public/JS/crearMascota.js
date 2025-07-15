document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('#formulario-mascota');
  const fileInput = form.querySelector('input[type="file"]');
  const preview = document.getElementById('previewImagen');

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


  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData();
    const fileInput = form.querySelector('input[type="file"]');

    // Usamos name para asegurar orden correcto
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
    formData.append('idCentro', 1); // O el ID correspondiente
    formData.append('fotografia', fileInput.files[0]);

    fetch('/PatitasUnidas/backend/controllers/acciones/crearMascota.php', {
      method: 'POST',
      body: formData,
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert('Mascota creada correctamente');
          //window.location.href = '/PatitasUnidas/frontend/public/adopcion.html';
        } else {
          alert('Error: ' + data.mensaje);
        }
      })
      .catch(err => {
        console.error('Error al crear mascota:', err);
        alert('Error inesperado.');
      });
  });
});
