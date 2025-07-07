<?php
    function crearMascotaDesdeFormulario(){
        require_once "backend/models/mascota.php";
        $mascota = new Mascota(
            null,
            $_POST['nombre'],
            $_POST['especie'],
            $_POST['edad'],
            $_POST['sexo'],
            $_POST['tamanio'],
            $visibilidadSitio,
            $_POST['descripcion'],
            $binariosImagen,
            (int)$_POST['idCentro']
        );

        //$ingresarMascota = new Empleado();
        
    }
?>