<?php
    require_once '../config/config.php';
    class Autenticacion{
        public bool $sesionIniciada;
        private string $contrasenia;
        private string $usuario;

        public function __construct($Usuario, $Contrasenia) {
            $this->usuario = $Usuario;
            $this->contrasenia = $Contrasenia;
        }

        public function validarCredenciales(){
            session_start();
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $usuario = $_POST['usuario'];
                $contrasenia = $_POST['contrasenia'];

                if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
                }

                $stmt = $conn->prepare("SELECT personal.usuario, personal.contrasenia FROM personal WHERE usuario = ? AND contrasenia = ?");
                $stmt->bind_param("ss", $usuario, $contrasenia);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows == 1) {
                    $usuario = $resultado->fetch_assoc();
                    $_SESSION['rol'] = $usuario['rol'];
                    $_SESSION['usuario'] = $usuario['usuario'];
                    exit;
                } else {
                    echo "Correo o contraseña incorrectos.";
                }
            }
        }
    }    
?>
