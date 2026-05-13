<!DOCTYPE html>
<!--Codigo html para visualizar el listado de los usuarios-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Listado de Usuarios</title>
</head>
<body>
    <!--Titulo-->
    <h1>LISTADO DE USUARIOS</h1>
    <!--Div para el boton para crear nuevo usuario-->
    <div class="btn_usuario_new">            
        <button type="button" class="btn btn-primary btn-lg">Registrar Usuario</button>
    </div>
    <!--Div que muestra la lista de usuarios-->
    <div class="listado">
    <!--Se crea una tabla (table) esta puede tener 3 partes cabeza (thead), cuerpo (tbody) y pies (tfoot)-->
        <table class="table table-striped table-hover">
            <!--Se crea la cabeza (thead) el encabezado -->
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Email</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <!--Se crea el cuerpo (tbody) lo uqe se muestra despues del encabezado el contenido-->
            <tbody>
                <!--Codigo php para realizar el recorrido al array y poder presentar los valores en la tabla-->
                <?php foreach ($listado as $list):?>
                <tr>
                    <td scope="row"><?php echo $list ['id'];?></td>
                    <td><?php echo ($list['name']);?></td>
                    <td><?php echo ($list['lastname']);?></td>
                    <td><?php echo ($list['phone']);?></td>
                    <td><?php echo ($list['email']);?></td>
                    <td>
                        <a href=""><i class="bi bi-trash3-fill"></i></a>
                        <a href=""><i class="bi bi-pencil-square"></i></a>
                    </td>
                </tr>
                 <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>