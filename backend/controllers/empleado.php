<?php
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
    public function getUsuario(){return $this->_usuario;}
    public function getContrasenia(){return $this->_contrasenia;}
    public function getCentro(){return $this->_centro;}

    public function setIdEmpleado($idEmpleado){$this->_idEmpleado = $idEmpleado;}
    public function setUsuario($usuario){$this->_usuario = $usuario;}
    public function setContrasenia($contrasenia){$this->_contrasenia = $contrasenia;}
    public function setCentro($centro){$this->_centro = $centro;}


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
            //require_once(__DIR__ . '/../config/config.php');
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
        //header("Location: ../frontend/src/public/index.html");
    }

    //CREAR MASCOTA
    public function crearMascota(Mascota $mascota) : bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $nombre = $mascota->getNombre();
        $especie = $mascota->getEspecie();
        $edad = $mascota->getEdad();
        $sexo = $mascota->getSexo();
        $tamanio = $mascota->getTamanio();
        $visibilidadSitio = $mascota->getVisibilidadSitio();
        $descripcion = $mascota->getDescripcion();
        $fotografia = $mascota->getFotografia();
        $idCentro = 1;

        // Conexión
        //require_once "..config/config.php";
        //require_once(__DIR__ . '/../config/config.php');
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

        $fotoPlaceholder = null;

        $stmt->bind_param(
            "sssssisbi",
            $nombre,
            $especie,
            $edad,
            $sexo,
            $tamanio,
            $visibilidadSitio,
            $descripcion,
            $fotoPlaceholder,
            $idCentro
        );
        $stmt->send_long_data(7, $fotografia);

        $succes = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $succes;

        // Ejecutar
        /*if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return true;
        } else {
            error_log("Error al insertar: " . $stmt->error);
            $stmt->close();
            $conn->close();
            return false;
        }*/
    }

    public function editarMascota(Mascota $mascota)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $idMascota = $mascota->getId();
        $nombre = $mascota->getNombre();
        $especie = $mascota->getEspecie();
        $edad = $mascota->getEdad();
        $sexo = $mascota->getSexo();
        $tamanio = $mascota->getTamanio();
        $descripcion = $mascota->getDescripcion();
        $fotografia = $mascota->getFotografia();
        $idCentro = 1;

        //require "..config/config.php";
        require_once(__DIR__ . '/../config/config.php');
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $fotoPlaceholder = null;
        
        if ($fotografia != null) {
            $stmt = $conn->prepare("UPDATE mascota SET nombre = ?, especie= ?, edad= ?, sexo= ?, tamanio= ?, descripcion= ?, fotografia= ?, idCentro= ? WHERE idMascota=?");
            $stmt->bind_param("ssssssbii", $nombre, $especie, $edad, $sexo, $tamanio, $descripcion, $fotoPlaceholder, $idCentro, $idMascota);
            $stmt->send_long_data(6, $fotografia);
        } else {
            $stmt = $conn->prepare("UPDATE mascota SET nombre = ?, especie= ?, edad= ?, sexo= ?, tamanio= ?, descripcion= ?, idCentro= ? WHERE idMascota=?");
            $stmt->bind_param("ssssssii", $nombre, $especie, $edad, $sexo, $tamanio, $descripcion, $idCentro, $idMascota);
        }


        $succes = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $succes;
    }

    public function eliminarMascota(int $idMascota) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $visibilidadSitio = 0;

        require_once(__DIR__ . '/../config/config.php');
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("UPDATE mascota SET visibilidadSitio = ? WHERE idMascota = ?");
        $stmt->bind_param("ii", $visibilidadSitio, $idMascota);

        $succes = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $succes;

    }

    public function registrarEvento(Evento $evento) {
        
    }
}
