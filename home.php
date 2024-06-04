<?php include("scripts/functions.php"); ?>
<?php include('htmlParts/starterHeader.php'); ?>

<?php
    define("TO", 5);
    $page = 0;
    if(isset($_GET["page"])) {
        $page = intval($_GET["page"]) < 0 ? 0 : intval($_GET["page"]);
    }
    $from = $page*TO;
    $query = "SELECT * FROM article LIMIT $from,".TO;

    $phrase = "";
    if(isset($_GET["searching"]) && !empty($_GET["searching"])) {
        $phrase = $conn->real_escape_string($_GET["searching"]);
        $query = "SELECT * FROM article WHERE title LIKE '%$phrase%' LIMIT $from,".TO;
    }

    $sql = "SELECT COUNT(*) as c FROM article WHERE title LIKE '%$phrase%'";
    $result = mysqli_query($conn, $sql);
    $posLim = ceil(mysqli_fetch_assoc($result)["c"] / 5 - 1);
    $limit = $posLim < 0 ? 0 : $posLim;

    $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>

<body class="bg-light">
    <main id="homeMain" class="glassBg hidden m-4 mx-auto shadow-lg d-flex justify-content-center">
        <?php if(isset($phrase) && !empty($phrase)): ?>
            <div class="searchingResultsTitle title"><h1>Searching results for "<?php echo $phrase; ?>"</h1></div>
        <?php endif; ?>
        <?php
            $i=0;
            
            while($row = mysqli_fetch_assoc($result)) {
                $id = $row["articleId"];
                $title = $row["title"];
                $content = $row["partialContent"];
                
                if($i%2==0) 
                    echo '<div class="row">';

                echo '
                        <div class="art">
                            <div class="artImage rouded"><img class="articleImg img-fluid" src="img/article/articleImages/'.$id.'/logo-'.$id.'.png"></div>
                            <div class="articleTextContent">
                                <div class="artTitle">'.$title.'</div>
                                <div class="artPartial">'.$content.'</div>
                                <div class="readMore"><button onclick="location.href=`articleDisplay.php?id='.$id.'`" class="loginButton blackFont">Read More</button></div>
                     ';
                if($_SESSION["privileges"] == 1) {
                    echo '
                                <div class="d-flex">
                                    <button onclick="editArticle('.$id.');" class="action-button m-2 edit">
                                        <svg class="action-svgIcon" viewBox="0 0 512 512">
                                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                                        </svg>
                                    </button>

                                    <button onclick="deleteArticle('.$id.');" class="action-button m-2 delete">
                                            <svg class="action-svgIcon" viewBox="0 0 448 512">
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                                            </svg>
                                    </button>

                                    <form style="display:none;" action="scripts/deleteArticle.php" method="post"> 
                                        <input type="number" name="idToDelete" value="'.$id.'">
                                        <button id="delete'.$id.'" type="submit"> </button>
                                    </form>

                                    <form style="display:none;" action="articleCreator.php" method="post">
                                        <input type="number" name="idToEdit" value="'.$id.'">
                                        <button id="edit'.$id.'" type="submit"> </button>
                                    </form>
                                </div>  
                        ';
                }
                echo '
                            </div>
                        </div>
                     ';
                $i++;

                if($i%2==0) 
                    echo '</div>'; // Closes div with class row !
            }
        ?> 

        <!--Pager-->
        <nav aria-label="..." class="mt-3 d-flex justify-content-center">
            <ul class="pagination pagination-lg d-flex">
                <li class="page-item m-2">
                    <a class="page-link loginButton paginationButton" <?php if($page != 0) echo 'href = "?searching='.$phrase.'&page='.($page - 1 < 0 ? 0 : $page - 1).'"'; ?> tabindex="-1">Previous</a>
                </li>

                <?php
                    if($page > 0) echo '<li class="page-item m-2">
                        <a class="page-link loginButton paginationButton" href="?searching='.$phrase.'&page='.($page - 1).'">'.$page.'</a>
                    </li>';

                    echo '<li class="page-item m-2 active">
                        <a class="page-link loginButton paginationButton">'.($page + 1).' <span class="sr-only">(current)</span></a>
                    </li>';

                    if($page < $limit) echo '<li class="page-item m-2">
                        <a class="page-link loginButton paginationButton" href="?searching='.$phrase.'&page='.($page + 1).'">'.($page + 2).'</a>
                    </li>';
                ?>

                <li class="page-item m-2">
                    <a class="page-link loginButton paginationButton" <?php if($page != $limit) echo 'href = "home.php?searching='.$phrase.'&page='.($page + 1 > $limit ? $limit : $page + 1).'"'; ?> >Next</a>
                </li>
            </ul>
        </nav>
    </main>

    <?php include('htmlParts/footer.html'); ?>
    <script> 
        const deleteArticle = (id) => {
            let sure = confirm("Do you want to delete article with id " + id);
            if(sure === true) {
                let button = document.querySelector('#delete' + id);
                button.click();
            }
        };

        const editArticle = (id) => {
            let button = document.querySelector("#edit" + id);
            button.click();
        }
    </script>
</body>
</html>

<?php if(isset($conn)) { mysqli_close($conn); } ?>