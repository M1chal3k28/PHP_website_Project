<head>
    <title>MOTONWES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/dbbf6e8872.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script defer src="scripts/app.js"></script>
    <script defer src="scripts/sleep.js"></script>
    <style>
        /* Loader */
            #LoaderAnim {
                top: 0;
                display: flex;
                justify-content: center;
                text-align: center;
                position: fixed;
                width: 100%;
                height: 100%;
                background-color: #212121;

                z-index: 100;
            }
            
            .pl {
                width: 12em;
                height: 12em;
                margin: 25%;
            }
            
            .pl__ring {
                animation: ringA 2s linear infinite;
            }
            
            .pl__ring--a {
                stroke: white;
            }
            
            .pl__ring--b {
                animation-name: ringB;
                stroke: #09B8F7;
            }
            
            .pl__ring--c {
                animation-name: ringC;
                stroke: white;
            }
            
            .pl__ring--d {
                animation-name: ringD;
                stroke: #09B8F7;
            }
                
                /* Animations */
            @keyframes ringA {
                from, 4% {
                stroke-dasharray: 0 660;
                stroke-width: 20;
                stroke-dashoffset: -330;
                }
            
                12% {
                stroke-dasharray: 60 600;
                stroke-width: 30;
                stroke-dashoffset: -335;
                }
            
                32% {
                stroke-dasharray: 60 600;
                stroke-width: 30;
                stroke-dashoffset: -595;
                }
            
                40%, 54% {
                stroke-dasharray: 0 660;
                stroke-width: 20;
                stroke-dashoffset: -660;
                }
            
                62% {
                stroke-dasharray: 60 600;
                stroke-width: 30;
                stroke-dashoffset: -665;
                }
            
                82% {
                stroke-dasharray: 60 600;
                stroke-width: 30;
                stroke-dashoffset: -925;
                }
            
                90%, to {
                stroke-dasharray: 0 660;
                stroke-width: 20;
                stroke-dashoffset: -990;
                }
            }
            
            @keyframes ringB {
                from, 12% {
                stroke-dasharray: 0 220;
                stroke-width: 20;
                stroke-dashoffset: -110;
                }
            
                20% {
                stroke-dasharray: 20 200;
                stroke-width: 30;
                stroke-dashoffset: -115;
                }
            
                40% {
                stroke-dasharray: 20 200;
                stroke-width: 30;
                stroke-dashoffset: -195;
                }
            
                48%, 62% {
                stroke-dasharray: 0 220;
                stroke-width: 20;
                stroke-dashoffset: -220;
                }
            
                70% {
                stroke-dasharray: 20 200;
                stroke-width: 30;
                stroke-dashoffset: -225;
                }
            
                90% {
                stroke-dasharray: 20 200;
                stroke-width: 30;
                stroke-dashoffset: -305;
                }
            
                98%, to {
                stroke-dasharray: 0 220;
                stroke-width: 20;
                stroke-dashoffset: -330;
                }
            }
            
            @keyframes ringC {
                from {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: 0;
                }
            
                8% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -5;
                }
            
                28% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -175;
                }
            
                36%, 58% {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: -220;
                }
            
                66% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -225;
                }
            
                86% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -395;
                }
            
                94%, to {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: -440;
                }
            }
            
            @keyframes ringD {
                from, 8% {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: 0;
                }
            
                16% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -5;
                }
            
                36% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -175;
                }
            
                44%, 50% {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: -220;
                }
            
                58% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -225;
                }
            
                78% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -395;
                }
            
                86%, to {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: -440;
                }
            }
        /* */
    </style>
</head>

<section id="LoaderAnim">
    <svg viewBox="0 0 240 240" height="240" width="240" class="pl">
        <circle stroke-linecap="round" stroke-dashoffset="-330" stroke-dasharray="0 660" stroke-width="20" stroke="#000" fill="none" r="105" cy="120" cx="120" class="pl__ring pl__ring--a"></circle>
        <circle stroke-linecap="round" stroke-dashoffset="-110" stroke-dasharray="0 220" stroke-width="20" stroke="#000" fill="none" r="35" cy="120" cx="120" class="pl__ring pl__ring--b"></circle>
        <circle stroke-linecap="round" stroke-dasharray="0 440" stroke-width="20" stroke="#000" fill="none" r="70" cy="120" cx="85" class="pl__ring pl__ring--c"></circle>
        <circle stroke-linecap="round" stroke-dasharray="0 440" stroke-width="20" stroke="#000" fill="none" r="70" cy="120" cx="155" class="pl__ring pl__ring--d"></circle>
    </svg>
