<?php
    /*Actúa como intermediario y "cerebro" que gestiona el flujo de la aplicación. Recibe las entradas del usuario (clics, formularios, URL), procesa la lógica de negocio, solicita datos al Modelo y selecciona la Vista adecuada para mostrar la respuesta, sin interactuar directamente con la interfaz.
    Solo se ocmunica con el model*/

    require_once "model/usuario_model.php";

    //Clase del controlador
    class usuarioController{

        //Variable para guardar el modelo 
        private $model;

        //Funcion para la conexion a la db 
        public function __construct($pdo){
            /*Se inyecta y se crea el modelo se la pasa la conexion.
            Se hace refencia a la variable global tipo privada model con $this se puede usar dentro de esa funcion.
            se crea el objeto usuarioModel y se le pasa el valro que esta entre () que es $pdo.
            Todo lo anterior sirve para devolver la instancia osea entrega el objeto terminado y se guarda en model.*/ 
            $this -> model = new usuarioModel($pdo);
        }

        //funcion para mostrar los datos en view losta_usuarios.php para eso se usa la funcion del model
        public function listadoUsuarioController(){
            //Se usa la misma variable que en view para que esta que tiene un array de los datos se pueda presentar, adicional se le pasa la inyeccion que es model y la funcion que esta en model
            $listado = $this -> model -> listadoUsuariosModel();
            //Se carga la funcion o el array a view de esa forma se evita realizar el llamado desde view lo cual rompe el MVC
            require_once "view/lista_usuario.php";
        }

        //Funcion para crear usuario
        public function crearUsuarioController(){
            //Verifica que se haya enviado el formulario en otras palabras, ya sea con enter o por el boton si se realiza una accion para enviar la tomara y se envia la informacion
            if ($_SERVER["REQUEST_METHOD"] == 'POST'){
                //Validacion que los datos existan y no esten vacios
                if (!empty($_POST['name']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['phone'])) {
                    $name = $_POST['name'];
                    $lastname = $_POST['lastname'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];

                    //Se guarda los datos y direcciona segun el resultado
                    //el crearUsuario viene del model donde esta la funcion como tal
                    if ($this -> model -> crearUsuarioMode($name, $lastname, $email, $phone)) {
                        //Esta linea lo que hace es que cuando se crea regresa al index pero con la etiqueta que se le asigna despues de ? msg es la variable a la que se le asigna el valor osea creado (llave->valor) este mensaje sale al nivel de la URL
                        header("location: index.php?msg=creado");                        
                    }else {
                        //
                        header("location: index.php?msg=error_db");
                    }
                    //Se usa el exit para evitar que lea las lineas de abajo osea la funcion termina aqui
                    exit();
                }else {
                    //En caso de que los campos esten vacios se redirecciona al index pero con una etiqueta de error
                    header("location: index.php?msg=error_campos_vacios");
                    //los mismo que el anterior
                    exit();
                }
            }
        } 

        //Funcion para editar datos
        public function editarUsuarioController(){
            //Verifica que se haya enviado el formulario en otras palabras, ya sea con enter o por el boton si se realiza una accion para enviar la tomara y se envia la informacion
            if ($_SERVER["REQUEST METHOD"] == 'POST'){
                //Se le pasa los datos 
                $id = $_POST['id'];
                $name = $_POST['name'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                //Se usa la pseudo-variable $this la cual hace referencia a la variable global privada al inicio  
                if ($this -> model -> editarUsuraioModel($id, $name, $lastname, $email, $phone)) {
                    header("location: index.php?msg=usuario_editado");
                    exit();
                }else {
                    header("location: index.php?msg=Usuario_no_editado");
                    exit();
                }
            }
        }

        //Funcion para eliminar usuarios se le pasa el parametro de id
        public function eliminarUsuarioController($id){
            // 
            if ($_SERVER["REQUEST METHOD"] == 'POST' && isset($_POST['id'])){
                $id = $_POST['id'];
            if ($this -> model -> eliminarUsuarioModel($id)){
                    header("location: index.php?msg=usuario_eliminado");
                    exit();
                }
            }
        }
    }
?>