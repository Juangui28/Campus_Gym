<?php
    include "db/conexion.php";
    session_start(); // Iniciar la sesión

    if (isset($_POST["iniciar"])) {

        $usuario = strtolower($_POST["username"]);
        $contrasena = strtolower($_POST["password"]);

        $sql = "SELECT * FROM usuario WHERE Usuario = ? AND Contraseña = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $usuario, $contrasena);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            $_SESSION['username'] = $usuario;
            $_SESSION['show_alert'] = true; // Variable de sesión para mostrar la alerta
            header("location: menu.php");
            exit();
        } else {
            $error = "Usuario y/o contraseña incorrectos";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            height: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }
        .login-container img {
            width: 170px;
            height: 170px;
            margin-top: -85px;
            border-radius: 50%;
            margin-bottom: 0px
        }
        .login-container h2 {
            margin-top: 40px;
            margin-bottom: 40px;
        }
        .login-container input[type="text"], .login-container input[type="password"] {
            width: 85%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
        }
    </style>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="login-container">
        <img src="profile.png" alt="Imagen de perfil">
        <h2>Iniciar Sesión</h2>
        <form action="index.php" method="post">
            <label for="username">Nombre de Usuario</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Iniciar Sesión" name="iniciar">
        </form>
        <?php if(isset($error)) { echo '<p class="error">' . $error . '</p>'; } ?>
    </div>
</body>
</html>
