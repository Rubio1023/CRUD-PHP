<?php

//Se crea la conexion a la base de datos y al controlador

//En el index se usa la conexion a la Db y al controller
require_once "config/db.php";
require_once "controller/usuario_controller.php";

//Se usa el try y catch en caso de error, para que no salga un error muy tecnico al usuario o con informacion inecesaria por eso se usa el try nada mas.
try {
    
    //Se crea la conexion a la base de datos con los parametros establecidos que se encuentran en config/db.php
    $db = new databaseConexion($host, $port, $database, $user, $pass);
    //A la variable pdo se le pasa los valores o la conexion de la db. en la db el getConexion se usa para crear el obejto tipo conexion pdo para que otras clases se puedan conectar a la base de datos
    $pdo = $db -> getConexion();
    //Lo que se realiza aqui es la creacion de la instancia del objeto usuarioController y se le pasa la variable pdo la cual contiene la conexion a la base de datos
    $controller = new usuarioController($pdo);

    //Enrutamiento
    //Se crea la variable ejecutar se le pasa la REQUEST la cual es unavariable asociativa que contiene GET, POST y COOKIE. La doble ?? es una coalescencia
    $ejecutar = $_REQUEST['ejecutar'] ?? 'listadoUsuarioController';

    //Se realiza un switch de igual forma se puede usar el if para manejar las entradas o valores que le ingrese a la variable ejecutar por medio de REQUEST
    switch ($ejecutar) {
        //Primer caso seria cuando entra un usuario pero no a enviado nada ni realizado accion entonces entra por defecto al listado de usuario
        case 'listadoUsuarioController':
            //En esta parte como se creo la instancia se usa en esta parte para llamar la funcion del controllador
            $controller -> listadoUsuarioController();
            break;
        
        default:
            # code...
            break;
    }
} catch (\Throwable $th) {
    
}



?>