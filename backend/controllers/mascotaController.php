<?php
    class MascotaController{
        public function mostrarMascota() {
            #require_once "/PatitasUnidas/backend/config/config.php";
            $servername = "localhost";
            $username = "cuidadorAdmin";
            $password = "citlalilandia";
            $dbname = "PatitasUnidas";
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $stmt = $conn->prepare('SELECT * FROM mascota WHERE visibilidadSitio = 1 ORDER BY idMascota DESC');
            $stmt->execute();
            $respuesta = $stmt->get_result();

            $grupoDeMascotas = [];

            while ($campos = $respuesta->fetch_assoc()) {
                //$fotografia = base64_encode($campos['fotografia']);
                $mascota = new Mascota(
                    $campos['idMascota'],
                    $campos['nombre'],
                    $campos['especie'],
                    $campos['edad'],
                    $campos['sexo'],
                    $campos['tamanio'],
                    $campos['visibilidadSitio'],
                    $campos['descripcion'],
                    $campos['fotografia'],
                    $campos['idCentro']
                );

                $grupoDeMascotas[] = $mascota;
            }

            $stmt->close();
            $conn->close();

            return $grupoDeMascotas;
        }
    }
?>