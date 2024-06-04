<?php 
    include_once('functions.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_SESSION["userId"])) {
            $userId = $_SESSION["userId"];
            $articleId = $_POST["articleId"]; 
            $content = $_POST["comment"];
            $rating = $_POST["rating"];

            try {
                $sql = "SELECT * FROM opinions WHERE userId = ? AND articleId = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ii", $userId, $articleId);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                
                if(mysqli_num_rows($result) <= 0) {
                    $sql = "INSERT INTO opinions (opinionId, articleId, userId, content, rating) VALUES (NULL, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "iisi", $articleId, $userId, $content, $rating);
                    mysqli_stmt_execute($stmt);
                } else {
                    $sql = "UPDATE opinions SET content = ?, rating = ?, isEdited = 1 WHERE articleId = ? AND userId = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "siii", $content, $rating, $articleId, $userId);
                    mysqli_stmt_execute($stmt);
                }

                header("refresh:0 ../articleDisplay.php?id=$articleId#comm");
            } catch(mysqli_sql_exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo "Użytkownik nie jest zalogowany.";
        }
    }

    // Zamknięcie połączenia z bazą danych
    if(isset($conn)) { 
        mysqli_close($conn); 
    }

    echo '
            <script>window.close();</script>
         ';
?>
