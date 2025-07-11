document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('.edit-form');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData();

    const inputs = form.querySelectorAll('input, select');
    const fileInput = form.querySelector('input[type="file"]');

    formData.append('nombre', inputs[0].value);
    formData.append('especie', inputs[1].value);
    formData.append('edad', inputs[2].value);
    formData.append('sexo', inputs[3].value);
    formData.append('descripcion', inputs[4].value);
    formData.append('tamanio', inputs[5].value);
    formData.append('idCentro', 1); // O el ID que tengas
    formData.append('fotografia', fileInput.files[0]);

    fetch('/PatitasUnidas/backend/controllers/acciones/crearMascota.php', {
      method: 'POST',
      body: formData,
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert('Mascota creada correctamente');
          window.location.href = '/PatitasUnidas/frontend/public/adopcion.html';
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
