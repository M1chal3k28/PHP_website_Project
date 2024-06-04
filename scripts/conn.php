<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "database";

    try {
        $conn = mysqli_connect($db_server, 
                           $db_user, 
                           $db_pass, 
                           $db_name);
        mysqli_set_charset($conn, "utf8");
    } catch(mysqli_sql_exception $e) {
        echo"Error | Can't connect to the database! <br>";
        $conn = null;
    }
?>