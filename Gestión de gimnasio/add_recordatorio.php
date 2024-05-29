<?php
    include 'db/conexion.php';

    $response = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titulo = $_POST["titulo"];
        $descripcion = $_POST["descripcion"];
        $fecha = $_POST["fecha"];
        $hora = $_POST["hora"];

        $sql = "INSERT INTO recordatorios (titulo, descripcion, fecha, hora) VALUES ('$titulo', '$descripcion', '$fecha', '$hora')";

        if ($conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Nuevo recordatorio agregado exitosamente";
        } else {
            $response['success'] = false;
            $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();

    echo json_encode($response);
?>
