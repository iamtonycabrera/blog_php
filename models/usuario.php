<?php

    class Usuario{
        private $conn;
        private $table = 'usuarios';

        // Propiedades
        public $id;
        public $nombre;
        public $email;
        public $password;
        public $fecha_creacion;

        // Constructor
        public function __construct($db){
            $this->conn = $db;
        }

        // Obtener los usuarios
        public function leer(){
            $query = 'SELECT u.id AS usuario_id, u.nombre AS usuario_nombre, 
            u.email AS usuario_email, u.fecha_creacion AS usuario_fecha_creacion, 
            r.nombre AS rol FROM ' . $this->table . ' u INNER JOIN rol r ON r.id = u.rol_id';

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);

            // Ejecutar query
            $stmt->execute();
            
            // Retornar los articulo
            $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $usuarios;
        }

        // Obtener un usuario
        public function leer_individual($id){
            $query = 'SELECT u.id AS usuario_id, u.nombre AS usuario_nombre, 
            u.email AS usuario_email, u.fecha_creacion AS usuario_fecha_creacion, 
            r.nombre AS rol FROM ' . $this->table . ' u INNER JOIN rol r ON r.id = u.rol_id
            WHERE u.id = ? LIMIT 0,1';

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);

            // Vincular parametro
            $stmt->bindParam(1, $id);

            // Ejecutar query
            $stmt->execute();
            
            // Retornar los articulo
            $usuario = $stmt->fetch(PDO::FETCH_OBJ);
            return $usuario;
        }

        // Actualizar un articulo
        public function actualizar($idUsuario, $nombre, $rol){

                $query = 'UPDATE ' . $this->table . ' SET nombre = :nombre, rol_id = :rol_id WHERE id = :id';

                // Preparar la sentencia
                $stmt = $this->conn->prepare($query);

                // Vincular parametro
                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $stmt->bindParam(':rol_id', $rol, PDO::PARAM_INT);
                $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);

                // Ejecutar query
                if ($stmt->execute()) {
                    return true;
                }
            // Si hay error
            printf("Error: ", $stmt->error);
        }

        // Borrar
        public function borrar($idUsuario){
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);

            // Vincular parametro
            $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);

            // Ejecutar query
            if ($stmt->execute()) {
                return true;
            }

            // Si hay error
            printf("Error: ", $stmt->error);
        }

        // Registrarse
        public function registro($nombre, $email, $password){
            $query = 'INSERT INTO ' . $this->table . ' (nombre, email, password, rol_id)VALUES(:nombre, :email, :password, 2)';

            // Encriptar el password
            $passwordEncriptado = md5($password);

            // Preparar la sentencia
            $stmt = $this->conn->prepare($query);

            // Vincular parametro
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordEncriptado, PDO::PARAM_STR);

            // Ejecutar query
            if ($stmt->execute()) {
                return true;
            }

            // Si hay error
            printf("Error: ", $stmt->error);
        }

        // Validar si el email existe
        public function validar_email($email){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $registroEmail = $stmt->fetch(PDO::FETCH_ASSOC);

            if($registroEmail){
                return false;
            } else {
                return true;
            }
        }

        // Validar si el email existe
        public function login($email, $password){
            // Crear query
            $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email AND password = :password';

            // Encriptar el password
            $passwordEncriptado = md5($password);

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordEncriptado, PDO::PARAM_STR);

            $stmt->execute();

            $existeUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$existeUsuario){
                return false;
            } else {
                return true;
            }
        }
    }