<?php
    // Incluye el archivo que contiene la conexión a la base de datos
    include 'db/conexion.php';

    // Inicializa un array para almacenar la respuesta
    $response = array();

    // Verifica si el método de la solicitud es POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtiene los valores enviados por POST y los almacena en variables
        $titulo = $_POST["titulo"];
        $descripcion = $_POST["descripcion"];
        $fecha = $_POST["fecha"];
        $hora = $_POST["hora"];

        // Prepara la consulta SQL para insertar un nuevo recordatorio en la base de datos
        $sql = "INSERT INTO recordatorios (titulo, descripcion, fecha, hora) VALUES ('$titulo', '$descripcion', '$fecha', '$hora')";

        // Ejecuta la consulta y verifica si se realizó con éxito
        if ($conn->query($sql) === TRUE) {
            // Si la consulta fue exitosa, actualiza la respuesta con un mensaje de éxito
            $response['success'] = true;
            $response['message'] = "Nuevo recordatorio agregado exitosamente";
        } else {
            // Si la consulta falló, actualiza la respuesta con un mensaje de error
            $response['success'] = false;
            $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Cierra la conexión a la base de datos
    $conn->close();

    // Convierte el array de respuesta a formato JSON y lo imprime
    echo json_encode($response);
?>
