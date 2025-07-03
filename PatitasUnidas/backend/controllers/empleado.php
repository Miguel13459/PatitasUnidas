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
            if($inicioDeSesion){
                header("Location: ../../frontend/src/pages/adopciones.php");
            }
        }

        public function cerrarSesion(){
            session_start();
            session_destroy();
            header("Location: ../../frontend/src/public/index.html");
        }

        public function crearMascota(){
            session_start();
            $visibilidadSitio = 1;

            

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $stmt = $conn->prepare("INSERT INTO mascota (nombre, especie, edad, sexo, tamanio, visibilidadSitio, descripcion, fotografia) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("siss", $_POST['nombre'], $_POST['edad'], $_POST['descripcion'], $_POST['imagen_url']);
                $stmt->execute();
                header("Location: adopciones.php");
                exit;
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
