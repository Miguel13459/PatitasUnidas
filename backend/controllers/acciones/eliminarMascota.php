<?php
    header('Content-Type: application/json');
    require_once '../empleado.php';

    if (!isset($_GET['id'])) {
        echo json_encode(['success' => false, 'mensaje' => 'ID no proporcionado']);
        exit;
    }

    $idMascota = $_GET['id'];
    $empleado = new Empleado(null, "", "", 1);
    $res = $empleado->eliminarMascota($idMascota);

    if($res){
        echo json_encode([
            'message' => "Se ha eliminado la mascota correctamente."
        ]);
    }else{
        echo json_encode([
            'message' => "Fallo al eliminar animalito."
        ]);
    }
?>