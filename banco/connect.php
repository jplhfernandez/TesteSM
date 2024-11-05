<?php
    $host = "localhost";
    $database = "smlocacoesdb";//banco
    $user = "root";
    $pass = "";//senha
    $charset = "utf8";//tecla
    $port = "3306";//porta

    try{
        $conn = new mysqli($host, $user, $pass, $database, $port);
        mysqli_set_charset($conn, $charset);
    }
    catch (Throwable $th){
        die("Atenção rolou um ERRO".$th);
    }