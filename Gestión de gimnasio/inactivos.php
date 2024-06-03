<?php
    // Incluir el archivo de conexión a la base de datos
    include 'db/conexion.php';

    // Consultar el número total de clientes inactivos
    $sqlCountInactivos = "SELECT COUNT(*) AS total_inactivos FROM cliente WHERE Codigo_estado = 2";
    $resultadoCountInactivos = mysqli_query($conn, $sqlCountInactivos);
    $filaCountInactivos = mysqli_fetch_assoc($resultadoCountInactivos);
    $totalInactivos = $filaCountInactivos['total_inactivos'];
    

    // Consulta SQL para obtener la fecha de ingreso de cada cliente
    $sqlFechaIngreso = "SELECT Cedula, Fecha_ingreso FROM cliente";
    $resultadoFechaIngreso = mysqli_query($conn, $sqlFechaIngreso);

    // Comparar la fecha de ingreso con la fecha actual y actualizar el estado si ha pasado más de un mes
    while ($fila = mysqli_fetch_assoc($resultadoFechaIngreso)) {
        $cedulaCliente = $fila['Cedula'];
        $fechaIngresoCliente = strtotime($fila['Fecha_ingreso']);
        $fechaActual = time();

        // Si ha pasado más de un mes desde la fecha de ingreso, cambiar el estado a inactivo
        if ($fechaActual - $fechaIngresoCliente > 30 * 24 * 60 * 60) {
            $sqlActualizarEstado = "UPDATE cliente SET Codigo_estado = 2 WHERE Cedula = '$cedulaCliente'";
            mysqli_query($conn, $sqlActualizarEstado);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Usuarios Inactivos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        h1 {
            color: #333;
            font-size: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
    </style>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
        // Incluir archivos de conexión y cliente
        include 'db/conexion.php';
        include 'cliente.php';
    ?>
    <div class="container">
        <br>
        <h1>Clientes Inactivos</h1>
        <br>
        <form action="inactivos.php" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar por cédula" name="cedula_busqueda" value="<?php echo isset($_GET['cedula_busqueda']) ? htmlspecialchars($_GET['cedula_busqueda']) : ''; ?>">
                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-search"></i> Buscar</button>
                <a href="inactivos.php" class="btn btn-secondary ms-2"><i class="fa-solid fa-eraser"></i> Limpiar</a>
            </div>
        </form>
        <?php
            // Iniciar sesión y obtener los parámetros de búsqueda
            session_start();
            $cedula_busqueda = isset($_GET["cedula_busqueda"]) ? htmlspecialchars($_GET["cedula_busqueda"]) : '';
            $usuario = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
            $codigo = '2';

            // Realizar la búsqueda de clientes inactivos según los parámetros proporcionados
            if ($cedula_busqueda && $usuario) {
                $sql_busqueda = "SELECT c.Cedula, c.Nombre, c.Apellido, c.Fecha_ingreso, c.Celular, pg.Nombre_plan, e.Estado 
                                    FROM cliente AS c 
                                    JOIN estado AS e ON c.Codigo_estado = e.Codigo_estado 
                                    JOIN planes_gym AS pg ON c.Codigo_plan = pg.Codigo_plan
                                    WHERE c.Cedula LIKE ? AND c.Usuario LIKE ? AND c.Codigo_estado LIKE ?";
                $stmt_busqueda = $conn->prepare($sql_busqueda);
                $like_cedula = "%$cedula_busqueda%";
                $like_usuario = "%$usuario%";
                $like_codigo = "%$codigo%";  // Asegúrate de que $codigo esté definido
                $stmt_busqueda->bind_param("sss", $like_cedula, $like_usuario, $like_codigo);
                $stmt_busqueda->execute();
                $resultado = $stmt_busqueda->get_result();
            
                // Mostrar resultados en una tabla
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
                while ($row = $resultado->fetch_assoc()) {
                    $cedula = htmlspecialchars($row['Cedula']);
                    $nombre = htmlspecialchars($row['Nombre']);
                    $apellido = htmlspecialchars($row['Apellido']);
                    $nombrePlan = htmlspecialchars($row['Nombre_plan']);
                    $celular = htmlspecialchars($row['Celular']);
                    $estado = htmlspecialchars($row['Estado']);
            
                    echo "<tr>
                        <td>$cedula</td>
                        <td>$nombre</td>
                        <td>$apellido</td>
                        <td>$nombrePlan</td>
                        <td>$celular</td>
                        <td>
                            <button class='btn btn-primary btn-pago' data-id='$cedula' data-bs-toggle='modal' data-bs-target='#modalPagoMensualidad'>Pagar mensualidad</button>
                        </td>
                    </tr>";

                }
                // Cerrar la tabla y agregar enlace para regresar al menú
                echo "</tbody></table>
                        <a href='menu.php'><i class='fa-solid fa-person-running'></i> Regresar</a>";
                $stmt_busqueda->close();
            
            } else {
                // Consultar clientes inactivos para el usuario actual
                $sql = "SELECT c.Cedula, c.Nombre, c.Apellido, c.Fecha_ingreso, c.Celular, pg.Nombre_plan, e.Estado 
                        FROM cliente AS c 
                        JOIN estado AS e ON c.Codigo_estado = e.Codigo_estado 
                        JOIN planes_gym AS pg ON c.Codigo_plan = pg.Codigo_plan
                        WHERE c.Usuario LIKE ? AND c.Codigo_estado LIKE ?";
            
                $stmt = $conn->prepare($sql);
                $like_usuario = "%$usuario%";
                $like_codigo = "%$codigo%";  // Asegúrate de que $codigo esté definido
                $stmt->bind_param("ss", $like_usuario, $like_codigo);
                $stmt->execute();
                $resultado = $stmt->get_result();
            
                // Mostrar resultados en una tabla
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
                while ($row = $resultado->fetch_assoc()) {
                    $cedula = htmlspecialchars($row['Cedula']);
                    $nombre = htmlspecialchars($row['Nombre']);
                    $apellido = htmlspecialchars($row['Apellido']);
                    $nombrePlan = htmlspecialchars($row['Nombre_plan']);
                    $celular = htmlspecialchars($row['Celular']);
                    $estado = htmlspecialchars($row['Estado']);
            
                    echo "<tr>
                        <td>$cedula</td>
                        <td>$nombre</td>
                        <td>$apellido</td>
                        <td>$nombrePlan</td>
                        <td>$celular</td>
                        <td>
                            <button class='btn btn-primary btn-pago' data-id='$cedula' data-bs-toggle='modal' data-bs-target='#modalPagoMensualidad'>Pagar mensualidad</button>
                        </td>
                    </tr>";
                }
                // Cerrar la tabla y agregar enlace para regresar al menú
                echo "</tbody></table>
                        <a href='menu.php'><i class='fa-solid fa-person-running'></i> Regresar</a>";
                $stmt->close();
            }
        ?>
    </div>
</body>
    <!-- Script para manejar eventos de clic en los botones de pago -->
    <script>
        $(document).ready(function () {
            $(".btn-pago").click(function () {
                var cedulaCliente = $(this).data("id");
                Swal.fire({
                    title: "¿El cliente ha pagado?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Sí",
                    cancelButtonText: "No",
                }).then(function (result) {
                    if (result.isConfirmed) {
                        // Redirigir a la página de procesamiento de pago
                        window.location.href = "procesar_pago.php?cedula=" + cedulaCliente;
                    }
                });
            });
        });
    </script>
</html>        