<?php
    /*require_once '../config/config.php';
    require_once 'autenticacionController.php';
    require_once '../models/centroAdoptivo.php';
    require_once '../models/eventos.php';
    require_once '../models/mascota.php';*/

    class Empleado{
        public int $idEmpleado;
        private string $usuario;
        private string $contrasenia;
        private int $tipoSucursal;
    
        public function iniciarSesion($usuario, $contrasenia){
            $inicioDeSesion = new Autenticacion($usuario, $contrasenia);
            if($inicioDeSesion === true){
                header("Location: ../frontend/src/pages/adopciones.php");
            }
            else {
                echo "Correo o contraseña incorrectos.";
            }
        }

        public function cerrarSesion(){
            session_start();
            session_destroy();
            header("Location: ../frontend/src/public/index.html");
        }

        public function crearMascota(Mascota $mascota){
            session_start();

            require_once "backend/models/mascota.php";
            require_once "..config/config.php";

            if (isset($_REQUEST['guardar'])) {
                $visibilidadSitio = 1;

                // Validar archivo subido
                if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] === UPLOAD_ERR_OK) {
                    $tamanioArchivo = $_FILES['fotografia']['size'];
                    $imagenSubida = fopen($_FILES['fotografia']['tmp_name'], 'r');
                    $binariosImagen = fread($imagenSubida, $tamanioArchivo);
                    fclose($imagenSubida);
                } else {
                    die("Error al subir la imagen.");
                }

                // SE TIENE QUE BORRAR ESTA PARTE, SE USÓ PARA PROBAR SI SE PUEDE INSERTAR EL OBJETO
                //DE LA MASCOTA
                $mascota = new Mascota(
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

                $nombre = $mascota->getNombre();
                $especie = $mascota->getEspecie();
                $edad = $mascota->getEdad();
                $sexo = $mascota->getSexo();
                $tamanio = $mascota->getTamanio();
                $descripcion = $mascota->getDescripcion();
                $fotografia = $mascota->getFotografia();
                $idCentro = $mascota->getIdCentro();

                // Conexión
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Query segura
                $stmt = $conn->prepare("INSERT INTO mascota (nombre, especie, edad, sexo, tamanio, visibilidadSitio, descripcion, fotografia, idCentro)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->bind_param(
                    "sssssisbi",
                    $nombre,
                    $especie,
                    $edad,
                    $sexo,
                    $tamanio,
                    $visibilidadSitio,
                    $descripcion,
                    $fotografia,
                    $idCentro
                );

                // Ejecutar
                if ($stmt->execute()) {
                    header("Location: test.php"); //frontend/public/index.html
                    exit;
                } else {
                    echo "Error al insertar: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "Datos no insertados";
            }
        }

        public function editarMascota(){
            session_start();

            require_once "..config/config.php";
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
