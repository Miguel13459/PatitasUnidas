const form = document.querySelector('.login-form');
const modal = document.getElementById('errorModal');
const closeModalBtn = document.getElementById('closeModalBtn');

document.addEventListener('DOMContentLoaded', function () {
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const username = form.querySelector('input[type="text"]').value.trim();
    const password = form.querySelector('input[type="password"]').value.trim();

    fetch('/PatitasUnidas/backend/controllers/iniciarSesion.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ usuario: username, contrasenia: password })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        console.log("Inicio de sesión exitoso ✅");
        window.location.href = "/PatitasUnidas/frontend/public/adopcion.html";
      } else {
        mostrarModal(data.mensaje || "Inicio de sesión fallido");
      }
    })
    .catch(err => {
      console.error("Error en la petición:", err);
      mostrarModal("Ocurrió un error inesperado.");
    });
  });

  // Botón para cerrar el modal
  closeModalBtn.addEventListener('click', function () {
    modal.style.display = 'none';
  });

  // Función para mostrar el modal de error con mensaje personalizado
  function mostrarModal(mensaje) {
    modal.querySelector("p").textContent = mensaje;
    modal.style.display = 'flex';
  }
});


/*document.addEventListener('DOMContentLoaded', function () {
  console.log("✅ JS cargado correctamente");

  const form = document.querySelector('.login-form');
  const modal = document.getElementById('errorModal');
  const closeModalBtn = document.getElementById('closeModalBtn');

  // Usuario válido
  const validUser = {
    username: "admin",
    password: "1234"
  };

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const username = form.querySelector('input[type="text"]').value.trim();
    const password = form.querySelector('input[type="password"]').value.trim();

    // Validar campos vacíos
    if (!username || !password) {
      mostrarModal("Por favor, completa todos los campos.");
      return;
    }

    // Validar credenciales
    if (username !== validUser.username || password !== validUser.password) {
      mostrarModal("Usuario o contraseña incorrecto.");
      return;
    }

    // Inicio de sesión exitoso
    console.log("Inicio de sesión exitoso ✅");
    window.location.href = "adopcion.html";
  });

  // Botón para cerrar el modal
  closeModalBtn.addEventListener('click', function () {
    modal.style.display = 'none';
  });

  // Función para mostrar el modal de error con mensaje personalizado
  function mostrarModal(mensaje) {
    modal.querySelector("p").textContent = mensaje;
    modal.style.display = 'flex';
  }
});
*/