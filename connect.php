<?php

    $serverName = "localhost";
    $userName = "root";
    $userPassword = "";
    $dbName = "noodle";

    try {
        $conn = new PDO("mysql:host=$serverName;dbname=$dbName;charset=UTF8", $userName, $userPassword);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ($conn){
            echo "Connected Complete!";
        }
    }catch (Exception $e) {
        echo "ERROR", $e;
    }


?>