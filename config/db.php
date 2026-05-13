<?php
    /*Parte encargada de la conexion a la db en este caso a supabase
    En cuanto al host es la url para conectar a la base de datos*/
    $host = 'aws-1-us-west-2.pooler.supabase.com';
    // el puerto por donde se conecta
    $port = '5432';
    // el nombre de la base de datos
    $database = 'postgres';
    // identificador de la unico de la base de datos
    $user = 'postgres.oklvbiyignsjsjwpiehr';
    // el password que se le coloco a la base de datos
    $pass = 'Todoip*10crud';

    /*Se va a usar la inyeccion de dependencias
    Se crea la clase para la conexion*/
    class conexion{
        //Variable tipo privada
        private $pdo;
        //Se crea la funcion y la constructor se le pasa los datos de la coexion a la db
        public function __construct($host, $port, $database, $user, $pass){
            //El try y catch es para validar errores
            try {
                //Se usa el pgsql que permite la comuncacion entre php y la base de datos 
                $dsn ="pgsql:host=$host;port=$port;dbname=$database";
                //En esta parte se crea el objeto con new
                $this -> pdo = new PDO($dsn, $user, $pass);
                //Manejo de errores -> para llamar al meotodo que le pertenece al objeto 
                $this -> pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                //Mensaje de error contadenado a la exception 
                error_log("Error al conectarse a la base de datos".$e->getMessage());
                //Die es un alias del exit detiene la ejecucion y muestra un mensaje de manera opcional, usuario 
                die("Error en la conexion del servidor");
            }
        }
        //Funcion para que otras clases puedan usar la conexion osea devuleve el obejto pdo
        public function getConexion(){
            return $this->pdo;
        }
    }
?>