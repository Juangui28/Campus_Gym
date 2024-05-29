<?php
    session_start(); // Iniciar la sesión
    $usuario = $_SESSION['username'];
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
    </style>
</head>
<body>
    <img src="pesas.png" alt="Imagen de perfil">
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario); ?>!</h1>
        <form method="GET" action="#">
            <div class="btn-grid">
                <button class="btn" type="submit" name="opcion" value="registro.php">Gestión de información de clientes</button>
                <button class="btn" type="submit" name="opcion" value="editarEliminar.php">Modificación y eliminación de clientes</button>
                <button class="btn" type="submit" name="opcion" value="calendario.php">Agenda</button>
                <button class="btn" type="submit" name="opcion" value="inactivos.php">Clientes inactivos</button>
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
