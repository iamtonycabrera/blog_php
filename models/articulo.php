<?php

    class Articulo{
        private $conn;
        private $table;

        // Propiedades
        public $id;
        public $titulo;
        public $imagen;
        public $texto;
        public $fecha_creacion;

        // Constructor
        public function __construct($db){
            $this->conn = $db;
        }

        // Obtener los articulos
        public function leer(){
            $query = 'SELECT id, titulo, imagen, texto, fecha_creacion FROM ' . $this->table;

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);

            // Ejecutar query
            $stmt->execute();
            
            // Retornar los articulo
            $articulos = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $articulos;
        }
    }