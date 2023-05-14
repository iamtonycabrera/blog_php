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

        // Crear un nuevo comentario
        public function crear($email, $comentario, $idArticulo){

            // Obtener el id del usuario usando el email
            $query = 'SELECT * FROM usuarios WHERE email = :email';
            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);
            // Vincular parametro
            $stmt->bindParam(':email', $email);
            // Ejecutar query
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_OBJ);
            $idUsuario = $usuario->id;

            // Crear query para la insercion del comentario
            $query2 = 'INSERT INTO ' . $this->table . ' (comentario, usuario_id, articulo_id, estado)
            VALUES(:comentario, :usuario_id, :articulo_id, 0)';

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query2);
            // Vincular parametro
            $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
            $stmt->bindParam(':usuario_id', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':articulo_id', $idArticulo, PDO::PARAM_INT);

            // Ejecutar query
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
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

        // Cargar comentarios de articulo por el id
        public function comentariosDeArticulo($idArticulo){
            // Crear query
            $query = 'SELECT c.id AS comentario_id, c.comentario AS comentario, 
            c.estado AS estado, c.fecha_creacion AS fecha, c.usuario_id, 
            u.email AS nombre_usuario 
            FROM ' . $this->table . ' c INNER JOIN usuarios u ON u.id = c.usuario_id
            WHERE articulo_id = :articulo_id AND estado = 1';

             // Preparar la sentencia
             $stmt = $this->conn->prepare($query);

             // Vincular parametro
             $stmt->bindParam(':articulo_id', $idArticulo, PDO::PARAM_INT);

             // Ejecutar query
            $stmt->execute();

            $comentarios = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $comentarios;
        }
    }