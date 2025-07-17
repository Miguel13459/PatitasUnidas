<?php
require_once '../empleado.php';
header('Content-Type: application/json');

session_start();
session_destroy();

echo json_encode([
    "success" => true,
    "mensaje" => "Sesión cerrada exitosamente."
]);
