<?php include('functions.php'); 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_SESSION["userId"];

        try {
            $delOpinions = "DELETE FROM opinions WHERE userId = $id";
            $delUserInfo = "DELETE FROM usersInfo WHERE userId = $id";
            $delUser = "DELETE FROM users WHERE userId = $id";

            mysqli_query($conn, $delOpinions);
            mysqli_query($conn, $delUserInfo);
            mysqli_query($conn, $delUser);
        } catch (mysqli_sql_exception $e) {}

        echo '
                <script>
                    alert("Account Deleted");
                </script>
             ';

        header('refresh:0 ../logIn.php');
        if(isset($conn)) { mysqli_close($conn); }
        die;
        
    } else {
        echo "Error | Can't delete such account";
    }

if(isset($conn)) { mysqli_close($conn); } 
?>