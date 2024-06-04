<?php include('scripts/functions.php'); ?>

<?php
    $message = "";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $message = "error";
        $username = htmlspecialchars($_POST["username"]);
        $realName = htmlspecialchars($_POST["name"]);
        $surname = htmlspecialchars($_POST["surname"]);
        $email = htmlspecialchars($_POST["email"]);
        $id = $_SESSION['userId'];
        $imageId = $_POST["imageId"];
    
        try {
            $sqlUsername = "SELECT * FROM users WHERE userName = ?";
            $sqlEmail = "SELECT * FROM usersInfo WHERE email = ?";
    
            $stmtUsername = mysqli_prepare($conn, $sqlUsername);
            $stmtEmail = mysqli_prepare($conn, $sqlEmail);
    
            mysqli_stmt_bind_param($stmtUsername, "s", $username);
            mysqli_stmt_bind_param($stmtEmail, "s", $email);
    
            mysqli_stmt_execute($stmtUsername);
            $resultUsername = mysqli_stmt_get_result($stmtUsername);
            mysqli_stmt_free_result($stmtUsername);

            mysqli_stmt_execute($stmtEmail);
            $resultEmail = mysqli_stmt_get_result($stmtEmail);
            mysqli_stmt_free_result($stmtEmail);
    
            if(mysqli_num_rows($resultUsername) <= 0 || $username == $_SESSION["username"]) {
                if(mysqli_num_rows($resultEmail) <= 0 || $email == $_SESSION["email"]) {
                    $sql = "UPDATE usersInfo 
                            INNER JOIN users ON usersInfo.userId = users.userId
                            SET users.userName = ?,
                                usersInfo.realName = ?,
                                usersInfo.surname = ?,
                                usersInfo.email = ?,
                                usersInfo.ProfileImageId = ?
                            WHERE users.userId = ?";
    
                    $stmtUpdate = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmtUpdate, "ssssii", $username, $realName, $surname, $email, $imageId, $id);
                    mysqli_stmt_execute($stmtUpdate);
    
                    $_SESSION["username"] = $username;
                    $_SESSION["realName"] = $realName;
                    $_SESSION["surname"] = $surname;
                    $_SESSION["email"] = $email;
                    $_SESSION["imageId"] = $imageId;
    
                    $message = "success";
                } else {
                    $message = "email";
                }
            } else {
                $message = "username";
            }
        } catch (mysqli_sql_exception $e) { 
            echo "Error on database: " . $e->getMessage(); 
        }
        // Przekierowanie tylko po pomyślnym wykonaniu zapytania POST
        if($message == "success") {
            header('refresh:0');
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php if(isset($_SESSION["username"])) { echo $_SESSION["username"]; } ?> profile </title>
    </head>

    <body class="bg-light">
        <?php include_once('htmlParts/starterHeader.php'); ?>
        <!--For profile image change-->
        <section class="hidden glassBg rounded mx-auto" id="ChangeProfileImage">
            <button id="PrzyciskWylaczajacyMenuProfile" class="ChangeProfileImage-exit loginButton"><i class="fas fa-x"></i></button>
            <h3 class="logIn">Select image</h3>
            <br>
            <?php
                echo "<div style='float:left;'>";
                    for($i = 1; $i < 10; $i++) {
                        echo "<button class='loginButton mx-1 mb-1' onclick='setProfileImage($i)'><img src='img/ProfileImages/$i.jpg' class='imageForProfile' alt='profImg' width='120' height='80'></button>";
                        if ($i != 0 && $i % 3 == 0) {
                            echo "<div style='clear:both;'></div></div>";
                            echo "<div style='float:left;'>";
                        }
                    }
            ?>
        </section>

        <main id="changeProfileMain" class="glassBg hidden m-4 p-1 bg-light shadow-lg mx-auto">
            <form class="profileEditorBg p-3 blackFont" name="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="number" id="imageId" name="imageId" value="<?php echo $_SESSION['imageId']; ?>" style="display:none;">

                <script>
                    let imageId = document.querySelector("#imageId");
                    let currentImage = imageId.value;

                    document.write(`<img id="editorImg" src="img/ProfileImages/${currentImage}.jpg" class="mb-4" alt="profImg" width="100" height="70">`) 
                </script>
                <button class="loginButton blackFont" id="ChangeBtn" type="button">Change Image</button>

                <section>
                    <div class="inputbox mb-3 inputboxBlack">
                        <ion-icon class="blackFont" name="person-outline"></ion-icon>
                        <input type="text" id="username" class="blackFont" name="username" required value="0" maxlength="11">
                        <label for="username" class="blackFont">Username</label>
                    </div>

                    <div class="inputbox mb-3 inputboxBlack">
                        <ion-icon class="blackFont" name="mail-outline"></ion-icon>   
                        <input type="text" id="email" class="blackFont" name="email" required value="<?php echo htmlspecialchars($_SESSION["email"]); ?>" maxlength="70">
                        <label for="email" class="blackFont">Email</label>
                    </div>
                    
                    <div class="inputbox mb-3 inputboxBlack">
                        <ion-icon class="blackFont" name="happy-outline"></ion-icon>
                        <input type="text" class="blackFont" id="name" name="name" required value="<?php echo htmlspecialchars($_SESSION["realName"]); ?>" maxlength="50">
                        <label for="name" class="blackFont">Real Name</label>
                    </div>

                    <div class="inputbox mb-3 inputboxBlack">
                        <ion-icon class="blackFont" name="happy-outline"></ion-icon>
                        <input type="text" class="blackFont" id="surname" name="surname" required value="<?php echo htmlspecialchars($_SESSION["surname"]); ?>" maxlength="50"> 
                        <label for="surname" class="blackFont">Surname</label>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" name="save" id="save" class="loginButton blackFont" style="display:none;">Save Changes</button>
                    </div>
                </section>
            </form>
        </main>

        <section id="secDeleteAcc" class="glassBg hidden">
            <form class="mb-0" action="accDeleteButton.php" method="post">
                <button class="menuDeleteAccount">
                    <svg viewBox="0 0 448 512" class="svgIcon"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path></svg>
                </button>
            </form>
        </section>

        <script>
            let saveButton = document.querySelector('#save');
            let usernameInput = document.querySelector('#username');
            let emailInput = document.querySelector('#email');
            let nameInput = document.querySelector('#name');
            let surnameInput = document.querySelector('#surname');

            let name = <?php echo json_encode($_SESSION["realName"]); ?>;
            let username = <?php echo json_encode($_SESSION["username"]); ?>;
            let email = <?php echo json_encode($_SESSION["email"]); ?>;
            let surname = <?php echo json_encode($_SESSION["surname"]); ?>;
            let userProfileImage = <?php echo json_encode($_SESSION["imageId"]); ?>;

            usernameInput.value = <?php echo json_encode(htmlspecialchars_decode($_SESSION["username"])); ?>;

            [usernameInput, emailInput, nameInput, surnameInput, imageId].forEach( e => {
                e.addEventListener("input", () => {
                    if(name != nameInput.value         ||
                       username != usernameInput.value ||
                       email != emailInput.value       ||
                       surname != surnameInput.value) { saveButton.style.display = "block"; } 
                                                else { saveButton.style.display = "none"; }
                });
            });
        </script>

        <script src="scripts/profile.js"> </script>
        
        <?php include('htmlParts/footer.html'); ?>
    </body>
</html>

<?php if(isset($conn)) { mysqli_close($conn); } ?>