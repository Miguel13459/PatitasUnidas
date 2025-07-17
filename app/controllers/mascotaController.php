<?php

    class MascotaController{
        
        
        public function mostrarMascota() {
            #require_once "/PatitasUnidas/app/config/config.php";
            //require_once(__DIR__ . '/../config/config.php');
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
                $fotografia = base64_encode($campos['fotografia']);
                $mascota = new Mascota(
                    $campos['idMascota'],
                    $campos['nombre'],
                    $campos['especie'],
                    $campos['edad'],
                    $campos['sexo'],
                    $campos['tamanio'],
                    $campos['visibilidadSitio'],
                    $campos['descripcion'],
                    $fotografia,
                    //$campos['fotografia'],
                    $campos['idCentro']
                );

                $grupoDeMascotas[] = $mascota;
            }

            $stmt->close();
            $conn->close();

            return $grupoDeMascotas;
        }

        public static function obtenerPorId(int $idMascota){
            $servername = "localhost";
            $username = "cuidadorAdmin";
            $password = "citlalilandia";
            $dbname = "PatitasUnidas";
            $conn = new mysqli($servername, $username, $password, $dbname);

            $stmt = $conn->prepare('SELECT * FROM mascota WHERE idMascota = ?');
            $stmt->bind_param("i", $idMascota);
            $stmt->execute();
            $respuesta = $stmt->get_result();

            $campo = $respuesta->fetch_assoc();
            $fotografia = base64_encode($campo['fotografia']);
            require_once(__DIR__ . '/../models/mascota.php');
            $mascota = new Mascota(
                $campo['idMascota'],
                $campo['nombre'],
                $campo['especie'],
                $campo['edad'],
                $campo['sexo'],
                $campo['tamanio'],
                $campo['visibilidadSitio'],
                $campo['descripcion'],
                $fotografia,
                $campo['idCentro']
            );

            return $mascota;
        }

        public static function obtenerUltimaMascota(){
            $servername = "localhost";
            $username = "cuidadorAdmin";
            $password = "citlalilandia";
            $dbname = "PatitasUnidas";
            $conn = new mysqli($servername, $username, $password, $dbname);

            $stmt = $conn->prepare('SELECT idMascota FROM mascota ORDER BY idMascota DESC LIMIT 1');
            $stmt->execute();
            $resultado = $stmt->get_result();
            $fila = $resultado->fetch_assoc();
            return $fila ? (int) $fila['idMascota'] : null;
        }
    }
?>