<?php
    header('Content-Type: application/json');
    require_once '../../models/mascota.php';
    require_once '../empleado.php';
    require_once '../../models/eventos.php';
    require_once '../mascotaController.php';

    if (!isset($_GET['id'])) {
        echo json_encode(['success' => false, 'mensaje' => 'ID no proporcionado']);
        exit;
    }

    $idMascota = $_GET['id'];
    $idCentro = 1;

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $usuario = $_SESSION['usuario'] ?? null;
    $idEmpleado = Empleado::obtenerIdEmpleado($usuario);

    $empleado = new Empleado($idEmpleado, $usuario, null, $idCentro);
    $exito = $empleado->eliminarMascota($idMascota);

    $idMascota = (int)$idMascota;
    $evento = new Evento(null, "Eliminacion de mascota en el sitio", date("Y-m-d H:i:s"), $idMascota, $idCentro, $idEmpleado);
    $empleado->registrarEvento($evento);

    // Respuesta JSON
    if ($exito === true) {
        echo json_encode([
            'message' => "Se ha eliminado la mascota correctamente."
        ]);
    } else {
        echo json_encode([
            'message' => "Fallo al eliminar animalito."
        ]);
    }
?>