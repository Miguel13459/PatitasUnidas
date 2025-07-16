<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

require_once '../../models/mascota.php';
require_once '../empleado.php';

if (
    empty($_POST['idMascota']) ||
    empty($_POST['nombre']) ||
    empty($_POST['especie']) ||
    empty($_POST['edad']) ||
    empty($_POST['sexo']) ||
    empty($_POST['tamanio']) ||
    empty($_POST['descripcion']) ||
    empty($_POST['idCentro']) ||
    !isset($_FILES['fotografia'])
) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Faltan campos requeridos.'
    ]);
    exit;
}

// Obtener imagen nueva si se subió
$imagenBinario = null;
if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] === UPLOAD_ERR_OK) {
    $imagenTmp = $_FILES['fotografia']['tmp_name'];
    $imagenBinario = file_get_contents($imagenTmp);
}

$visibilidadSitio = 1;

$mascota = new Mascota(
    $_POST['idMascota'],
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

$empleado = new Empleado(null, '', '', $_POST['idCentro']);
$exito = $empleado->editarMascota($mascota);

echo json_encode([
    'success' => $exito,
    'mensaje' => $exito ? 'Mascota editada correctamente.' : 'Error al editar mascota.'
]);
