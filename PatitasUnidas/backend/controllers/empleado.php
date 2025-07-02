<?php
    require_once '../config/config.php';

    class Empleado{
        public int $idEmpleado;
        private string $usuario;
        private string $contrasenia;
        private int $tipoSucursal;
    
        public function iniciarSesion(){
            session_start();
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $usuario = $_POST['usuario'];
                $contrasenia = $_POST['contrasenia'];

                $conn = new mysqli($servidor, $usuario, $clave, $basededato);
                if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
                }

                $stmt = $conn->prepare("SELECT * FROM personal WHERE usuario = ? AND contrasenia = ?");
                $stmt->bind_param("ss", $usuario, $contrasenia);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows == 1) {
                    $usuario = $resultado->fetch_assoc();
                    $_SESSION['rol'] = $usuario['rol'];
                    $_SESSION['usuario'] = $usuario['nombre'];
                    header("Location: ../../frontend/src/pages/adopciones.php");
                    exit;
                } else {
                    echo "Correo o contraseña incorrectos.";
                }
            }
        }

        public function cerrarSesion(){
            
        }

        public function crearMascota(){
            
        }

        public function editarMascota(){
            
        }

        public function eliminarMascota(){
            
        }

        public function registrarEvento(){
            
        }
    }
?>
