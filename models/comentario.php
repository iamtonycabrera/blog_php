<?php

    class Comentario{
        private $conn;
        private $table = 'comentarios';

        // Propiedades
        public $id;
        public $comentario;
        public $estado;
        public $fecha_creacion;

        // Constructor
        public function __construct($db){
            $this->conn = $db;
        }

        // Obtener los usuarios
        public function leer(){
            $query = 'SELECT c.id AS comentario_id, c.comentario AS comentario, 
            c.estado AS estado, c.fecha_creacion AS comentario_fecha_creacion,
            c.usuario_id, u.email AS nombre_usuario, a.titulo AS titulo_articulo  
            FROM ' . $this->table . ' c LEFT JOIN usuarios u ON u.id = c.usuario_id
            LEFT JOIN articulos a ON a.id = c.articulo_id';

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);

            // Ejecutar query
            $stmt->execute();
            
            // Retornar los articulo
            $comentarios = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $comentarios;
        }

        // Obtener un usuario
        public function leer_individual($id){
            $query = 'SELECT c.id AS comentario_id, c.comentario AS comentario, 
            c.estado AS estado, c.fecha_creacion AS comentario_fecha_creacion,
            c.usuario_id, u.email AS nombre_usuario, a.titulo AS titulo_articulo  
            FROM ' . $this->table . ' c LEFT JOIN usuarios u ON u.id = c.usuario_id
            LEFT JOIN articulos a ON a.id = c.articulo_id WHERE c.id = ? LIMIT 0,1';

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);

            // Vincular parametro
            $stmt->bindParam(1, $id);

            // Ejecutar query
            $stmt->execute();
            
            // Retornar los articulo
            $comentario = $stmt->fetch(PDO::FETCH_OBJ);
            return $comentario;
        }

        // Actualizar un articulo
        public function actualizar($idComentario, $estado){

                $query = 'UPDATE ' . $this->table . ' SET estado = :estado WHERE id = :id';

                // Preparar la sentencia
                $stmt = $this->conn->prepare($query);

                // Vincular parametro
                $stmt->bindParam(':id', $idComentario, PDO::PARAM_INT);
                $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);

                // Ejecutar query
                if ($stmt->execute()) {
                    return true;
                }
            // Si hay error
            printf("Error: ", $stmt->error);
        }

        public function borrar($idComentario){
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);

            // Vincular parametro
            $stmt->bindParam(':id', $idComentario, PDO::PARAM_INT);

            // Ejecutar query
            if ($stmt->execute()) {
                return true;
            }

            // Si hay error
            printf("Error: ", $stmt->error);
        }
    }