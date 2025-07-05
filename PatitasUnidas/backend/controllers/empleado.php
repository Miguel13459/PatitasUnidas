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
            if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_REQUEST['guardar'])) {
                //visibilidad de mascota en el sitio
                $visibilidadSitio = 1;

                //variables para la fotografia
                $tipoArchivo = $_FILES['fotografia']['type']; //se usará para validar tipo de imagen
                $tamanioArchivo = $_FILES['fotografia']['size'];
                $imagenSubida = fopen($_FILES['fotografia']['tpm_name'], 'r');
                $binariosImagen = fread($imagenSubida, $tamanioArchivo);

                //Se crea la instancia de la mascota
                
                $mascota = new Mascota(
                    "",
                    $_POST['nombre'],
                    $_POST['especie'],
                    $_POST['edad'],
                    $_POST['sexo'],
                    $_POST['tamanio'],
                    $visibilidadSitio,
                    $_POST['descripcion'],
                    $binariosImagen,
                    //$_POST['fotografia'],
                    $_POST['idCentro']
                );

                //insertar en la base de datos
                $conn = new mysqli($servername, $username, $password, $dbname);
                $binariosImagen = mysqli_escape_string($conn, $binariosImagen);
                $query = "INSERT INTO mascota(nombre, especie, edad, sexo, tamanio, visibilidadSitio, descripcion, fotografia, idCentro)
                VALUES ('".$mascota->getNombre."','".$mascota->getEspecie."','".$mascota->getEdad."','".$mascota->getSexo."','".$mascota->getTamanio."',
                '".$mascota->getVisibilidadSitio."','".$mascota->getDescripcion."','".$mascota->getFotografia."','".$mascota->getIdSucursal."')";
                $res=mysqli_query($conn, $query);
                $conn->close();
            }
            else{
                echo "Error al ingresar los datos";
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
