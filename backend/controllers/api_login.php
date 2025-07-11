<?php
// Configuración y clases
require_once '../config/config.php';
require_once 'empleado.php';

header('Content-Type: application/json');

// Leer cuerpo JSON crudo
$input = json_decode(file_get_contents('php://input'), true);

$usuario = $input['usuario'] ?? '';
$contrasenia = $input['contrasenia'] ?? '';
$idSucursal = rand(1, 2);

// Validar
if (!$usuario || !$contrasenia) {
  echo json_encode([
    "success" => false,
    "mensaje" => "Usuario y contraseña requeridos."
  ]);
  exit;
}

$empleado = new Empleado(null, $usuario, $contrasenia, $idSucursal);
$resultado = $empleado->iniciarSesion([$empleado->getIdEmpleado(), $usuario, $contrasenia, $idSucursal]);

if (isset($_SESSION['usuario'])) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode([
    "success" => false,
    "mensaje" => "Usuario o contraseña incorrectos."
  ]);
}
