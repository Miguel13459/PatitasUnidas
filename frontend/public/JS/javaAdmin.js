document.addEventListener('DOMContentLoaded', function () {
  console.log("✅ JS cargado correctamente");

  const form = document.querySelector('.login-form');
  const modal = document.getElementById('errorModal');
  const closeModalBtn = document.getElementById('closeModalBtn');

  // Usuario válido (puedes agregar más si quieres)
  const validUser = {
    username: "admin",
    password: "1234"
  };

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    const username = form.querySelector('input[type="text"]').value.trim();
    const password = form.querySelector('input[type="password"]').value.trim();

    // Validar si están vacíos
    if (!username || !password) {
      mostrarModal("Por favor, completa todos los campos.");
      return;
    }

    // Validar si coinciden con los datos válidos
    if (username !== validUser.username || password !== validUser.password) {
      mostrarModal("Usuario o contraseña incorrecto.");
      return;
    }

    // Si todo es correcto, puedes redirigir o mostrar mensaje
    console.log("Inicio de sesión exitoso ✅");
    // window.location.href = "/PatitasUnidas/frontend/public/adminDashboard.html"; // opcional
  });

  closeModalBtn.addEventListener('click', function() {
    modal.style.display = 'none';
  });

  // Función para mostrar el modal con mensaje personalizado
  function mostrarModal(mensaje) {
    modal.querySelector("p").textContent = mensaje;
    modal.style.display = 'flex';
  }
});