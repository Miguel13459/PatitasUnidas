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

        public function crearMascota(Mascota $mascota){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $visibilidadSitio = 1
                //Se crea la instancia de la mascota
                $mascota = new Mascota(
                    $_POST['nombre'],
                    $_POST['especie'],
                    $_POST['edad'],
                    $_POST['sexo'],
                    $_POST['tamanio'],
                    $visibilidadSitio,
                    $_POST['descripcion'],
                    $_POST['fotografia'],
                    $_POST['idCentro']
                );

                //insertar en la base de datos
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                $stmt = $conn->prepare("INSERT INTO mascota (nombre, especie, edad, sexo, tamanio, visibilidadSitio, descripcion, fotografia, idCentro) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param(
                "sssssisbi",
                $mascota->getNombre(),
                $mascota->getEspecie(),
                $mascota->getEdad(),
                $mascota->getSexo(),
                $mascota->getTamanio(),
                $visibilidad,
                $mascota->getDescripcion(),
                $mascota->getFotografia(),
                $mascota->getIdCentro()
                );
                
                if ($stmt->execute()) {
                    header("Location: adopciones.php");
                    exit;
                } else {
                    echo "Error al insertar la mascota: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            }
        }

        public function editarMascota(){
            session_start();

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $stmt = $conn->prepare("UPDATE mascota SET nombre = ?, especie= ?, edad= ?, sexo= ?, tamanio= ?, visibilidadSitio= ?, descripcion= ?, fotografia= ?, idCentro= ? WHERE id=?");
                $stmt->bind_param("sissi", $_POST['nombre'], $_POST['edad'], $_POST['descripcion'], $_POST['imagen_url'], $_POST['id']);
                $stmt->execute();
                header("Location: adopciones.php");
                exit;
            }

            $id = $_GET['id'];
            $animal = $conn->query("SELECT * FROM animales WHERE id=$id")->fetch_assoc();

        }

        public function eliminarMascota(){
            
        }

        public function registrarEvento(){
            
        }
    }
?>
