<?php include('scripts/functions.php'); 
    if ($_SESSION["privileges"] == 0) {
        echo "<script> 
                alert('No permisions !');
              </script>";
        header('refresh:0 home.php');
        die;
    }

    $editing = 0;
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $editing = true;
        $articleToEdit = $_POST["idToEdit"];

        $sql = "SELECT * FROM article WHERE articleId = $articleToEdit";
        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($result);

        $articleContent = $row["content"];
        $articleTitle = $row["title"];
        $nextID = $articleToEdit;
        $nextImageId = $row["imgCount"];
        $nextVideoId = $row["vidCount"];
        $articleDesc = $row["partialContent"];

    } else {
        $query = "SELECT * FROM article ORDER BY articleId DESC LIMIT 1";
        $result = mysqli_query($conn, $query);

        @ $highestId = mysqli_fetch_assoc($result)["articleId"];
        @ $nextID = $highestId + 1;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Creator</title>
</head>
<body class="bg-light">
    <?php include_once('htmlParts/starterHeader.php'); ?>

    <main id="artCreatorMain" class="glassBg shadow-lg hidden d-flex justify-content-center m-4 p-1 bg-light shadow-lg w-50 mx-auto">
        <div class="creatorBg d-flex justify-content-center">
            <h1 class="logIn blackFont d-flex justify-content-center">Article Creator <?php if($editing) echo "(Editing)"; ?> </h1>
            <form class="form-grid" action="scripts/addArticle.php" method="post" enctype="multipart/form-data">
                <div class="inputbox inputboxBlack">
                    <ion-icon class="blackFont" name="pricetag"></ion-icon>
                    <input class= "blackFont"id="title" type="text" name="title" maxlength="45" required>
                    <label class="blackFont" for="title">Title <label>
                </div>
                
                <label class="creatorLabel">Describe Article </label> <br>
                <textarea id="description" class="blackFont form-control bg-transparent" type="text" name="partialContent" cols="100" rows="2" maxlength="200" required></textarea> <br>

                <!--Jezeli edytuje to ustawia sie nowa miniature-->
                <?php if(!$editing): ?>
                    <label class="creatorLabel">Thumbnail</label> <br>
                    <input class="form-control bg-transparent" type="file" name="file" required accept="image/png" onchange="previewImage();">
                        <br>
                <?php else :?>
                    <!--Flaga jezeli 1 to podczas zmiany wartosci artykulu miniatura zostanie zaktualizowana-->
                    <input type="number" id="thumbnailChanged" name="thumbnailChanged" value="0" style="display: none;">
                    <label class="creatorLabel">New Thumbnail</label> <br>
                    <input class="form-control bg-transparent" type="file" name="file" accept="image/png" onchange="previewImage();">
                        <br>
                <?php endif; ?>

                <label class="creatorLabel">Content</label> <br>
                <textarea class="form-control bg-transparent" id="content" name="content" cols="100" rows="10" required></textarea>
                <input class="mt-3 btn btn-primary" id="CreateArticleButton" type="submit" value="Create Article" style="display: none;">

                <input type="number" value="<?php echo $nextID; ?>" name="idArticle" style="display: none;">
                <input type="number" id="imageCounter" name="imageCounter" style="display: none;" value ="0">
                <input type="number" id="vidCounter"  name="vidCounter" style="display: none;" value ="0">
                <input type="number" name="wasEditing" value="<?php echo $editing; ?>" style="display: none;">
            </form>

            <div class="mt-3" id="panelCreatora">
                <button class="loginButton blackFont" id="showAddImagePanel">Add image</button>
                <button class="loginButton blackFont" id="showAddVideoPanel">Add video</button>
                <button class="loginButton blackFont" id="createArticleButtonTrigger">
                    <?php if($editing) echo "Update Article"; else echo "Create Article"; ?>
                </button>
            </div>
        </div>
    </main>
    
    <!--For Preview-->
        <section id="homeMainPrev" class="glassBg hidden m-4 bg-white shadow-lg mx-auto d-flex justify-content-center" style="width: 50% !important;">
            <div class="artPrev mb-0" style="width: 100% !important;">
                <div class="artImage rouded"><img class="articleImg img-fluid" id="preview" src="img/article/articleImages/<?php echo $nextID; ?>/logo-<?php echo $nextID; ?>.png"></div>
                <div class="articleTextContent">
                    <div class="artTitle"></div>
                    <div class="artPartial artPartialPrev"></div>
                    <div class="readMore"><button class="loginButton blackFont">Read More</button></div>
                </div>
            </div>
        </section>

        <section id="articleContainer" class="glassBg hidden m-4 p-4 bg-light border-lg shadow-lg w-75 mx-auto" style="margin-top: 50px !important;">
            <div id="articleBodyBg">
                <div class="conatiner-fluid d-flex justify-content-center title">
                    <h1><span id="titleOfCurrentArticle"></span></h1>
                </div>

                <div id="displayedArticle" class="d-flex justify-content-center artfont"> </div>
            </div>
        </section>
    <!--End-->

    <div id="AddImageForm" class="glassBg justify-content-center mt-3 blackFont">
        <button class="loginButton mb-3 blackFont" id="addImageTrigger">Add Image (file)</button>
        <button class="loginButton blackFont" id="hideAddImagePanel">Cancel</button>

        <form action="scripts/addGraphical.php" method="post" target="_blank" enctype="multipart/form-data">
            <button class="loginButton mt-3 blackFont" type="submit" id="confirmImageBtn" style="display:none;">Confirm Choice</button>
    
            <input type="file" name="file" id="addImg" style="display:none;" accept="image/png">
            <input type="number" value="<?php echo $nextID; ?>" name="idArticle" style="display: none;">
            <input type="number" id="ArticleImageNumber" name="idOfImage" value="0" style="display: none;">
        </form>
    </div>

    <div id="AddVideoForm" class="glassBg justify-content-center mt-3">
        <button class="loginButton mb-3 blackFont" id="addVideoTrigger">Add Video (File)</button>
        <button class="loginButton blackFont" id="hideAddVideoPanel">Cancel</button>

        <form action="scripts/addGraphical.php" method="post" target="_blank" enctype="multipart/form-data">
            <button class="loginButton mt-3 blackFont" type="submit" id="confirmVideoBtn" style="display:none;">Confirm Choice</button>
    
            <input type="file" name="file" id="addVideo" style="display:none;" accept=".mp4">
            <input type="number" value="<?php echo $nextID; ?>" name="idArticle" style="display: none;">
            <input type="number" id="ArticleVideoNumber" name="idOfVideo" value="0" style="display: none;">
        </form>
    </div>
    
    <script>
        function previewImage() {
            let boolThumbnail = document.querySelector("#thumbnailChanged");
            let previewBox = document.getElementById("preview");
            previewBox.src = URL.createObjectURL(event.target.files[0]);

            boolThumbnail.value = "1";
        }
    </script>

    <script>
        // For Preview
        let titleSpan = document.querySelector('#titleOfCurrentArticle');
        let title = document.querySelector('#title');
        let titleSmall = document.querySelector('.artTitle');
        
        let desc = document.querySelector('.artPartial');
        let descText = document.querySelector('#description');

        let contentDiv = document.querySelector('#displayedArticle');
        let contentText = document.querySelector('#content');

        [title, contentText, descText].forEach(e => {
            e.addEventListener('input', () => {
                contentDiv.innerHTML = contentText.value;
                titleSpan.innerHTML = title.value;
                titleSmall.innerHTML = title.value;
                desc.innerHTML = descText.value;
            });

            e.addEventListener('change', () => {
                contentDiv.innerHTML = contentText.value;
                titleSpan.innerHTML = title.value;
                titleSmall.innerHTML = title.value;
                desc.innerHTML = descText.value;
            });
        });

        const nextId = <?php echo $nextID; ?>; 
        let imageId = 0; 
        let videoId = 0;

        // For image Adding
        const imagePanel = document.querySelector("#AddImageForm");
        const addImageButtonTriger = document.querySelector("#addImageTrigger");
        const addImageButton = document.querySelector("#addImg");
        const showAddImagePanel = document.querySelector("#showAddImagePanel");
        const hideImagePanelButton = document.querySelector("#hideAddImagePanel");
        const confirmImageButton = document.querySelector("#confirmImageBtn");
        const numberOfImage = document.querySelector("#ArticleImageNumber");

        // For something 
        const content = document.querySelector("#content");
        const createArticleButton = document.querySelector("#CreateArticleButton");
        const triggerCreation = document.querySelector("#createArticleButtonTrigger");
        const vidCounter = document.querySelector("#vidCounter");
        const imgCounter = document.querySelector("#imageCounter");

        //For Video Adding
        const addVideoButton = document.querySelector("#addVideo");
        const addVideoButtonTriger = document.querySelector("#addVideoTrigger");
        const showAddVideoPanel = document.querySelector("#showAddVideoPanel");
        const videoPanel = document.querySelector("#AddVideoForm");
        const hideVideoPanelButton = document.querySelector("#hideAddVideoPanel");
        const confirmVideoButton = document.querySelector("#confirmVideoBtn");
        const numberOfVideos = document.querySelector("#ArticleVideoNumber");

        triggerCreation.addEventListener('click', e => {
            createArticleButton.click();
        });

        /* Adding image Functions */
            const addImage = async () => {
                let contentData = content.value;
                hideImagePanel();
                imageId++;
                numberOfImage.value = imageId;
                imgCounter.value = imageId;
                let nextPath = "img/article/articleImages/"+ nextId +"/image" + nextId + "-" + imageId + ".png";
                contentData += '<br><div class="conatiner-fluid d-flex justify-content-center"><img class="artimg" src="' + nextPath + '"/></div><br>';
                content.value = contentData;
                sleep(1000).then(() => {
                    contentDiv.innerHTML = contentText.value;
                });
            };

            const showImagePanel = () => {
                imagePanel.style.display = "flex";
                addImageButtonTriger.style.display = "block";
                confirmImageButton.style.display = "none";
                addImageButton.value = "";
            }

            const hideImagePanel = () => {
                imagePanel.style.display = "none";
            }
            

            addImageButtonTriger.addEventListener("click", e => {
                addImageButton.click();
            });

            showAddImagePanel.addEventListener("click", showImagePanel);
            hideImagePanelButton.addEventListener("click", hideImagePanel);
            confirmImageButton.addEventListener("click", addImage); 

            addImageButton.addEventListener("change", e => {
                if(addImageButton) {
                    confirmImageButton.style.display = "block";
                    addImageButtonTriger.style.display = "none";
                }
            });
        /* */
        
        /* Video adding */
            const addVideo = () => {
                let contentData = content.value;
                hideVideoPanel();
                videoId++;
                numberOfVideos.value = videoId;
                vidCounter.value = videoId;
                let nextPath = "vid/article/articleVids/"+ nextId +"/video" + nextId + "-" + videoId + ".mp4";
                contentData += '<br><div class="glassBg conatiner-fluid d-flex justify-content-center"><video class="artimg" controls><source src="'+ nextPath +'"/></video></div><br>';
                content.value = contentData;

                sleep(1000).then(() => {
                    contentDiv.innerHTML = contentText.value;
                });
            };

            const showVideoPanel = () => {
                videoPanel.style.display = "flex";
                addVideoButtonTriger.style.display = "block";
                confirmVideoButton.style.display = "none";
                addVideoButton.value = "";
            }

            const hideVideoPanel = () => {
                videoPanel.style.display = "none";
            }

            addVideoButtonTriger.addEventListener("click", e => {
                addVideoButton.click();
            });

            showAddVideoPanel.addEventListener("click", showVideoPanel);
            hideVideoPanelButton.addEventListener("click", hideVideoPanel);
            confirmVideoButton.addEventListener("click", addVideo); 

            addVideoButton.addEventListener("change", e => {
                if(addVideoButton) {
                    confirmVideoButton.style.display = "block";
                    addVideoButtonTriger.style.display = "none";
                }
            });
        /* */

        // Jeżeli edytuje wczytaj zawartosc artykulu
        <?php if($editing): ?>
            imageId = <?php echo $nextImageId; ?>;
            videoId = <?php echo $nextVideoId; ?>;
            imgCounter.value = imageId;
            vidCounter.value = vidCounter;

            content.value = <?php echo json_encode($articleContent); ?>;
            document.querySelector("#title").value = <?php echo json_encode($articleTitle); ?>;
            document.querySelector("#description").value = <?php echo json_encode($articleDesc); ?>;
            
            contentDiv.innerHTML = contentText.value;
            titleSmall.innerHTML = title.value;
            titleSpan.innerHTML = title.value;
            desc.innerHTML = descText.value;
        <?php endif; ?> 
    </script>
    <?php include("htmlParts/footer.html")?>
</body>
</html>