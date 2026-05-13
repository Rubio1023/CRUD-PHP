# CRUD USANDO MVC POR INYECCION DE DEPENDENCIAS

Como tal se uso el MVC, Modelo, Vista, Controlador cual es la funcion o que hace.
El Modelo: gestiona la interaccion con la base de datos (CRUD: Crear, Leer, Actualizar, Borrar).
La Vista: Representa los datos al usuario final (archivos html/php con plantillas).
El controlador: recibe las peticiones del usuario via URL, interactua con el modelo y carga la vista correspondiente.

**Flujo del MVC**
Se realiza la peticion en el index.php, el controlador captura la peticion y determina que modelo y vista usar, el modelo obtiene o guarda datos en la base de datos, y la vista muestra la informacion recibida del controlador al usuario

**DB configuracion**
En cuanto a la configuracion de la db se pasa los parametros para la conexion y se va a realizar por inyeccion de dependencia, inyeccion de dependencia(DI) es un patron de diseño que permite a una clase recibir sus dependencias desde el exteriror, en lugar de crearlas internamente. 

# Codigo de configuracion de la base de datos 

Se va a usar la inyeccion de dependencias

Parte encargada de la conexion a la db en este caso a supabase
    En cuanto al host es la url para conectar a la base de datos
    $host = '';
    el puerto por donde se conecta
    $port = '';
    el nombre de la base de datos
    $database = '';
    identificador de la unico de la base de datos
    $user = '';
     el password que se le coloco a la base de datos
    $pass = '';
    
*Se crea la clase para la conexion*
    class conexion{
        Variable tipo privada y al ser privada solo vivira dentro de esta clase osea se aplica encapsulamiento 
        private $pdo;
        Se crea la funcion y la constructor se le pasa los datos de la conexion a la db
        al crear el construtor y user el new conexion(..) el objeto ya nace con la conexion 
        public function __construct($host, $port, $database, $user, $pass){
            //El try y catch es para validar errores
            try {
                //Se usa el pgsql que permite la comuncacion entre php y la base de datos 
                $dsn ="pgsl:host=$host;port=$port;dbname=$database";
                //En esta parte se crea el objeto con new. PDO es una variable del sistema de php el cual es el motor que se comunica con las db al usar esto dentro de una clase se hace una composicion.
                El this funciona en este caso como una memoria permanente, la varible y dentro de una funcion vive mientras se ejecuta esta funcion y muere cuando termina el this hace que la variable se guarde en el cuerpo del objeto por ende la variable vivira mientras el objeto exista
                $this -> db = new PDO($dsn, $user, $pass);
                //Manejo de errores
                //El setAttribute sirve para establecer un atributo en el identificador de la base de datos el attr_errmode atrapa o pasa un int o una llave lo mismo errmode que tiene un valor igualmente.
                //como tal el att_errmode es la encargada de procesar 3 tipos de errores corespondientes al db
                //Por parte del ERRMODE_EXCEPTION lo cual al detectar un error en el codigo lo detiene y lanza un error si no se coloca un cath para menejar el error este se pararia totalmente y sin el ERRMODE el programa seguiria con el error.
                //Si hay error PDO lanza el objeto y el catch lo atrapa y la variable $e contiene toda la informacion del error 
                $this -> db = setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //se strapa el error por el catch 
            } catch (PDOException $e) {
                //Mensaje de error contadenado a la exception 
                error_log("Error al conectarse a la base de datos".$e->getMessage());
                //Die es un alias del exit detiene la ejecucion y muestra un mensaje de manera opcional, usuario 
                die("Error en la conexion del servidor");
            }
        }
    }

