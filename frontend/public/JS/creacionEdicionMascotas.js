document.getElementById('formulario-mascota').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    /*const fileInput = form.querySelector('input[type="file"]');

    //imputs del formulario
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
    formData.append('fotografia', fileInput.files[0]);*/

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
/*document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('.edit-form');
  const fileInput = form.querySelector('input[type="file"]');
  const preview = document.getElementById('previewImagen');
  const submitBtn = form.querySelector('.agregar');

  let modo = 'crear';
  let mascotaExistente = localStorage.getItem('mascotaEditar');

  if (mascotaExistente) {
    mascotaExistente = JSON.parse(mascotaExistente);
    modo = 'editar';

    // Rellenar campos
    form.querySelector('input[name="nombre"]').value = mascotaExistente.nombre;
    form.querySelector('select[name="especie"]').value = mascotaExistente.especie;
    form.querySelector('input[name="edad"]').value = mascotaExistente.edad;
    form.querySelector('select[name="sexo"]').value = mascotaExistente.sexo;
    form.querySelector('input[name="descripcion"]').value = mascotaExistente.descripcion;
    form.querySelector('select[name="tamanio"]').value = mascotaExistente.tamanio;

    // Imagen previa
    if (mascotaExistente.fotografia) {
      preview.src = `data:image/jpeg;base64,${mascotaExistente.fotografia}`;
      preview.style.display = 'block';
    }

    // Cambiar texto del botón
    submitBtn.textContent = 'Editar';
  }

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
      alert('Error: no puedes subir ese tipo de archivo');
    }
  });

  document.getElementById('formulario-mascota').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
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
    formData.append('idCentro', 1); 

    const file = fileInput.files[0];
    if (file) {
      formData.append('fotografia', file);
    }

    if (modo === 'editar') {
      formData.append('idMascota', mascotaExistente.idMascota);
    }

    const url = modo === 'editar'
      ? '/PatitasUnidas/backend/controllers/acciones/editarMascota.php'
      : '/PatitasUnidas/backend/controllers/acciones/crearMascota.php';

    fetch(url, {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert(modo === 'editar' ? 'Mascota editada correctamente' : 'Mascota creada correctamente');
          localStorage.removeItem('mascotaEditar');
          window.location.href = '/PatitasUnidas/frontend/public/adopcion.html';
        } else {
          alert('Error: ' + data.mensaje);
        }
      })
      .catch(err => {
        console.error('Error al guardar mascota:', err);
        alert('Error inesperado.');
      });
  });
});
*/