<?php
// DEBUG - habilita errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../../config/config.php');
require_once '../empleado.php';
require_once '../autenticacionController.php';

header('Content-Type: application/json');
session_start();

//Recibir los datos en JSON desde JS
$input = json_decode(file_get_contents('php://input'), true);
$usuario = $input['usuario'] ?? '';
$contrasenia = $input['contrasenia'] ?? '';
$idCentro = rand(1, 2);

//Validación simple
if (empty($usuario) || empty($contrasenia)) {
  echo json_encode([
    "success" => false,
    "mensaje" => "Usuario y contraseña requeridos."
  ]);
  exit;
}

//Intenta autenticar
$empleado = new Empleado(null, $usuario, $contrasenia, $idCentro);
$datosEmpleado = [
  'idEmpleado' => null,
  'usuario' => $usuario,
  'contrasenia' => $contrasenia,
  'idCentro' => $idCentro,
  'estadoInicioSesion' => false
];

//Ejecuta inicio de sesión
$datosEmpleado = $empleado->iniciarSesion($datosEmpleado);

//Retorna JSON como respuesta
if ($datosEmpleado['estadoInicioSesion']) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode([
    "success" => false,
    "mensaje" => "Usuario o contraseña incorrectos."
  ]);
}
?>
