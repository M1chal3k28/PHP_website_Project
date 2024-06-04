<?php
    include_once("functions.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_SESSION["privileges"] == 1) {
            $articleId = $_POST["idToDelete"];

            $deleteArticleOpinions = "DELETE FROM opinions WHERE articleId = $articleId";
            $deleteArticle = "DELETE FROM ARTICLE WHERE articleId = $articleId";

            @array_map('unlink', glob("../img/article/articleImages/$articleId/*.png"));
            @array_map('unlink', glob("../vid/article/articleVids/$articleId/*.mp4"));
            @rmdir("../img/article/articleImages/$articleId");
            @rmdir("../vid/article/articleVids/$articleId");

            mysqli_query($conn, $deleteArticleOpinions);
            mysqli_query($conn, $deleteArticle);
        }
    }
    
    // Zamknięcie połączenia z bazą danych
    if(isset($conn)) { 
        mysqli_close($conn); 
    }

    header("refresh:0 ../home.php");
?>