<?php
    session_start();
    $empleado = [];
    $idSucursal;

    // Archivos necesarios
    /*require_once '../models/mascota.php';
    require_once '../autenticacionController.php';
    require_once 'mascotaController.php';
    require_once 'empleado.php';*/

    // INICIO DE SESIÓN
    if (isset($_REQUEST['iniciarSesion'])) {
        $idSucursal = rand(1,2);
        require_once "acciones/iniciarSesion.php";
        require_once 'empleado.php';
        $inicioDeSesion = new Empleado(
            null,
            $_POST['usuario'],
            $_POST['contrasenia'],
            $idSucursal
        );
        $empleado = inicioDeSesion($inicioDeSesion, $idSucursal);
        if (isset($_SESSION['usuario'])) {
            header("Location: /PatitasUnidas/frontend/src/pages/pruebaAdopcionAdmin.html");
        }
        
    }

    if(isset($_REQUEST['cerrarSesion'])){
        cerrarSesion($empleado);
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