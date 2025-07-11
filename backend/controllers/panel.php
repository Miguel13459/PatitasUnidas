<?php
    session_start();
    /*$empleado = array(
        'idEmpleado' => null,
	    'usuario' => '',
	    'contrasenia' => '',
        'idCentro' => null,
        'estadoInicioSesion' => false
        );
    $idCentro;

    // INICIO DE SESIÓN
    if (isset($_REQUEST['iniciarSesion'])) {
        $idCentro = rand(1,2);
        require_once "acciones/iniciarSesion.php";
        require_once 'empleado.php';

        $empleado['idCentro'] = $idCentro;
        
        $empleado = inicioDeSesion($empleado);
        if ($empleado['estadoInicioSesion']) {
            sleep(1);
            header("Location: /PatitasUnidas/frontend/public/adopciones.html");
        }
        else{
            echo "<script>alert('Usuario o contraseña incorrectos');</script>";
            sleep(1);
            header("Location: /PatitasUnidas/frontend/public/inicioSesion.html");
        }
    }*/

    if(isset($_REQUEST['cerrarSesion'])){
        cerrarSesion($empleado);
    }

    // CREAR MASCOTA
    if (isset($_REQUEST['crearMascota'])) {
        if (!isset($_SESSION['usuario'])) {
            die("Acceso denegado. Por favor inicia sesión.");
            exit;
        }
        $mascota = [];
        crearMascotaDesdeFormulario($mascota);
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