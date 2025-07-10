<?php
    function inicioDeSesion(Empleado $inicioDeSesion, int $idSucursal){
        $empleado = [$inicioDeSesion->getIdEmpleado(), $inicioDeSesion->getUsuario(), $inicioDeSesion->getContrasenia(), $idSucursal];
        $empleado = $inicioDeSesion->iniciarSesion($empleado);

        return $empleado;
    }
?>