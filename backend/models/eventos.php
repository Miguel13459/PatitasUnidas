<?php
    class Evento{
        private int $_idEvento;
        private string $_tipoEvento;
        private string $_fechaEvento;
        private int $_idEmpleado;
        private int $_idCentro;

        public function __construct(?int $idEvento, string $tipoEvento, string $fechaEvento, int $idEmpleado, int $idCentro ) {
            $this->_idEvento = $idEvento;
            $this->_tipoEvento = $tipoEvento;
            $this->_fechaEvento = $fechaEvento;
            $this->_idEmpleado = $idEmpleado;
            $this->_idCentro = $idCentro;
        }

        public function getId() {return $this->_idEvento;}
        public function getNombre() {return $this->_tipoEvento;}
        public function getEspecie() {return $this->_fechaEvento;}
        public function getEdad() {return $this->_idEmpleado;}
        public function getIdCentro() {return $this->_idCentro;}

        public function setId($idEvento) {$this->_idEvento = $idEvento;}
        public function setNombre($tipoEvento) {$this->_tipoEvento = $tipoEvento;}
        public function setEspecie($fechaEvento) {$this->_fechaEvento = $fechaEvento;}
        public function setEdad($idEmpleado) {$this->_idEmpleado = $idEmpleado;}
        public function setIdCentro($idCentro) {$this->_idCentro = $idCentro;}
    }    
?>
