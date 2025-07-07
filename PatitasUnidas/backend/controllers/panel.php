<?php
    session_start();

    // Archivos necesarios
    require_once '../models/mascota.php';
    require_once '../autenticacionController.php';
    require_once 'mascotaController.php';
    require_once 'empleado.php';

    // INICIO DE SESIÓN
    if (isset($_REQUEST['iniciarSesion'])) {
        inicioDeSesion();
        exit;
    }

    // CREAR MASCOTA
    if (isset($_REQUEST['crearMascota'])) {
        if (!isset($_SESSION['usuario'])) {
            die("Acceso denegado. Por favor inicia sesión.");
            exit;
        }
        crearMascotaDesdeFormulario();
    }

    // ELIMINAR MASCOTA
    if (isset($_REQUEST['editarMascota'])) {
        editarMascota(); 
        exit;
    }

    // ELIMINAR MASCOTA
    if (isset($_REQUEST['eliminarMascota'])) {
        eliminarMascota(); 
        exit;
    }

?>