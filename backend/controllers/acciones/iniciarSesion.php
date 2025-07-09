<?php
    function inicioDeSesion(array $empleado){
        $inicioDeSesionEmpleado = new Empleado(
            null,
            $_POST['usuario'],
            $_POST['contrasenia'],
            $empleado['idCentro']
        );
        //$empleado['idEmpleado'] = $inicioDeSesionEmpleado->getIdEmpleado();
        $empleado['usuario'] = $inicioDeSesionEmpleado->getUsuario();
        $empleado['contrasenia'] = $inicioDeSesionEmpleado->getContrasenia();

        $empleado = $inicioDeSesionEmpleado->iniciarSesion($empleado);

        return $empleado;
    }
?>