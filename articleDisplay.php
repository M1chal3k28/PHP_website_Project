<?php include_once('scripts/functions.php'); ?>

<?php
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $articleId = null;
        if(isset($_GET["id"])) {
            $articleId = json_encode($_GET["id"]);
        }

        if($articleId == null) {
            echo '
                    <script>
                        alert("No article id given !");    
                    </script>

                    </body></html>
                 ';
            header("refresh:0 home.php");
            die();
            exit();
        }

        $query = "SELECT title, content FROM article WHERE articleId = $articleId LIMIT 1";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $title = $row["title"];
            $content = $row["content"];
        } else {
            echo '
                    <script>
                        alert("No article found !");    
                    </script>

                    </body></html>
                ';
            header("refresh:0 home.php");
            die();
            exit();
        }

        $rating = 0;
        $comment = 0;
        $ratingGiven = 0;
        $userId = $_SESSION["userId"];
        $query = "SELECT * FROM opinions WHERE articleId = $articleId AND userId = $userId LIMIT 1 ";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $linia = mysqli_fetch_assoc($result);

            $comment = $linia["content"];
            $rating = $linia["rating"];

            $ratingGiven = true;
        }
        // Ilosc komentarzy
        $sql = "SELECT COUNT(*) as ILOSC FROM opinions WHERE articleId = $articleId";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $linia = mysqli_fetch_assoc($result);
            $ratingsAmount = $linia["ILOSC"];
        }
        // Srednia
        $sql = "SELECT AVG(opinions.rating) as average
                FROM opinions 
                WHERE articleId = $articleId;";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $linia = mysqli_fetch_assoc($result);
            $averageRating = $linia["average"];

            if ($averageRating >= 0.5 && $averageRating < 1)
                $realAverageForStars = 0.5;
            else if($averageRating >= 1 && $averageRating < 1.5) 
                $realAverageForStars = 1;
            else if ($averageRating >= 1.5 && $averageRating < 2)
                $realAverageForStars = 1.5;
            else if ($averageRating >= 2 && $averageRating < 2.5) 
                $realAverageForStars = 2;
            else if ($averageRating >= 2.5 && $averageRating < 3) 
                $realAverageForStars = 2.5;
            else if ($averageRating >= 3 && $averageRating < 3.5)
                $realAverageForStars = 3;
            else if ($averageRating >= 3.5 && $averageRating < 4)
                $realAverageForStars = 3.5;
            else if ($averageRating >= 4 && $averageRating < 4.5)
                $realAverageForStars = 4;
            else if ($averageRating >= 4.5 && $averageRating < 5)
                $realAverageForStars = 4.5;
            else if ($averageRating == 5)
                $realAverageForStars = 5;
            else 
                $realAverageForStars = 0;
        }
        
        define("TO", 5); // Comments on page 
        $limit = ceil($ratingsAmount / 5 - 1);

        $page = 0;
        if(isset($_GET["page"])) {
            $page = intval($_GET["page"]) < 0 ? 0 : intval($_GET["page"]);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>
    </head>

    <body>
        <?php include("htmlParts/starterHeader.php"); ?>
            <main id="articleContainer" class="glassBg hidden m-4 p-4 bg-light border-lg shadow-lg w-75 mx-auto">
                <div id="articleBodyBg">
                    <div class="conatiner-fluid d-flex justify-content-center title">
                        <h1 class="d-flex"><?php echo $title; ?></h1>
                    </div>

                    <div id="displayedArticle" class="d-flex justify-content-center artfont">
                        <?php
                            echo $content;
                        ?>
                    </div>
                </div>
                <hr>
                <div id="CommentsContainer" class="d-flex">
                    <div id="RatingBoxContainer">
                        <div class="rating-box">
                            <header>Rate Article</header>
                            <div class="stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div id="CommentInput" class="mt-2 d-flex justify-content-center">
                                <a name="comm"></a>
                                <form class="form-grid" action="scripts/addComment.php" method="post">
                                    <textarea id="commentContent" name="comment" class="form-control" cols="30" rows="2"></textarea>
                                    <input id="submitButton" class="loginButton black mt-2" type="submit"
                                        <?php if($ratingGiven): ?>
                                            value = "Change"
                                        <?php else: ?>
                                            value = "Submit"
                                        <?php endif; ?>
                                    >

                                    <input type="number" name="articleId" value="<?php echo json_decode($articleId); ?>" style="display: none;">
                                    <input id="ratingValue" type="number" name="rating" required style="display: none;">
                                </form>
                            </div>
                        </div>
                        <div id="AllOpinions" class="container-fluid d-flex me-4 ">
                            <div class="rounded">
                                <div id="AverageRating" class="mb-2 d-flex justify-content-center">
                                    <h1 class="me-3">User Rating</h1>
                                    <div class="d-flex">
                                        <ul class="rating-score mb-0" data-rating="<?php echo $realAverageForStars; ?>">
                                            <li class="rating-score-item"></li>
                                            <li class="rating-score-item"></li>
                                            <li class="rating-score-item"></li>
                                            <li class="rating-score-item"></li>
                                            <li class="rating-score-item"></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <h5><?php echo number_format($averageRating,1); ?> average based on <?php echo $ratingsAmount; ?> reviews.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr width="100%" style="opacity:0;">

                    <div id="realComments">
                        <?php
                            if($page == 0) {
                                $sql = "SELECT * 
                                        FROM opinions, users, usersinfo 
                                        WHERE opinions.userId = usersinfo.UserId AND 
                                            users.UserId = usersinfo.UserId AND 
                                            opinions.articleId = $articleId AND opinions.userId = $userId;";

                                $result = mysqli_query($conn, $sql);

                                if(mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $username = $row["userName"];
                                    $commentRating = $row["rating"];
                                    $commentContent = $row["content"];
                                    $imageId = $row["ProfileImageId"];
                                    $date = explode(" ",$row["addDate"])[0];
                                    $edited = $row["isEdited"];
                                    $eCont = "";
                                    $userId = $row["userId"];
                                    
                                    if($edited == "1") {
                                        $eCont = "Edited";
                                    }

                                    echo '
                                            <div class="comment">
                                                <div class="d-flex p-0">
                                                    <div class="imageOfProfile"><img class="rounded-circle" src="img/ProfileImages/'.$imageId.'.jpg" alt="profImg" width="40" height="40"></div>
                                                    <div class="commentUserNameRating">
                                                        <h5 class="mb-0">'.strip_tags($username).'</h5>
                                                        <ul class="rating-score mb-1" data-rating="'.$commentRating.'">
                                                            <li class="rating-score-item rating-score-item2"></li>
                                                            <li class="rating-score-item rating-score-item2"></li>
                                                            <li class="rating-score-item rating-score-item2"></li>
                                                            <li class="rating-score-item rating-score-item2"></li>
                                                            <li class="rating-score-item rating-score-item2"></li>
                                                        </ul>
                                                        <h6>'.$date.'</h6>
                                                        <h6>'.$eCont.'</h6>
                                                    </div>
                                                    <div class="commentContent">'.htmlspecialchars($commentContent).'</div>
                                                    <div id="removeComment">
                                                        <form action = "scripts/removeComment.php" method="post">
                                                            <input type="number" name="artID" value='.$articleId.' style="display:none;"/>
                                                            <button class="removeButton" style="position:absolute; right:10px; top:10px;">
                                                                <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                fill="none"
                                                                viewBox="0 0 69 14"
                                                                class="svgIcon bin-top"
                                                                >
                                                                <g clip-path="url(#clip0_35_24)">
                                                                    <path
                                                                    fill="black"
                                                                    d="M20.8232 2.62734L19.9948 4.21304C19.8224 4.54309 19.4808 4.75 19.1085 4.75H4.92857C2.20246 4.75 0 6.87266 0 9.5C0 12.1273 2.20246 14.25 4.92857 14.25H64.0714C66.7975 14.25 69 12.1273 69 9.5C69 6.87266 66.7975 4.75 64.0714 4.75H49.8915C49.5192 4.75 49.1776 4.54309 49.0052 4.21305L48.1768 2.62734C47.3451 1.00938 45.6355 0 43.7719 0H25.2281C23.3645 0 21.6549 1.00938 20.8232 2.62734ZM64.0023 20.0648C64.0397 19.4882 63.5822 19 63.0044 19H5.99556C5.4178 19 4.96025 19.4882 4.99766 20.0648L8.19375 69.3203C8.44018 73.0758 11.6746 76 15.5712 76H53.4288C57.3254 76 60.5598 73.0758 60.8062 69.3203L64.0023 20.0648Z"
                                                                    ></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_35_24">
                                                                    <rect fill="white" height="14" width="69"></rect>
                                                                    </clipPath>
                                                                </defs>
                                                                </svg>
                                                            
                                                                <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                fill="none"
                                                                viewBox="0 0 69 57"
                                                                class="svgIcon bin-bottom"
                                                                >
                                                                <g clip-path="url(#clip0_35_22)">
                                                                    <path
                                                                    fill="black"
                                                                    d="M20.8232 -16.3727L19.9948 -14.787C19.8224 -14.4569 19.4808 -14.25 19.1085 -14.25H4.92857C2.20246 -14.25 0 -12.1273 0 -9.5C0 -6.8727 2.20246 -4.75 4.92857 -4.75H64.0714C66.7975 -4.75 69 -6.8727 69 -9.5C69 -12.1273 66.7975 -14.25 64.0714 -14.25H49.8915C49.5192 -14.25 49.1776 -14.4569 49.0052 -14.787L48.1768 -16.3727C47.3451 -17.9906 45.6355 -19 43.7719 -19H25.2281C23.3645 -19 21.6549 -17.9906 20.8232 -16.3727ZM64.0023 1.0648C64.0397 0.4882 63.5822 0 63.0044 0H5.99556C5.4178 0 4.96025 0.4882 4.99766 1.0648L8.19375 50.3203C8.44018 54.0758 11.6746 57 15.5712 57H53.4288C57.3254 57 60.5598 54.0758 60.8062 50.3203L64.0023 1.0648Z"
                                                                    ></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_35_22">
                                                                    <rect fill="white" height="57" width="69"></rect>
                                                                    </clipPath>
                                                                </defs>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                }
                            }


                            $sql = "SELECT * 
                                    FROM opinions, users, usersinfo 
                                    WHERE opinions.userId = usersinfo.UserId AND 
                                          users.UserId = usersinfo.UserId AND 
                                          opinions.articleId = $articleId AND opinions.userId != $userId LIMIT ". ($page*TO). ",". TO;

                            $result = mysqli_query($conn, $sql);
                                        
                            while($row = mysqli_fetch_assoc($result)) {
                                $username = $row["userName"];
                                $commentRating = $row["rating"];
                                $commentContent = $row["content"];
                                $imageId = $row["ProfileImageId"];
                                $date = explode(" ",$row["addDate"])[0];
                                $edited = $row["isEdited"];
                                $eCont = "";
                                $userId = $row["userId"];
                                
                                if($edited == "1") {
                                    $eCont = "Edited";
                                }

                                echo '
                                        <div class="comment">
                                            <div class="d-flex p-0">
                                                <div class="imageOfProfile"><img class="rounded-circle" src="img/ProfileImages/'.$imageId.'.jpg" alt="profImg" width="40" height="40"></div>
                                                <div class="commentUserNameRating">
                                                    <h5 class="mb-0">'.strip_tags($username).'</h5>
                                                    <ul class="rating-score mb-1" data-rating="'.$commentRating.'">
                                                        <li class="rating-score-item rating-score-item2"></li>
                                                        <li class="rating-score-item rating-score-item2"></li>
                                                        <li class="rating-score-item rating-score-item2"></li>
                                                        <li class="rating-score-item rating-score-item2"></li>
                                                        <li class="rating-score-item rating-score-item2"></li>
                                                    </ul>
                                                    <h6>'.$date.'</h6>
                                                    <h6>'.$eCont.'</h6>
                                                </div>
                                                <div class="commentContent">'.htmlspecialchars($commentContent).'</div>';
                                if($userId == $_SESSION["userId"]) {
                                    echo '
                                                <div id="removeComment">
                                                    <form action = "scripts/removeComment.php" method="post">
                                                        <input type="number" name="artID" value="'.$articleId.'" style="display:none;"/>
                                                        <button class="removeButton" style="position:absolute; right:10px; top:10px;">
                                                            <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 69 14"
                                                            class="svgIcon bin-top"
                                                            >
                                                            <g clip-path="url(#clip0_35_24)">
                                                                <path
                                                                fill="black"
                                                                d="M20.8232 2.62734L19.9948 4.21304C19.8224 4.54309 19.4808 4.75 19.1085 4.75H4.92857C2.20246 4.75 0 6.87266 0 9.5C0 12.1273 2.20246 14.25 4.92857 14.25H64.0714C66.7975 14.25 69 12.1273 69 9.5C69 6.87266 66.7975 4.75 64.0714 4.75H49.8915C49.5192 4.75 49.1776 4.54309 49.0052 4.21305L48.1768 2.62734C47.3451 1.00938 45.6355 0 43.7719 0H25.2281C23.3645 0 21.6549 1.00938 20.8232 2.62734ZM64.0023 20.0648C64.0397 19.4882 63.5822 19 63.0044 19H5.99556C5.4178 19 4.96025 19.4882 4.99766 20.0648L8.19375 69.3203C8.44018 73.0758 11.6746 76 15.5712 76H53.4288C57.3254 76 60.5598 73.0758 60.8062 69.3203L64.0023 20.0648Z"
                                                                ></path>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_35_24">
                                                                <rect fill="white" height="14" width="69"></rect>
                                                                </clipPath>
                                                            </defs>
                                                            </svg>
                                                        
                                                            <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 69 57"
                                                            class="svgIcon bin-bottom"
                                                            >
                                                            <g clip-path="url(#clip0_35_22)">
                                                                <path
                                                                fill="black"
                                                                d="M20.8232 -16.3727L19.9948 -14.787C19.8224 -14.4569 19.4808 -14.25 19.1085 -14.25H4.92857C2.20246 -14.25 0 -12.1273 0 -9.5C0 -6.8727 2.20246 -4.75 4.92857 -4.75H64.0714C66.7975 -4.75 69 -6.8727 69 -9.5C69 -12.1273 66.7975 -14.25 64.0714 -14.25H49.8915C49.5192 -14.25 49.1776 -14.4569 49.0052 -14.787L48.1768 -16.3727C47.3451 -17.9906 45.6355 -19 43.7719 -19H25.2281C23.3645 -19 21.6549 -17.9906 20.8232 -16.3727ZM64.0023 1.0648C64.0397 0.4882 63.5822 0 63.0044 0H5.99556C5.4178 0 4.96025 0.4882 4.99766 1.0648L8.19375 50.3203C8.44018 54.0758 11.6746 57 15.5712 57H53.4288C57.3254 57 60.5598 54.0758 60.8062 50.3203L64.0023 1.0648Z"
                                                                ></path>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_35_22">
                                                                <rect fill="white" height="57" width="69"></rect>
                                                                </clipPath>
                                                            </defs>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                         ';
                                }
                                echo '
                                            </div>
                                        </div>
                                     ';
                            }
                        ?>
                    </div>
                </div>

                <!--Pager-->
                <nav aria-label="..." class="mt-3 d-flex justify-content-center">
                    <ul class="pagination pagination-lg d-flex">
                        <li class="page-item m-2">
                            <a class="page-link loginButton paginationButton" <?php if($page != 0) echo 'href = "?id='.json_decode($articleId).'&page='.($page - 1 < 0 ? 0 : $page - 1).'#comm"'; ?> tabindex="-1">Previous</a>
                        </li>

                        <?php
                            if($page > 0) {
                                if($page > 1)
                                    echo '<li class="page-item m-2">
                                        <a class="page-link loginButton paginationButton" href="?id='.json_decode($articleId).'&page=0#comm">1</a>
                                    </li>';

                                echo '<li class="page-item m-2">
                                    <a class="page-link loginButton paginationButton" href="?id='.json_decode($articleId).'&page='.($page - 1).'#comm">'.$page.'</a>
                                </li>';
                            }

                            echo '<li class="page-item m-2 active">
                                <a class="page-link loginButton paginationButton">'.($page + 1).' <span class="sr-only">(current)</span></a>
                            </li>';

                            if($page < $limit) {
                                echo '<li class="page-item m-2">
                                    <a class="page-link loginButton paginationButton" href="?id='.json_decode($articleId).'&page='.($page + 1).'#comm">'.($page + 2).'</a>
                                </li>';
                                if($page + 1 < $limit)
                                echo '<li class="page-item m-2">
                                    <a class="page-link loginButton paginationButton" href="?id='.json_decode($articleId).'&page='.($limit).'#comm">'.($limit + 1).'</a>
                                </li>';
                            }
                            
                        ?>

                        <li class="page-item m-2">
                            <a class="page-link loginButton paginationButton" <?php if($page != $limit) echo 'href = "?id='.json_decode($articleId).'&page='.($page + 1 > $limit ? $limit : $page + 1).'#comm"'; ?> >Next</a>
                        </li>
                    </ul>
                </nav>
            </main>

        <?php include("htmlParts/footer.html")?>

        <script>
            // Operating remove Comment button
            let removeBtn = document.querySelector("#removeButton");

            // Select all elements with the "i" tag and store them in a NodeList called "stars"
            const stars = document.querySelectorAll(".stars i");
            const rating = document.querySelector("#ratingValue");
            const content = document.querySelector("#commentContent");
            const addCommentButton = document.querySelector("#submitButton");
            
            let ratingGiven = <?php echo $ratingGiven; ?>;
            if(ratingGiven == 1) {
                let userRating = <?php echo $rating; ?>;
                rating.value = userRating;
                content.value = <?php echo json_encode($comment); ?>;

                stars.forEach((star, index2) => {
                    userRating > index2 ? star.classList.add("active") : star.classList.remove("active");
                });
            }

            // Loop through the "stars" NodeList
            stars.forEach((star, index1) => {
            // Add an event listener that runs a function when the "click" event is triggered
                star.addEventListener("click", () => {
                    rating.value = index1 + 1;
                        // Loop through the "stars" NodeList Again
                    stars.forEach((star, index2) => {
                        // Add the "active" class to the clicked star and any stars with a lower index
                        // and remove the "active" class from any stars with a higher index
                            index1 >= index2 ? star.classList.add("active") : star.classList.remove("active");
                        });
                    });
            });

            addCommentButton.addEventListener('click', e => {
                e.click();
                location.reload();
            });

            window.addEventListener("load", () => {
                document.querySelector("#LoaderAnim").style.display = "none";
            });
        </script>
    </body>
</html>

<?php if(isset($conn)) { mysqli_close($conn); } ?>