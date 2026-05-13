<?php
    //Gestiona los datos y la lógica de negocio. Consulta bases de datos, valida información y manipula el estado de la aplicación

    //Se usa para establecer la conexion
    require_once "config/db.php";
    
    //Clase del model  
    class usuarioModel{
        
    //Variable privada 
        private $db;

        //funcion constructor para conectar a la db
        public function __construct($pdo){
            /*Se le asigna la conexion de la base de datos a la variable privada db el cual trae la conexion con pdo desde db.php.
            $pdo tiene toda la configuracion para realizar la conexion*/
            $this -> db = $pdo;
        }

        //Funcion para crear usuario
        public function crearUsuarioModel($name, $lastname, $email, $phone){
            //Validamos la creacion del usuario
            try {
                //Variable a la que se le pasa el comando sql
                $sql = "INSERT INTO usuarios (name, lastname, email, phone) VALUES(:name, :lastname, :email, :phone)";
                // Variable donde se pasa el sql y el prepare
                $stmt = $this -> db -> prepare($sql);
                //Se regresa la consulta y se envia los datos al db
                return $stmt -> execute([':name' => $name, ':lastname' => $lastname, ':email' => $email, ':phone' => $phone]);
                //Try lanza el error y catch lo atrapa y muestra el error 
            } catch (PDOException $e) {
                //error log para nosotro el usuario no lo ve 
                error_log("Error al refistrar el usuario: ".$e->getMessage());
                //Exit con mensaje de error
                die("Error al crear usuario");
            }
        }

        //Funcion para listar o mostrar los datos
        public function listadoUsuariosModel(){
            //validamos listar
            try {
                //cVAriable que contiene el sql 
                $sql = "SELECT * FROM usuarios ORDER BY id ASC";
                //Sele pasa los valores de sql al stmt 
                $stmt = $this -> db -> prepare($sql);
                //manda la orden de executar a la db 
                $stmt->execute();
                //Devuelve los datos de la db en un array
                return $stmt -> fetchALL(PDO::FETCH_ASSOC);
                //Control de error
            } catch (PDOException $e) {
                //Error log para visualizar el error 
                error_log("Error al realizar el listado de usuarios: ".$e->getMessage());
                //Retorna el array vacio 
                return[];
            }
        }

        //Funcion para editar el usuario
        public function editarUsuarioModel($id, $name, $lastname, $email, $phone){
            //Validamos el editar
            try {
                //Variable con el comando sql
                $sql = "UPDATE usuarios SET name = :name, lastname = :lastname, email = :email, phone = :phone WHERE id = :id";
                //Variable donde se le pasa el sql y el prepare
                $stmt = $this -> db -> prepare($sql);
                //Se envia o retorna el valor de $stmt y se envia a la db
                return $stmt -> execute([':name' => $name, ':lastname' => $lastname, ':email' => $email, ':phone' => $phone, ':id' => $id]);
                //Si hay un error lanza el error y el catch lo atrapa 
            } catch (PDOException $e) {
                //Error log para visiaulizar el tipo de error
                error_log("Error al editar el usuario: ".$e->getMessage());
                //Exit con mensaje para el usuario
                die("Error al editar el usuario");
            }
        }

        //Funcion para eliminar
        public function eliminarUsuarioModel($id){
            //Validamos el eliminar
            try {
                //Variable con el comando para eliminar
                $sql = "DELETE FROM usuarios WHERE id = :id";
                //Variable donde se le pasa el sql y el prepare
                $stmt = $this -> db -> prepare($sql);
                //Se envia la peticion de eliminar 
                return $stmt -> execute([':id' => $id]);
                //Manejo de errores 
            } catch (PDOException $e) {
                //Error log para visualizar el tipo de error
                error_log("Error al eliminar al usuario: ".$e->getMessage());
                //Exit con mensaje para el usuario
                die("Error al eliminar al usuario");
            }
        }
    }
?>