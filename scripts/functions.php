<?php 
    include_once'conn.php';
    session_start();

    $cookie = $_COOKIE["SES"] ?? null;
    if($cookie && strstr($cookie, ":")) {
        $parts = explode(":", $cookie);
        $token_key = $parts[0];
        $token_value = $parts[1];

        try {
            if($conn) {
                $sql = "SELECT * FROM users INNER JOIN usersInfo ON users.userId = usersInfo.userId WHERE users.token_key = ? LIMIT 1";
                try {
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $token_key);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
            
                    if(mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        if($token_value == $row["token_value"]) {
                            $_SESSION["username"] = $row["userName"];
                            $_SESSION["realName"] = $row["realName"];
                            $_SESSION["surname"] = $row["surname"];
                            $_SESSION["userId"] = $row["UserId"];
                            $_SESSION["email"] = $row["email"];
                            $_SESSION["privileges"] = $row["privileges"];
                            $_SESSION["token_key"] = $row["token_key"];
                            $_SESSION["token_value"] = $row["token_value"];
                            $_SESSION["imageId"] = $row["ProfileImageId"];
                        }
                    }
                } catch (mysqli_sql_exception $e) {
                    echo "Error during session recovery !"; 
                    die;
                }
            } else {
                echo "Error during session recovery !"; 
                die;
            }            
        } catch ( mysqli_sql_exception $e) { echo "Error during session recovery !"; die; };
    }

    $get_url = explode('/', str_replace(".php", "", $_SERVER['REQUEST_URI']))[2];
    $avaiable = ["logIn", "start", "register"];
    if(!isset($_SESSION["username"]) && !in_array($get_url, $avaiable)) {
        echo "<script> 
                alert('Session Expired');
              </script>";

        header('refresh:0 logIn.php');
        die;
    }

    // returns password for found account
    function userForExist($conn, $Name) {
        if(!isset($conn) || !isset($Name)) { 
            return false; 
        }
        
        $sql = "SELECT * FROM users WHERE userName = ?";
        try {
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $Name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        
            if (mysqli_num_rows($result) > 0) {
                $pass = mysqli_fetch_assoc($result);
                return $pass['pass'];
            } else {
                $sql = "SELECT * FROM users INNER JOIN usersinfo ON users.UserId = usersinfo.UserId WHERE email = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $Name);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
        
                if (mysqli_num_rows($result) > 0) {
                    $pass = mysqli_fetch_assoc($result);
                    return $pass['pass'];
                }
            }
        
            return '';
        } catch (mysqli_sql_exception $e) {
            // Obsługa wyjątku
            echo $e->getMessage();
            return false;
        }
        
    }

    function emailForExist($conn, $Email) {
        if(!isset($conn) || !isset($Email)) { 
            return false; 
        }
        
        $sql = "SELECT * FROM users INNER JOIN usersInfo ON users.userId = usersInfo.userId WHERE email = ? LIMIT 1";
        try {
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $Email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        
            if(mysqli_num_rows($result) == 1) {
                return true;
            }
        
            return false;
        } catch(mysqli_sql_exception $e) { 
            // Obsługa wyjątku
            echo $e->getMessage();
            return false;
        }
        
    }  

    function createUser($conn, string $Name, string $Pass, string $Email, string $RealName, string $Surname) {
        if(!isset($conn)) { 
            echo "<script>
                    alert('Lost Connection to the database !');
                  </script>"; 
            header("refresh:0");
            exit; // Dodano wyjście z programu po wyświetleniu alertu, aby uniknąć dalszego wykonywania kodu
        }
        
        try {
            $hash = password_hash($Pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (userName, pass)
                    VALUES (?, ?)";
        
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $Name, $hash);
            mysqli_stmt_execute($stmt);
        
            
            $sql = "SELECT userId FROM users WHERE userName = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $Name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $userId = mysqli_fetch_assoc($result)["userId"];
        
            
            $sql = "INSERT INTO usersInfo (userId, realName, surname, email)
                    VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "isss", $userId, $RealName, $Surname, $Email);
            mysqli_stmt_execute($stmt);
        
            echo "<script>
                    alert('Account created !');
                  </script>";
            header("refresh:0");
            exit; 
        } 
        catch (mysqli_sql_exception $e) { 
            echo "<script>
                    alert('Account can\'t be created due to some unknown error !');
                  </script>"; 
            header("refresh:0");
            exit; 
        }
        
    }

    function checkPass($conn, $Pass, $AccountPass) {
        if(!isset($conn)) { return false; }
        
        try {
            return password_verify($Pass, $AccountPass);
        } catch(mysqli_sql_exception $e) { return false; }
    }
?>