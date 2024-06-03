<?php
    // Desactiva la notificación de errores.
    error_reporting(0);

    // Define la constante 'HOST' con el valor 'localhost'.
    define('HOST','localhost');
    // Define la constante 'USER' con el valor 'root'.
    define('USER','root');
    // Define la constante 'PASSWORD' con un valor vacío.
    define('PASSWORD','');
    // Define la constante 'DB_NAME' con el valor 'gimnasio_bd'.
    define('DB_NAME','gimnasio_bd');

    // Inicia un bloque try para manejar excepciones.
    try{
        // Intenta establecer una conexión a la base de datos usando las constantes definidas.
        $conn = mysqli_connect(HOST,USER,PASSWORD,DB_NAME);
    // Captura cualquier excepción que ocurra durante el intento de conexión.
    }catch(Exception $e){
        // Imprime el mensaje de error si ocurre una excepción.
        echo "Error: ".$e->getMessage();
    }
?>