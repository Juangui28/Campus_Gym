<?php
    include 'db/conexion.php';

    // Obtener la fecha actual
    $fecha_actual = date('Y-m-d');

    // Verificar si se ha proporcionado la cédula del cliente
    if(isset($_GET['cedula'])) {
        $cedula = $_GET['cedula'];
        
        // Actualizar la fecha de ingreso del cliente en la base de datos
        $sql_update_fecha = "UPDATE cliente SET Fecha_ingreso = ? WHERE Cedula = ?";
        $stmt_update_fecha = mysqli_prepare($conn, $sql_update_fecha);
        mysqli_stmt_bind_param($stmt_update_fecha, "ss", $fecha_actual, $cedula);
        mysqli_stmt_execute($stmt_update_fecha);
        
        // Actualizar el estado del cliente de inactivo (código 2) a activo (código 1)
        $sql_update_estado = "UPDATE cliente SET Codigo_estado = 1 WHERE Cedula = ?";
        $stmt_update_estado = mysqli_prepare($conn, $sql_update_estado);
        mysqli_stmt_bind_param($stmt_update_estado, "s", $cedula);
        mysqli_stmt_execute($stmt_update_estado);

        header("Location: inactivos.php");
    } 
?>