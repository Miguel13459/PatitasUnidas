<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
    'autenticado' => isset($_SESSION['usuario'])
]);
?>