<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /PatitasUnidas/public/index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Crear Mascota</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/EditarFormulario.css" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="CSS/estiloAdopcion.css">
</head>
<body>
  <!-- Encabezado -->
  <div class="contenedor">
    <header class="encabezado d-flex justify-content-between align-items-center">
      <a href="/PatitasUnidas/index.html">
        <img src="/PatitasUnidas/src/assets/LogoPatiasUnidas.png" alt="Patitas Unidas" class="logo">
      </a>
      
      <!-- Menú hamburguesa Bootstrap -->
      <div class="dropdown admin-menu">
        <button class="btn admin-visible-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          Administrador
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><button class="dropdown-item cerrar-sesion" type="button">Cerrar Sesión</button></li>
        </ul>
      </div>
    </header>
  </div>

  <main>
    <div class="form-container">
      <div id="titulo"><h1>Creación de mascota</h1></div>
      <form id="formulario-mascota" enctype="multipart/form-data" class="edit-form">
        <!-- Vista previa de la imagen -->
        <div id="contenedorImgPrev">
          <img id="previewImagen" src="" alt="Vista previa de la imagen"/>
        </div>
        
        <label class="upload-label">
          <input type="file" name="fotografia" id="fotografia" accept="image/jpeg, image/png" hidden />
          <span>⬆ Subir Imagen</span>
        </label>

        <div class="form-row">
          <input type="text" name="nombre" id="nombre" placeholder="Nombre">
          <select name="especie" id="especie">
            <option disabled selected>Especie</option>
            <option>Perro</option>
            <option>Gato</option>
          </select>
        </div>

        <div class="form-row">
          <input type="text"  name="edad" id="edad" placeholder="Edad">
          <select name="sexo" id="sexo">
            <option disabled selected>Sexo</option>
            <option>Macho</option>
            <option>Hembra</option>
          </select>
        </div>

        <div class="form-row">
          <input type="text" name="descripcion" placeholder="Descripción">
          <select name="tamanio" id="tamanio">
            <option disabled selected>Tamaño</option>
            <option>Pequeño</option>
            <option>Mediano</option>
            <option>Grande</option>
          </select>
        </div>

        <div class="form-buttons">
          <button type="button" id="regresar" class="btn regresar">Regresar</button>
          <button type="submit" class="btn agregar">Registrar mascota</button>
        </div>
      </form>
    </div>
  </main>

  <!-- Modal de mensaje (éxito o error) -->
<div id="modalMensaje" class="modal">
  <div class="modal-content">
    <p id="mensajeTexto"></p>
    <button id="btnCerrarMensaje">Aceptar</button>
  </div>
</div>


  <div class="contenedor">
    <div id="footer-placeholder"></div>
<script src="/PatitasUnidas/src/components/footer.js"></script></div>

</body>
<script src="JS/crearMascota.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="JS/cerrarSesion.js"></script>
</html>
