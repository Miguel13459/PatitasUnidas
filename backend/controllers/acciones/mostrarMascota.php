<?php
    require_once "../../models/mascota.php";
    require_once "../mascotaController.php";

    function consultarMascota() {
        header('Content-Type: application/json');

        $mascotas = new MascotaController();
        $grupoDeMascotas = $mascotas->mostrarMascota();

        echo json_encode($grupoDeMascotas);
    }

    consultarMascota();
?>