<?php
/*require_once '../config/config.php';
    require_once 'autenticacionController.php';
    require_once '../models/centroAdoptivo.php';
    require_once '../models/eventos.php';
    require_once '../models/mascota.php';*/

class Empleado
{
    public ?int $_idEmpleado;
    private string $_usuario;
    private string $_contrasenia;
    private int $_centro;

    public function __construct(?int $idEmpleado, string $usuario, string $contrasenia, int $centro)
    {
        $this->_idEmpleado = $idEmpleado;
        $this->_usuario = $usuario;
        $this->_contrasenia = $contrasenia;
        $this->_centro = $centro;
    }

    //getters y setters, esto debido a que los miembros de la clase son privadas
    public function getIdEmpleado()
    {
        if ($this->_idEmpleado === null) {
            return null;
        } else {
            return $this->_idEmpleado;
        }
    }
    public function getUsuario()
    {
        return $this->_usuario;
    }
    public function getContrasenia()
    {
        return $this->_contrasenia;
    }
    public function getCentro()
    {
        return $this->_centro;
    }

    public function setIdEmpleado($idEmpleado)
    {
        $this->_idEmpleado = $idEmpleado;
    }
    public function setUsuario($usuario)
    {
        $this->_usuario = $usuario;
    }
    public function setContrasenia($contrasenia)
    {
        $this->_contrasenia = $contrasenia;
    }
    public function setCentro($centro)
    {
        $this->_centro = $centro;
    }


    //INICIO DE SESION
    public function iniciarSesion(array $empleado)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once 'autenticacionController.php';
        $sesionEmpleado = new Autenticacion($empleado['usuario'], $empleado['contrasenia']);
        $confirmarSesion = $sesionEmpleado->validarCredenciales();

        if ($confirmarSesion === true) {
            $empleado['estadoInicioSesion'] = $confirmarSesion;

            //require_once "../config/config.php";
            $servername = "localhost";
            $username = "cuidadorAdmin";
            $password = "citlalilandia";
            $dbname = "PatitasUnidas";
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("SELECT idPersonal FROM personal WHERE usuario = ?");
            $stmt->bind_param("s", $empleado['usuario']);
            $stmt->execute();
            $result = $stmt->get_result();
            $fila = $result->fetch_assoc();

            $empleado['idEmpleado'] = $fila ? (int) $fila['idPersonal'] : null;

            $_SESSION['usuario'] = $empleado['usuario'];
            return $empleado;
        } else {
            $empleado['estadoInicioSesion'] = false;
            return $empleado;
        }
    }

    //CERRAR SESION
    public function cerrarSesion()
    {
        session_start();
        session_destroy();
        header("Location: ../frontend/src/public/index.html");
    }

    //CREAR MASCOTA
    public function crearMascota(Mascota $mascota)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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

        $nombre = $mascota->getNombre();
        $especie = $mascota->getEspecie();
        $edad = $mascota->getEdad();
        $sexo = $mascota->getSexo();
        $tamanio = $mascota->getTamanio();
        $descripcion = $mascota->getDescripcion();
        $fotografia = $mascota->getFotografia();
        $idCentro = $mascota->getIdCentro();

        // Conexión
        //require_once "..config/config.php";
        $servername = "localhost";
        $username = "cuidadorAdmin";
        $password = "citlalilandia";
        $dbname = "PatitasUnidas";
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
            $stmt->close();
            $conn->close();
            return true;
        } else {
            error_log("Error al insertar: " . $stmt->error);
            $stmt->close();
            $conn->close();
            return false;
        }
    }

    public function editarMascota()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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

    public function eliminarMascota() {}

    public function registrarEvento() {}
}
