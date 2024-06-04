<?php
    include_once('functions.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_SESSION["username"])) {
            $userId = $_SESSION["userId"];
            $artId = $_POST["artID"];

            $sql = "DELETE FROM opinions WHERE userId = $userId AND articleId = $artId";
            mysqli_query($conn, $sql);

            header("refresh:0 ../articleDisplay.php?id=$artId#comm");
        }
    }

    // Zamknięcie połączenia z bazą danych
    if(isset($conn)) { 
        mysqli_close($conn); 
    }

    echo "<script>window.close();</script>";
?>