<?php

    class Articulo{
        private $conn;
        private $table = 'articulos';

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

        // Obtener un articulos
        public function leer_individual($id){
            $query = 'SELECT id, titulo, imagen, texto, fecha_creacion FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);

            // Vincular parametro
            $stmt->bindParam(1, $id);

            // Ejecutar query
            $stmt->execute();
            
            // Retornar los articulo
            $articulo = $stmt->fetch(PDO::FETCH_OBJ);
            return $articulo;
        }

        // Crear un nuevo articulo
        public function crear($titulo, $imagen, $texto){
            $query = 'INSERT INTO ' . $this->table . ' (titulo, imagen, texto)VALUES(:titulo, :imagen, :texto)';

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);

            // Vincular parametro
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
            $stmt->bindParam(':texto', $texto, PDO::PARAM_STR);

            // Ejecutar query
            if ($stmt->execute()) {
                return true;
            }

            // Si hay error
            printf("Error: ", $stmt->error);
        }
    }