<?php
header('Content-Type: application/json');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../models/mascota.php';
require_once '../empleado.php';

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

// Procesar imagen
if ($_FILES['fotografia']['error'] === UPLOAD_ERR_OK) {
    $imagenTmp = $_FILES['fotografia']['tmp_name'];
    $imgTipo = $_FILES['fotografia']['type'];
    $imgPermitidas = array("image/png", "image/jpeg", "image/webp");
    if (!in_array($imgTipo, $imgPermitidas)) {
        errorTipoImg();
    }
    $tamanioArchivo = $_FILES['fotografia']['size'];
    $imagenSubida = fopen($imagenTmp, 'rb');
    $binariosImagen = fread($imagenSubida, $tamanioArchivo);
    fclose($imagenSubida);
} else {
    errorImagenSubida();
}

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
    $binariosImagen,
    (int)$_POST['idCentro']
);

// Guardar en DB
$empleado = new Empleado(null, '', '', $_POST['idCentro']);
$exito = $empleado->crearMascota($mascota);

// Respuesta JSON
if ($exito === true) {
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

function errorTipoImg(){
    echo json_encode([
            'success' => false,
            'mensaje' => 'Error: no puedes subir ese tipo de archivo.'
        ]);
        exit;
}

function errorImagenSubida(){
    echo json_encode([
        'success' => false,
        'mensaje' => 'Error al subir la imagen.'
    ]);
    exit;
}

?>