Codigo del model se encarga de proteger la base de datos

    //Gestiona los datos y la lógica de negocio. Consulta bases de datos, valida información y manipula el estado de la aplicación

    //se usa para establecer la conexion
    require_once "config/db.php";
    class conexionDB
        
    //Clase para la conexion a db    
    class conexionDB{
        
    //Variable privada 
        private $db;

        //funcion constructor para conectar a la db
        public function __construct($db){

            //Se le asigna la conexion de la db a la variable privada de la clase db para que se pueda usar si no se usa el this no se podra usar en otras funciones 
            $this->db = $db;
        }

        //Se puede hacer asi con marcadores de posicion o con marcadores por nombre 
        /*funcion que sirve para crear el usuario en la db.
        Se le pasa los campos de la base de datos en los parametros.*/
        public function crear($name, $lastname, $email, $phone){
            //Validamos la creacion del usuario
            try {
                /*Variable a la que se le pasa el comando sql.
                Los ? son marcadores de posicion */
                $sql = "INSERT INTO usuarios (name, lastname, email, phone) VALUES(?, ?, ?, ?)";
                /* Variable donde se pasa el sql y el prepare.
                El prepare lo que hace es enviar una consulata a postgre sin los datos el motor de la base de datos analiza la estrucutra del slq antes de que llegue cualquier info.
                Esto evita las inyecciones sql 
                $stmt = $this -> db -> prepare($sql);
                //Se regresa la consulta y se envia los datos al db
                return $stmt -> execute([$name, $lastname, $email, $phone]);
                //Try lanza el error y catch lo atrapa y muestra el error 
            } catch (PDOException $e) {
                //error log para nosotro el usuario no lo ve 
                error_log("Error al refistrar el usuario: ".$e->getMessage());
                die("Error al crear usuario");
                return false;
            }
        }

        //codigo utilizado en base a marcadores por nombre como se ve en el values se hace con :nombre  y en el execute se usa :nombre => variable asociada 
         //Funcion para crear usuario
        public function editar($id, $name, $lastname, $email, $phone){
            //Validamos el editar
            try {
                //Variable con el comando sql
                $sql = "UPDATE usuarios SET name => :name, lastname => :lastname, email => :email, phone => :phone WHERE id :id";
                //Variable donde se le pasa el sql y el prepare
                $stmt = this -> db -> prepare($sql);
                //Se envia o retorna el valor de $stmt y se envia a la db
                return $stmt -> execute([':name' => $name, ':lastname' => $lastname, ':email' => $email, ':phone' => $phone, 'id' => $id]);
                //Si hay un error lanza el error y el catch lo atrapa 
            } catch (PDOException $e) {
                //Error log para visiaulizar el tipo de error
                error_log("Error al editar el usuario: ".$e->getMessage());
                die("Error al editar el usuario");
                return false;
            }
        }

        //Codigo de mostrar usuarios
        //Funcion para listar o mostrar los datos
        public function listar(){
            //validamos listar
            try {
                //VAriable que contiene el sql, se le pasa el comando que entiende la db
                $sql = "SELECT * FROM usuarios ORDER BY id ASC";
                //Sele pasa los valores de sql al stmt prepare es para que la db o el motor de este este lista para recibir la peticion
                $stmt = $this -> db -> prepare($sql);
                //manda la orden de executar a la db osea que haga lo que dice el sql al extraer los datos no se le pasa parametros por lo cual los datos estan en espera a ser procesados
                $stmt->execute();
                //Devuelve los datos de la db en un array el fetch trae solo una fila el fetchall trea todos los datos que coincidan con esa consulta en un array.
                el PDO::FETCH_ASSOC es un meotod de extracion para que php cree un arraglo donde las llaves sean los nombres de las columnas de la tabla ej:(id,nombre,email..etc) sin esto PDO devolvera un arreglo duplicado por nombre y numero de columna gastando recursos
                return $stmt -> fetchALL(PDO::FETCH_ASSOC);
                //Control de error
            } catch (PDOException $e) {
                //Error log para visualizar el error 
                error_log("Error al realizar el listado de usuarios: ".$e->getMwssage());
                //Retorna el array vacion para que el foreach no genere un error cirtico solo no muestra los datos y la pagina se cargara sin problemas
                return[];
            }
        }
    }

Codigo del controlador el ucal se encarga de la validacion y limpieza de todo lo que entra

<?php
    /*Actúa como intermediario y "cerebro" que gestiona el flujo de la aplicación. Recibe las entradas del usuario (clics, formularios, URL), procesa la lógica de negocio, solicita datos al Modelo y selecciona la Vista adecuada para mostrar la respuesta, sin interactuar directamente con la interfaz.
    Solo se ocmunica con el model*/

    require_once "model/usuario_model.php";

    //Clase del controlador
    class usuarioController{

        //Variable para guardar el modelo 
        private $model;

        //Funcion para la conexion a la db en db.php se crea la conexion con pdo
        public function __construct($pdo){
            //Se inyecta y se crea el modelo se la pasa la conexion 
            $this -> model = new usuarioModel($pdo);
        }

        //funcion para mostrar los datos en view lista_usuarios.php para eso se usa la funcion del model
        public function listaUsuario(){
            /*Se usa la misma variable que en view para que esta que tiene un array de los datos se pueda presentar, adicional se le pasa la inyeccion que es model y la funcion que esta en model usuario_model.php*/
            $listado = $this -> model -> mostrarDatos();
            /*Se carga la funcion o el array a view sin esto no se visualiza en el listado_usuario.php la carga de los datos igualmente si no se tiene no se visualiza los datos y si se coloca antes del $listado igual no funciona*/
            require_once "view/lista_usuario.php";
        }

        //Funcion para crear datos
        public function crear_usuario(){
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                
            }
        } 
    }
?>