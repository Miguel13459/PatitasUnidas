<?php
    function inicioDeSesion(){
        require_once "../empleado.php";
        $idSucursal = rand(1,2);

        $inicioDeSesion = new Empleado(
            null,
            $_POST['usuario'],
            $_POST['contrasenia'],
            $idSucursal
        );

        $empleado = [$inicioDeSesion->getIdEmpleado(), $inicioDeSesion->getUsuario(), $inicioDeSesion->getContrasenia(), $idSucursal];
        /*$idEmpleado = $inicioDeSesion->getIdEmpleado();
        $usuario = $inicioDeSesion->getUsuario();
        $contrasenia = $inicioDeSesion->getContrasenia();*/

        $empleado = $inicioDeSesion->iniciarSesion($empleado);

        return $empleado;
    }
?>