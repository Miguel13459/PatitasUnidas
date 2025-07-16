document.addEventListener('DOMContentLoaded', function () {
  const btnCerrarSesion = document.querySelector('.cerrar-sesion');

  if (btnCerrarSesion) {
    btnCerrarSesion.addEventListener('click', function () {
      fetch('/PatitasUnidas/backend/controllers/acciones/cerrarSesion.php')
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            alert(data.mensaje || "Sesión cerrada.");
            window.location.href = "/PatitasUnidas/frontend/public/index.html";
          } else {
            alert("No se pudo cerrar sesión.");
          }
        })
        .catch(err => {
          console.error("Error al cerrar sesión:", err);
          alert("Error de red.");
        });
    });
  }
});
