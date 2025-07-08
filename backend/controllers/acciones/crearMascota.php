<?php
    function crearMascotaDesdeFormulario(array $mascota){
        require_once "../../models/mascota.php";
        $_mascota = new Mascota(
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
        
        $mascota[0] = $_mascota->getId();
    }
?>