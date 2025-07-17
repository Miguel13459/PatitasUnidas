<?php
header('Content-Type: application/json');

require_once '../../models/mascota.php';
require_once '../empleado.php';
require_once '../../models/eventos.php';
require_once '../mascotaController.php';

// Validar campos
if (
    empty($_POST['nombre']) || empty($_POST['especie']) || empty($_POST['edad']) ||
    empty($_POST['sexo']) || empty($_POST['tamanio']) || empty($_POST['descripcion']) ||
    empty($_POST['idCentro']) || !isset($_FILES['fotografia'])
) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Faltan campos requeridos.'
    ]);
    exit;
}

//validar imagen
$imgPermitidas = array("image/png", "image/jpeg");
if (!in_array($_FILES['fotografia']['type'], $imgPermitidas)) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Solo se aceptan imágenes'
    ]);
    exit;
}

$imagenTmp = $_FILES['fotografia']['tmp_name'];
$imagenBinario = file_get_contents($imagenTmp);

/*$imagenTmp = $_FILES['fotografia']['tmp_name'];
$tamanioArchivo = $_FILES['fotografia']['size'];
$imagenSubida = fopen($imagenTmp, 'rb');
$binariosImagen = fread($imagenSubida, $tamanioArchivo);
fclose($imagenSubida);
$imagenBinario = file_get_contents($imagenTmp);*/


$visibilidadSitio = 1;

$mascota = new Mascota(
    null,
    $_POST['nombre'],
    $_POST['especie'],
    $_POST['edad'],
    $_POST['sexo'],
    $_POST['tamanio'],
    $visibilidadSitio,
    $_POST['descripcion'],
    $imagenBinario,
    (int)$_POST['idCentro']
);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Obtenemos el usuario y el id del empleado, se ocupan para registrar el evento
$usuario = $_SESSION['usuario'] ?? null;
$idEmpleado = Empleado::obtenerIdEmpleado($usuario);

// Se guarda en la base de datos
$empleado = new Empleado($idEmpleado, $usuario, null, $_POST['idCentro']);
$exito = $empleado->crearMascota($mascota);

//se registra en la tabla manipulacionInfo para mantener registro de quien y donde se hizo
$idMascota = MascotaController::obtenerUltimaMascota();
$evento = new Evento(null, "Creación de mascota", date("Y-m-d H:i:s"), $idMascota, (int)$_POST['idCentro'], $idEmpleado);
$empleado->registrarEvento($evento);

// Se envia la respuesta al frontend
if (!($exito === true && $empleado === true)) {
    echo json_encode([
        'success' => true,
        'mensaje' => 'Mascota creada correctamente.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Error al crear mascota.'
    ]);
}

?>