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
            //Se inyecta y se crea el modelo se la pasa la conexion 
            $this -> model = new usuarioModel($pdo);
        }

        //funcion para mostrar los datos en view losta_usuarios.php para eso se usa la funcion del model
        public function listaUsuario(){
            /*Se usa la misma variable que en view para que esta que tiene un array de los datos se pueda presentar, adicional se le pasa la inyeccion que es model y la funcion que esta en model*/
            $listado = $this -> model -> mostrarDatos();
            //Se carga la funcion o el array a view
            require_once "view/lista_usuario.php";
        }

        //Funcion para crear datos
        public function crear_usuario(){
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                
            }
        } 


    }
?>