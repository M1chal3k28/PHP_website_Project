<?php include('scripts/functions.php'); ?>

<?php
    $userExists = false;
    $passTheSame = true;
    $emailEmpty = false;
    $emailExist = false;
    $tooYoung = false;
    $tooOld = false;

    $username = null;
    $pass = null;
    $reapetedPass = null;
    $name = null;
    $surname = null;
    $email = null;
    $message = null;

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST["username"])) {
            $username = filter_input(INPUT_POST, 
                                     'username', 
                                     FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["password"])) {
            $pass = filter_input(INPUT_POST,
                                 'password',
                                 FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["name"])) {
            $name = filter_input(INPUT_POST,
                                 'name',
                                 FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["surname"])) {
            $surname = filter_input(INPUT_POST,
                                    'surname',
                                    FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["email"])) {
            $email = filter_input(INPUT_POST,
                                 'email',
                                 FILTER_VALIDATE_EMAIL);
        }

        if(isset($_POST["reapetedPass"])) { 
            $reapetedPass = filter_input(INPUT_POST,
                                         'reapetedPass',
                                         FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        $emailEmpty = empty($email);
        $emailExist = emailForExist($conn, $email);
        $userExists = userForExist($conn, $username);
        $passTheSame = ($pass == $reapetedPass );

        if($passTheSame &&
           !$emailEmpty &&
           !$userExists &&
           !$emailExist) 
           { 
                createUser($conn, 
                           $username, 
                           $pass, 
                           $email,
                           $name,
                           $surname); 
            } 
    }
?>  

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script defer src="app.js"></script>
        <title>Register your account</title>
    </head>

    <body class="bg-light">
        <?php include_once('htmlParts/starterHeader.php'); ?>
        <main class="logBg hidden m-4 p-4 rounded shadow-lg mx-auto">
            <h2 class="text-center mb-4 logIn">Register your account</h2>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="inputbox">
                    <ion-icon name="contact"></ion-icon>
                    <input type="text" name="username" required maxlength="11">
                    <label for="username" >Username</label>
                    <span class="form-text text-danger"><?php if($userExists) : ?>Username already taken ! 
                                            <?php endif; ?></span>
                </div>

                <div class="inputbox">
                    <ion-icon name="lock"></ion-icon>
                    <input type="password" name="password" required maxlength="50">
                    <label for="password" >Password</label>
                </div>

                <div class="inputbox">
                    <ion-icon name="lock"></ion-icon>
                    <input type="password" name="reapetedPass" required maxlength="50">
                    <label for="reapetedPass" >Repeat Password</label>
                    <span class="form-text text-danger"><?php if(!$passTheSame) : ?> Passwords don't match ! <br> 
                                            <?php endif; ?></span>
                </div>

                <div class="inputbox">
                    <ion-icon name="person"></ion-icon>
                    <input type="text" name="name" required maxlength="50">
                    <label for="name" >Real Name</label>
                </div>

                <div class="inputbox">
                    <ion-icon name="people"></ion-icon>
                    <input type="text" name="surname" required maxlength="50">
                    <label for="surname" >Surname</label>
                </div>

                <div class="inputbox">
                    <ion-icon name="mail"></ion-icon>
                    <input type="text" name="email" required maxlength="70">
                    <label for="email">Email</label>
                    <span class="form-text text-danger"><?php if($emailEmpty) : ?> Your email isn't valid ! <br> 
                                            <?php elseif($emailExist) : ?> Email already taken ! <br>
                                            <?php endif; ?></span>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" name="login" class="loginButton">Let's go</button>
                </div>
            </form>
        </main>
        <div id="fade2"></div>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
    </body>
</html>

<?php if(isset($conn)) { mysqli_close($conn); } ?>