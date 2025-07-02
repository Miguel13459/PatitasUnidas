<?php
    $servername = "localhost";
    $username = "cuidadorAdmin";
    $password = "citlalilandia";
    $dbname = "PatitasUnidas";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
    }
    echo "Conexión exitosa";

    // Aquí puedes realizar tus consultas a la base de datos

    // Cerrar conexión (opcional, pero recomendado)
    //$conn->close();
  
?>
