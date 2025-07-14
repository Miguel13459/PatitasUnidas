document.addEventListener('DOMContentLoaded', function () {
  const id = new URLSearchParams(window.location.search).get('id');
  const form = document.getElementById('formulario-mascota');
  const fileInput = form.querySelector('input[type="file"]');
  const preview = document.getElementById('previewImagen');

  if (!id) {
    alert("No se proporcionó una mascota para editar");
    window.location.href = "adopcion.html";
    return;
  }

  // Cargar datos de la mascota
  fetch(`/PatitasUnidas/backend/controllers/acciones/obtenerMascota.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        alert("No se pudo cargar la mascota.");
        return;
      }

      const mascota = data.mascota;

      // Rellenar campos
      form.nombre.value = mascota.nombre;
      form.especie.value = mascota.especie;
      form.edad.value = mascota.edad;
      form.sexo.value = mascota.sexo;
      form.descripcion.value = mascota.descripcion;
      form.tamanio.value = mascota.tamanio;

      if (mascota.fotografia) {
        preview.src = `data:image/jpeg;base64,${mascota.fotografia}`;
        preview.style.display = 'block';
      }else{
        preview.src = "/PatitasUnidas/frontend/src/assets/CabezaGatito.png";
        preview.style.display = 'block';
      }

      // Manejar envío
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        formData.append('idMascota', id);
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
            alert('Mascota editada correctamente');
            window.location.href = 'adopcion.html';
          } else {
            alert('Error: ' + data.mensaje);
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
