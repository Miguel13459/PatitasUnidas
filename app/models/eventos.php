<?php
    class Evento{
        private ?int $_idEvento;
        private string $_tipoEvento;
        private string $_fechaEvento;
        private int $_idMascota;
        private int $_idCentro;
        private int $_idEmpleado;

        public function __construct(?int $idEvento, string $tipoEvento, string $fechaEvento, int $idMascota, int $idCentro, int $idEmpleado) {
            $this->_idEvento = $idEvento;
            $this->_tipoEvento = $tipoEvento;
            $this->_fechaEvento = $fechaEvento;
            $this->_idMascota = $idMascota;
            $this->_idCentro = $idCentro;
            $this->_idEmpleado = $idEmpleado;
        }

        public function getId() {return $this->_idEvento;}
        public function getEvento() {return $this->_tipoEvento;}
        public function getFechaEvento() {return $this->_fechaEvento;}
        public function getIdMascota() {return $this->_idMascota;}
        public function getIdEmpleado() {return $this->_idEmpleado;}
        public function getIdCentro() {return $this->_idCentro;}

        public function setId($idEvento) {$this->_idEvento = $idEvento;}
        public function setEvento($tipoEvento) {$this->_tipoEvento = $tipoEvento;}
        public function setFechaEvento($fechaEvento) {$this->_fechaEvento = $fechaEvento;}
        public function setIdMascota($idMascota) {$this->_idMascota = $idMascota;}
        public function setIdEmpleado($idEmpleado) {$this->_idEmpleado = $idEmpleado;}
        public function setIdCentro($idCentro) {$this->_idCentro = $idCentro;}
    }    
?>
