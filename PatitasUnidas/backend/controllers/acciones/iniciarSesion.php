<?php
    //requerimos crear una nueva sesión
    if (isset($_REQUEST['iniciarSesion'])){
        require_once "../empleado.php";
        $idSucursal = rand(1,2);

        $inicioDeSesion = new Empleado(
            null,
            $_POST['usuario'],
            $_POST['contrasenia'],
            $idSucursal
        );

        $usuario = $inicioDeSesion->getUsuario();
        $contrasenia = $inicioDeSesion->getContrasenia();

        $inicioDeSesion->iniciarSesion($usuario, $contrasenia);
    }
?>