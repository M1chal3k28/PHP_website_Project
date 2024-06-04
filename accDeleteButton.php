<?php include('scripts/functions.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>? DELETE ? <?php echo $_SESSION["username"]; ?> ?</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            background-image: none;
            background-color: #212121;
        }

        main {
            position: fixed;
            background-color: transparent;
            margin: auto;
            display: flex;
            justify-content: center;
            text-align: center;
            width: 100%;
            height: 100%;
        }
        
        main button {
            margin: auto;
        }
    </style>
</head>
<body>
    <main id="deleteAccountMain">
        <form action="scripts/deleteAcc.php" method="post">
            <button class="scaryBtn">
                <div class="lid">
                    <span class="side top"></span>
                    <span class="side front"></span>
                    <span class="side back"> </span>
                    <span class="side left"></span>
                    <span class="side right"></span>
                </div>
                <div class="panels">
                    <div class="panel-1">
                    <div class="panel-2">
                        <div class="btn-trigger">
                        <span class="btn-trigger-1"></span>
                        <span class="btn-trigger-2"></span>
                        </div>
                    </div>
                    </div>
                </div>
            </button>
        </form>
    </main>
</body>
</html>

<?php if(isset($conn)) { mysqli_close($conn); } ?>