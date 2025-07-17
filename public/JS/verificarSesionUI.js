document.addEventListener("DOMContentLoaded", () => {
  fetch("/PatitasUnidas/app/controllers/acciones/verificarSesion.php")
    .then(res => res.json())
    .then(data => {
      const adminMenu = document.getElementById("adminMenu");
      const loginButton = document.getElementById("loginButton");

      if (data.autenticado) {
        // Mostrar menú administrador
        if (adminMenu) adminMenu.style.display = "block";
        if (loginButton) loginButton.style.display = "none";
      } else {
        // Mostrar botón de inicio de sesión
        if (adminMenu) adminMenu.style.display = "none";
        if (loginButton) loginButton.style.display = "block";
      }
    })
    .catch(err => {
      console.error("Error al verificar sesión:", err);
    });
});
