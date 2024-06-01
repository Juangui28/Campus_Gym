<?php
    session_start(); // Iniciar la sesión
    $usuario = ucfirst($_SESSION['username']);
    
    // Incluir la conexión a la base de datos
    include 'db/conexion.php';

    // Escapar la variable para usarla en la consulta SQL
    $usuarioEscapado = mysqli_real_escape_string($conn, $usuario);

    // Consulta para contar los usuarios inactivos
    $sqlInactivos = "SELECT COUNT(*) as count FROM cliente WHERE Codigo_estado = 2 AND Usuario = '$usuarioEscapado'";
    $resultInactivos = mysqli_query($conn, $sqlInactivos);
    $countInactivos = 0;
    if ($row = mysqli_fetch_assoc($resultInactivos)) {
        $countInactivos = $row['count'];
    }
?>  

<!DOCTYPE html>
<html>
<head>
    <title>Menú</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        .btn-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            justify-items: center;
            margin: 20px 0;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            margin: 5px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            width: 207px;
            position: relative;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn-exit {
            background-color: #f44336;
        }

        .btn-exit:hover {
            background-color: #d32f2f;
        }

        .notification {
            position: absolute;
            top: -10px;
            right: -10px;
            padding: 5px 10px;
            border-radius: 50%;
            background-color: red;
            color: white;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <img src="Fotos/pesas.png" alt="Imagen de perfil">
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario); ?>!</h1>
        <form method="GET" action="#">
            <div class="btn-grid">
                <?php
                    if ($usuario === 'Admin') {
                        echo '<button class="btn" type="submit" name="opcion" value="registro.php">Gestión de información de clientes</button>';
                        echo '<button class="btn" type="submit" name="opcion" value="editarEliminar.php">Modificación y eliminación de clientes</button>';
                        echo '<button class="btn" type="submit" name="opcion" value="calendario.php">Agenda</button>';
                        echo '<button class="btn" type="submit" name="opcion" value="inactivos.php">Clientes inactivos';
                        if ($countInactivos > 0) {
                            echo '<span class="notification">' . $countInactivos . '</span>';
                        }
                        echo '</button>';
                    }
                ?>
                <button class="btn btn-exit" type="submit" name="opcion" value="index.php">Salir</button>
            </div>
        </form>

        <?php
        if (isset($_GET['opcion'])) {
            $opcion = $_GET['opcion'];
            header("Location: $opcion");
            exit();
        }
        ?>
    </div>
</body>
</html>
