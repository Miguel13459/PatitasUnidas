<?php
    class Mascota{
        private ?int $_idMascota;
        private string $_nombre;
        private string $_especie;
        private string $_edad;
        private string $_sexo;
        private string $_tamanio;
        private bool $_visibilidadSitio;
        private string $_descripcion;
        private string $_fotografia;
        private int $_idCentro;

        public function __construct(
            ?int $idMascota, string $nombre, string $especie, string $edad, string $sexo, string $tamanio,
            bool $visibilidadSitio, string $descripcion, string $fotografia, int $idCentro
        ) {
            $this->_idMascota = $idMascota;
            $this->_nombre = $nombre;
            $this->_especie = $especie;
            $this->_edad = $edad;
            $this->_sexo = $sexo;
            $this->_tamanio = $tamanio;
            $this->_visibilidadSitio = $visibilidadSitio;
            $this->_descripcion = $descripcion;
            $this->_fotografia = $fotografia;
            $this->_idCentro = $idCentro;
        }

        public function getId() {return $this->_idMascota;}
        public function getNombre() {return $this->_nombre;}
        public function getEspecie() {return $this->_especie;}
        public function getEdad() {return $this->_edad;}
        public function getSexo() {return $this->_sexo;}
        public function getTamanio() {return $this->_tamanio;}
        public function getVisibilidadSitio() {return $this->_visibilidadSitio;}
        public function getDescripcion() {return $this->_descripcion;}
        public function getFotografia() {return $this->_fotografia;}
        public function getIdCentro() {return $this->_idCentro;}

        public function setId($idMascota) {$this->_idMascota = $idMascota;}
        public function setNombre($nombre) {$this->_nombre = $nombre;}
        public function setEspecie($especie) {$this->_especie = $especie;}
        public function setEdad($edad) {$this->_edad = $edad;}
        public function setSexo($sexo) {$this->_sexo = $sexo;}
        public function setTamanio($tamanio) {$this->_tamanio = $tamanio;}
        public function setVisibilidadSitio($visibilidadSitio) {$this->_visibilidadSitio = $visibilidadSitio;}
        public function setDescripcion($descripcion) {$this->_descripcion = $descripcion;}
        public function setFotografia($fotografia) {$this->_fotografia = $fotografia;}
        public function setIdCentro($idCentro) {$this->_idCentro = $idCentro;}

        public function mostrarMascota(){
            
        }
    }    
?>