</section>

<header>
    <img class="logo" src="img/BLOGO.png">
    <div class="d-flex flex-row m-4">
        <div class="menu"
            <?php if (!isset($_SESSION["username"])) : ?> style="right: 85px !important;" <?php endif; ?>
        >
            <button class="dropbtn" onclick="myFunction(this);">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </button>
        </div>

        <?php if (isset($_SESSION["username"])) : ?>
                <div id="profileImg">
                    <div id="profileClick" class="d-flex flex-column align-items-center">
                        <img src="img/ProfileImages/<?php echo $_SESSION['imageId']; ?>.jpg" alt="profImg" width="70" height="40">
                        <span class="mt-2"><?php echo strip_tags($_SESSION["username"]); ?></span>
                    </div>
                </div>
        <?php endif; ?>
    </div>
    
    <?php
        $currFile = explode('/', $_SERVER["PHP_SELF"])[2];
    ?>

    <div id="myDropdown" class="myDropdown dropdown-content"
        <?php if (!isset($_SESSION["username"])) : ?> style="right: 150px !important;" <?php endif; ?>
    >
        <?php if (isset($_SESSION["username"])) : ?>
            <?php if ($currFile == "home.php") : ?>
                <button class="menuButton" id="searchMenuButton">SEARCH</button><br>
            <?php endif; ?>
            <button onclick="location.href='home.php'" class="menuButton">HOME</button><br>
            <button onclick="location.href='start.php#abt'" class="menuButton">ABOUT US</button><br>
            <?php if ($_SESSION['privileges']) : ?>
                <button onclick="location.href='articleCreator.php'" class="menuButton">CREATE</button><br>
            <?php endif; ?>
            <button onclick="location.href='logIn.php'" class="menuButton">LOG OFF</button><br>
        <?php else: ?>
            <button onclick="location.href='logIn.php'" class="menuButton">LOG IN</button><br>
            <button onclick="location.href='register.php'" class="menuButton">REGISTER</button><br>
            <button onclick="location.href='start.php#abt'" class="menuButton">ABOUT US</button>
        <?php endif; ?>
    </div>

</header>

<section id="searchPanel" class="blackFont shadow-lg" style="display: none;">
    <button id="PrzyciskWylaczajacySearchPanel" class="ChangeProfileImage-exit loginButton"><i class="fas fa-x"></i></button>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="mt-3">
        <div class="inputbox inputboxBlack">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" fill="currentColor" class="bi bi-search blackFont" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
            <input class="blackFont" type="text" name="searching" required maxlength="20">
            <label class="blackFont" for="searching">Phrase</label>
        </div>
        <button class="loginButton blackFont" type="submit">Search</button>
    </form>
</section>

<script>
    // Losowanie tla 
    function getRandom(min, max) {
        return Math.random() * (max - min) + min;
    }

    document.body.className="bg" + parseInt(getRandom(1, 4));
    //
    
    window.addEventListener("load", () => {
                document.querySelector("#LoaderAnim").style.display = "none";
            });

    let profileButton =document.querySelector('#profileClick');
    let searchMenuButton = document.querySelector("#searchMenuButton");
    let wylaczSearchMenu = document.querySelector('#PrzyciskWylaczajacySearchPanel');
    let searchMenu = document.querySelector('#searchPanel');

    if(profileButton != null) {
        profileButton.addEventListener('click', e=>{
            location = "profile.php";
        });
    }

    wylaczSearchMenu.addEventListener('click', e => {
        searchMenu.style.display = "none";
    });
    if(searchMenuButton) {
        searchMenuButton.addEventListener('click', e => {
            searchMenu.style.display = "flex";
        });
    }
</script>