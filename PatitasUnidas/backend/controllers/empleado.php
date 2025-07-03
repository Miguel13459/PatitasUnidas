<?php
    require_once '../config/config.php';
    require_once 'autenticacionController.php';
    require_once '../models/centroAdoptivo.php';
    require_once '../models/eventos.php';
    require_once '../models/mascota.php';

    class Empleado{
        public int $idEmpleado;
        private string $usuario;
        private string $contrasenia;
        private int $tipoSucursal;
    
        public function iniciarSesion(){
            $inicioDeSesion = new Autenticacion($usuario, $contrasenia);
            if($inicioDeSesion === true){
                header("Location: ../../frontend/src/pages/adopciones.php");
            }
            else {
                echo "Correo o contraseña incorrectos.";
            }
        }

        public function cerrarSesion(){
            session_start();
            session_destroy();
            header("Location: ../../frontend/src/public/index.html");
        }

        public function crearMascota($Nombre, $Especie, $Edad, $Sexo, $Tamanio, $Descripcion, $Fotografia, $IdCentro){
            session_start();
            $visibilidadSitio = 1;

            $mascota = new Mascota($Nombre, $Especie, $Edad, $Sexo, $Tamanio, $Descripcion, $Fotografia, $IdCentro);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $stmt = $conn->prepare("INSERT INTO mascota (nombre, especie, edad, sexo, tamanio, visibilidadSitio, descripcion, fotografia, idCentro) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param(
                "sssssisbi",
                $Nombre,
                $Especie,
                $Edad,
                $Sexo,
                $Tamanio,
                $visibilidadSitio,
                $Descripcion,
                $Fotografia,
                $IdCentro
                );
                
                if ($stmt->execute()) {
                    header("Location: adopciones.php");
                    exit;
                } else {
                    echo "Error al insertar la mascota: " . $stmt->error;
                }
            }
        }

        public function editarMascota(){
            
        }

        public function eliminarMascota(){
            
        }

        public function registrarEvento(){
            
        }
    }
?>
