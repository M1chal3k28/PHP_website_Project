<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $articleId = $_POST["idArticle"];
    $photoId = $_POST["idOfImage"];
    $videoId = $_POST["idOfVideo"];

    $file = $_FILES['file'];
    $fileName = $_FILES["file"]["name"];
    $fileTmpName = $_FILES["file"]["tmp_name"];
    $fileSize = $_FILES["file"]["size"];
    $fileError = $_FILES["file"]["error"];
    $fileType = $_FILES["file"]["type"];

    $fileExt = explode(".", $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('png','jpeg','jpg','mp4');

    if(in_array($fileActualExt, $allowed)) {
        if($fileError === 0) {
            if($fileSize < 100000000) {
                if($fileActualExt == "mp4") {
                    //Stworz folder dla id jesli nie istnieje
                    if(!file_exists("../vid/article/articleVids/$articleId"))
                        mkdir("../vid/article/articleVids/$articleId");

                    $newFileName = "video". $articleId. "-". $videoId. ".mp4";
                    $fileDestination = "../vid/article/articleVids/".$articleId."/". $newFileName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                } else {
                    //Stworz folder dla id jesli nie istnieje
                    if(!file_exists("../img/article/articleImages/$articleId"))
                        mkdir("../img/article/articleImages/$articleId");

                    $newFileName = "image". $articleId. "-". $photoId. ".png";
                    $fileDestination = "../img/article/articleImages/".$articleId."/". $newFileName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                }
            } else {
                echo "File is to big !";
            }
        } else {
            echo "Error while uploading file !!";
        }
    } else {
        echo "You cannot upload file with this extension !";
    }

    // Zamknięcie połączenia z bazą danych
    if(isset($conn)) { 
        mysqli_close($conn); 
    }
    
    echo "<script>window.close();</script>";
}?>