<?php
include_once("functions.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $content = $_POST["content"];
        $title = $_POST["title"];
        $articleId = $_POST["idArticle"];
        $partialContent = $_POST["partialContent"];
        $vidCounter = $_POST["vidCounter"];
        $imgCounter = $_POST["imageCounter"];
        $wasEditing = $_POST["wasEditing"];
        $thumbnailChanged = $_POST["thumbnailChanged"] ?? 0;

        if($wasEditing == 0 || $thumbnailChanged == 1) {
            $file = $_FILES['file'];
            $fileName = $_FILES["file"]["name"];
            $fileTmpName = $_FILES["file"]["tmp_name"];
            $fileSize = $_FILES["file"]["size"];
            $fileError = $_FILES["file"]["error"];
            $fileType = $_FILES["file"]["type"];

            $fileExt = explode(".", $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('png','jpeg','jpg');

            if(in_array($fileActualExt, $allowed)) {
                if($fileError === 0) {
                    if($fileSize < 100000000) {
                        $newFileName = "logo-". $articleId. ".png";

                        if(!file_exists("../img/article/articleImages/$articleId"))
                            mkdir("../img/article/articleImages/$articleId");

                        $fileDestination = "../img/article/articleImages/$articleId/". $newFileName;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        
                        if($wasEditing == 0) {
                            $query = "INSERT INTO article(articleId, title, content, partialContent, imgCount, vidCount) VALUES (?, ?, ?, ?, ?, ?)";
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_bind_param($stmt, "isssii", $articleId, $title, $content, $partialContent, $imgCounter, $vidCounter);
                            mysqli_stmt_execute($stmt);
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
        }

        if($wasEditing == 0) {
            if(isset($conn)) { mysqli_close($conn); }
            header("refresh:0 ../home.php");
            die();
        } // Exit when no change done

        $sql = "UPDATE article SET title = ?, content = ?, partialContent = ?, imgCount = ?, vidCount = ? WHERE articleId = $articleId";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssii", $title, $content, $partialContent, $imgCounter, $vidCounter);
        mysqli_stmt_execute($stmt);
    
    }

if(isset($conn)) { mysqli_close($conn); }
header("refresh:0 ../home.php");
die();
?>