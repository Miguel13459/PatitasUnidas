<?php
header('Content-Type: application/json');
require_once '../../controllers/mascotaController.php';

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'mensaje' => 'ID no proporcionado']);
    exit;
}

$idMascota = $_GET['id'];
$mascota = MascotaController::obtenerPorId($idMascota);

if (!$mascota) {
    echo json_encode(['success' => false, 'mensaje' => 'Mascota no encontrada']);
    exit;
}

// NO se debe convertir la imagen a base 64 eso ya sucede en el el frontend o debe suceder en el frontend
$fotografia = $mascota->getFotografia();
//$base64Foto = $fotografia ? base64_encode($fotografia) : null;

echo json_encode([
    'success' => true,
    'mascota' => [
        'idMascota' => $mascota->getId(),
        'nombre' => $mascota->getNombre(),
        'especie' => $mascota->getEspecie(),
        'edad' => $mascota->getEdad(),
        'sexo' => $mascota->getSexo(),
        'tamanio' => $mascota->getTamanio(),
        'descripcion' => $mascota->getDescripcion(),
        'fotografia' => $fotografia
    ]
]);
?>