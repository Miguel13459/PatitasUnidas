<?php
    class Autenticacion{
        public bool $sesionIniciada;
        private string $contrasenia;
        private string $usuario;

        public function __construct(string $usuario, string $contrasenia) {
            $this->usuario = $usuario;
            $this->contrasenia = $contrasenia;
        }

        public function validarCredenciales(): bool{
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $servername = "localhost";
            $username = "cuidadorAdmin";
            $password = "citlalilandia";
            $dbname = "PatitasUnidas";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error); //CAMBIAR RESPUESTA DE CONECCION FALLIDA, SALDRÁ UN MENSAJE O LO REDIRIGE?
            }
            $stmt = $conn->prepare("SELECT personal.usuario, personal.contrasenia FROM personal WHERE usuario = ? AND contrasenia = ?");
            $stmt->bind_param("ss", $this->usuario, $this->contrasenia);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows == 1) {
                $fila = $resultado->fetch_assoc();

                // Verifica el hash de la contraseña
                if (
                    //password_verify($this->contrasenia, $fila['contrasenia'])
                    $this->usuario === $fila['usuario'] & $this->contrasenia === $fila['contrasenia'] //sin hash temporal, ELIMINAR ESTA LINEA
                ) {
                    $_SESSION['usuario'] = $fila['usuario'];
                    $this->sesionIniciada = true;
                    return $this->sesionIniciada;
                }
            }

            // Si llega aquí es porque falló
            $this->sesionIniciada = false;
            return $this->sesionIniciada;

        }
    }    
?>