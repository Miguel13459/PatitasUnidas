<?php
    class Mascota{
        private int $idMascota;
        private string $nombre;
        private string $especie;
        private string $edad;
        private string $sexo;
        private string $tamanio;
        private bool $visibilidadSitio;
        private string $descripcion;
        private string $fotografia;
        private int $tipoSucursal;

        public function __construct(
            string $nombre, string $especie, string $edad, string $sexo, string $tamanio,
            bool $visibilidadSitio, string $descripcion, string $fotografia, int $tipoSucursal
        ) {
            $this->nombre = $nombre;
            $this->especie = $especie;
            $this->edad = $edad;
            $this->sexo = $sexo;
            $this->tamanio = $tamanio;
            $this->visibilidadSitio = $visibilidadSitio;
            $this->descripcion = $descripcion;
            $this->fotografia = $fotografia;
            $this->tipoSucursal = $tipoSucursal;
        }

        public function mostrarMascota(){
            
        }
    }    
?>
