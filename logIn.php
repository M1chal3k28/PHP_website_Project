<?php include_once('scripts/functions.php')?>

<!DOCTYPE html>
<html lang="en">
<script defer src="app.js"></script>
<head>
    <meta charset="UTF-8">
    <?php

        if (isset($_SESSION["username"])) {
            session_destroy();
            setcookie("SES", '', time() - 1, "/");
            header("refresh:0");
        }


        $inputEmpty = false;
        $userExists = true;
        $passEmpty = false;
        $passOk = true;

        if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
            $input = null;
            $pass = null;

            if(isset($_POST["username"])) {
                $input = filter_input(INPUT_POST,
                                     'username',
                                     FILTER_SANITIZE_SPECIAL_CHARS);
            }

            if(isset($_POST["password"])) {
                $pass = filter_input(INPUT_POST,
                                     'password',
                                     FILTER_SANITIZE_SPECIAL_CHARS);
            }

            if(isset($_POST["rememberMe"])) {
                $remember = true;
            } else { $remember = false; }

            $inputEmpty = empty($input);
            $passEmpty = empty($pass);
            
            $AccountPass = ($userExists = userForExist($conn, $input));
            $passOk = checkPass($conn, $pass, $AccountPass);
            
            if($userExists && $passOk) {
                $location = "scripts/SessionLogin.php?input=".urlencode($input)."&pass=$pass&remember=$remember";
                header('refresh:0 '. $location);
            }
            
        }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>

<body class="bg-light">
    <?php include_once('htmlParts/starterHeader.php'); ?>
    <main class="logBg hidden m-4 p-4 border-20 shadow-lg mx-auto">
        <h2 class="text-center mb-4 logIn">Login</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="inputbox">
                <ion-icon name="contact"></ion-icon>
                <input type="text" name="username"  required maxlength="70">
                <label for="username" >Username</label>
            </div>
            <span class="form-text text-danger"><?php if(!$userExists) : ?>Username doesn't exist ! 
                                        <?php endif; ?></span>  

            <div class="inputbox">
                <ion-icon name="lock"></ion-icon>
                <input type="password" name="password"  required maxlength="50">
                <label for="password" >Password</label>
            </div>
            <span class="form-text text-danger"><?php if(!$passOk) : ?> Wrong password ! 
                                        <?php endif; ?></span>

            <div class="mb-0">
                <label class="remember">Remember me
                    <input type="checkbox" name="rememberMe" checked="checked">
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button type="submit" name="login" class="loginButton">Login</button>
            </div>
        </form>
    </main>
    <div id="fade2"></div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

<?php if(isset($conn)) { mysqli_close($conn); } ?>