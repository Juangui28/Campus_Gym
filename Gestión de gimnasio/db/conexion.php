<?php
    error_reporting(0);

    define('HOST','localhost');
    define('USER','root');
    define('PASSWORD','');
    define('DB_NAME','campus_gym');

    try{
        $conn = mysqli_connect(HOST,USER,PASSWORD,DB_NAME);
    }catch(Exception $e){
        echo "Error: ".$e->getMessage();
    }
?>