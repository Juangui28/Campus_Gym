<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8">
    <title>Gimnasio</title>
    
    <!-- Estilos CSS -->
    <style>
        /* Estilos para el cuerpo del documento */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        /* Estilos para el contenedor principal */
        .container {
            text-align: center;
            margin-top: 50px;
        }
        /* Estilos para el encabezado principal */
        h1 {
            color: #333;
            font-size: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
    </style>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- Alertas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
        // Inclusión de archivos PHP necesarios
        include 'db/conexion.php';
        include 'cliente.php';
        include 'modalEditar.php';

        // Comprobación de si se ha solicitado eliminar un cliente
        if (isset($_GET["eliminar"])) {
            // Creación de un objeto Cliente y llamada al método eliminar
            $user = new Cliente($_GET["cedula"], null, null, null, null, null, null, null, null, null, null, null, $usuario);
            $user->eliminar();
        }
    ?>

    <!-- Contenido principal -->
    <div class="container">
        <br>
        <!-- Encabezado principal -->
        <h1>Bienvenido a nuestro gimnasio</h1>
        <br>
        <!-- Formulario de búsqueda de clientes por cédula -->
        <form action="editarEliminar.php" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar por cédula" name="cedula_busqueda" value="<?php echo isset($_GET['cedula_busqueda']) ? htmlspecialchars($_GET['cedula_busqueda']) : ''; ?>">
                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-search"></i> Buscar</button>
                <a href="editarEliminar.php" class="btn btn-secondary ms-2"><i class="fa-solid fa-eraser"></i> Limpiar</a>
            </div>
        </form>
        
        <?php
            // Inicio de la sesión PHP
            session_start();

            // Obtención de la cédula de búsqueda y el nombre de usuario de la sesión
            $cedula_busqueda = isset($_GET["cedula_busqueda"]) ? htmlspecialchars($_GET["cedula_busqueda"]) : '';
            $usuario = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';

            // Verificación de existencia de cédula de búsqueda y usuario
            if ($cedula_busqueda && $usuario) {
                // Consulta SQL para buscar clientes por cédula y usuario
                $sql_busqueda = "SELECT c.Cedula, c.Nombre, c.Apellido, c.Fecha_ingreso, c.Celular, ts.Grupo, c.Enfermedad, pg.Nombre_plan, e.Estado, c.Edad, c.Peso, c.Celular_emergencia 
                                FROM cliente AS c 
                                JOIN estado AS e ON c.Codigo_estado = e.Codigo_estado 
                                JOIN planes_gym AS pg ON c.Codigo_plan = pg.Codigo_plan 
                                JOIN tipo_sangre AS ts ON c.Codigo_rh = ts.Codigo_rh
                                WHERE c.Cedula LIKE ? AND c.Usuario LIKE ?";
                // Preparación y ejecución de la consulta
                $stmt_busqueda = $conn->prepare($sql_busqueda);
                $like_cedula = "%$cedula_busqueda%";
                $like_usuario = "%$usuario%";
                $stmt_busqueda->bind_param("ss", $like_cedula, $like_usuario);
                $stmt_busqueda->execute();
                $resultado = $stmt_busqueda->get_result();
                
                // Creación de tabla para mostrar resultados de búsqueda
                echo "<table class='table'>
                        <thead>
                            <tr>
                                <th>Cedula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Plan</th>
                                <th>Celular</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>";
                // Iteración sobre los resultados y creación de filas de tabla
                while ($row = $resultado->fetch_assoc()) {
                    $cedula = htmlspecialchars($row['Cedula']);
                    $nombre = htmlspecialchars($row['Nombre']);
                    $apellido = htmlspecialchars($row['Apellido']);
                    $nombrePlan = htmlspecialchars($row['Nombre_plan']);
                    $celular = htmlspecialchars($row['Celular']);

                    echo "<tr>
                            <td>$cedula</td>
                            <td>$nombre</td>
                            <td>$apellido</td>
                            <td>$nombrePlan</td>
                            <td>$celular</td>
                            <td>
                                <a href='editarEliminar.php?editar=true&cedula=$cedula' class='btn btn-success'><i class='fa-solid fa-user-pen'></i></a>
                                <a href='#' class='btn btn-danger btn-eliminar' data-cedula='$cedula'><i class='fa-solid fa-user-xmark'></i></a>
                            </td>
                        </tr>";
                }
                echo "</tbody></table>
                <a href='menu.php'><i class='fa-solid fa-person-running'></i> Regresar</a>";
                $stmt_busqueda->close();
            } else {
                // Consulta SQL para buscar clientes por usuario
                $sql = "SELECT c.Cedula, c.Nombre, c.Apellido, c.Fecha_ingreso, c.Celular, ts.Grupo, c.Enfermedad, pg.Nombre_plan, e.Estado, c.Edad, c.Peso, c.Celular_emergencia 
                        FROM cliente AS c 
                        JOIN estado AS e ON c.Codigo_estado = e.Codigo_estado 
                        JOIN planes_gym AS pg ON c.Codigo_plan = pg.Codigo_plan 
                        JOIN tipo_sangre AS ts ON c.Codigo_rh = ts.Codigo_rh
                        WHERE c.Usuario LIKE ?";
                // Preparación y ejecución de la consulta
                $stmt_busqueda = $conn->prepare($sql);
                $like_usuario = "%$usuario%";
                $stmt_busqueda->bind_param("s", $like_usuario);
                $stmt_busqueda->execute();
                $resultado = $stmt_busqueda->get_result();
            
                // Creación de tabla para mostrar resultados de búsqueda
                echo "<table class='table'>
                        <thead>
                            <tr>
                                <th>Cedula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Plan</th>
                                <th>Celular</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
                // Iteración sobre los resultados y creación de filas de tabla
                while ($row = $resultado->fetch_assoc()) {
                    $cedula = htmlspecialchars($row['Cedula']);
                    $nombre = htmlspecialchars($row['Nombre']);
                    $apellido = htmlspecialchars($row['Apellido']);
                    $nombrePlan = htmlspecialchars($row['Nombre_plan']);
                    $celular = htmlspecialchars($row['Celular']);

                    echo "
                        <tr>
                            <td>$cedula</td>
                            <td>$nombre</td>
                            <td>$apellido</td>
                            <td>$nombrePlan</td>
                            <td>$celular</td>
                            <td>
                                <a href='editarEliminar.php?editar=true&cedula=$cedula' class='btn btn-success'><i class='fa-solid fa-user-pen'></i></a>
                                <a href='#' class='btn btn-danger btn-eliminar' data-cedula='$cedula'><i class='fa-solid fa-user-xmark'></i></a>
                            </td>
                        </tr>";
                }   
                echo "</tbody></table>
                <a href='menu.php'><i class='fa-solid fa-person-running'></i> Regresar</a>";
                $stmt_busqueda->close();
            }
        ?>
    </div>
    <!-- Script para la funcionalidad de eliminar clientes -->
    <script>
        $(document).ready(function() {
            $('.btn-eliminar').on('click', function(e) {
                e.preventDefault();
                var cedula = $(this).data('cedula');

                // Alerta de confirmación para eliminar
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    // Redireccionamiento para eliminar el cliente si se confirma
                    if (result.isConfirmed) {
                        window.location.href = 'editarEliminar.php?eliminar=true&cedula=' + cedula;
                    }
                });
            });
        });
    </script>
</body>
</html>