<?php
    function cerrarSesion(array $empleado){
        $cerrarSesion = new Empleado($empleado[0],$empleado[1],$empleado[2],$empleado[3]);
        $cerrarSesion->cerrarSesion();
    }
?>