<?php
    include_once'conn.php';
    session_start();
    //setcookie("PHPSESSID", $_COOKIE["PHPSESSID"], time() + 180, "/");

    if($_SERVER["REQUEST_METHOD"] == "GET" &&
       isset($_GET["input"]) &&
       isset($_GET["pass"]) &&
       isset($_GET["remember"])) 
    {
        $input = $_GET["input"];
        $pass = $_GET["pass"];
        $remember = $_GET["remember"];
        
        try {
            $sqlUsername = "SELECT distinct * FROM users, usersInfo WHERE users.userId = usersInfo.userId AND users.userName = '$input'";
            $resultUsername = mysqli_query($conn, $sqlUsername);
    
            if(mysqli_num_rows($resultUsername) < 1) {
                $sqlEmail = "SELECT distinct * FROM users, usersInfo WHERE users.userId = usersInfo.userId AND usersInfo.email = '$input'";
                $resultEmail = mysqli_query($conn, $sqlEmail);
    
                if(mysqli_num_rows($resultEmail) > 0) {
                    $row = mysqli_fetch_assoc($resultEmail);
                } 
            } else {
                $row = mysqli_fetch_assoc($resultUsername);
            }
        } catch (mysqli_sql_exception $e) {};

        if(password_verify($pass, $row['pass'])) {
            $_SESSION["username"] = $row["userName"];
            $_SESSION["realName"] = $row["realName"];
            $_SESSION["surname"] = $row["surname"];
            $_SESSION["userId"] = $row["UserId"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["privileges"] = $row["privileges"];
            $_SESSION["imageId"] = $row["ProfileImageId"];
        }

        if($remember) {
            $expires = time() + ((60*60*24) * 7);
            $salt = '#^salt&(';
            $token_key = hash("sha256", (time() . $salt));
            $token_value = hash("sha256", ("Logged_in" . $salt));

            setcookie('SES', $token_key. ':'. $token_value, $expires, "/");

            $id = $_SESSION["userId"];
            $sql = "update users set token_key = '$token_key', token_value = '$token_value' WHERE userId = '$id' LIMIT 1";
            mysqli_query($conn, $sql);
        } else {
            setcookie("PHPSESSID", $_COOKIE["PHPSESSID"], time() + 180, "/");
        }

    } else {
        echo "Error | Unknown request pulled !";
    }

    if(isset($conn)) { mysqli_close($conn); }
    header("refresh:0 ../home.php");
?>  