<?php include_once('scripts/functions.php'); ?>
<?php include_once('htmlParts/starterHeader.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOTONWES</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <div id="fade"></div>
    <a name="abt"></a>

    <div id="Rom">ABOUT US</div>
    <main>
            <div id="txt">
                Welcome to MOTONEWS, your premier destination for all things automotive. 
                At MOTONEWS, we live and breathe cars, trucks, motorcycles, and everything 
                in between. Whether you're a die-hard enthusiast or simply seeking the 
                latest updates in the automotive industry, we've got you covered.
                Our team is composed of passionate automotive experts, journalists, 
                and enthusiasts who are dedicated to bringing you the most accurate, 
                insightful, and engaging news and reviews. We scour the globe to deliver 
                breaking news, in-depth analyses, and comprehensive reviews of the latest vehicles hitting the market.
                What sets MOTONEWS apart is our commitment to providing unbiased and 
                objective reporting. We believe in delivering information that empowers our audience to make informed decisions about their automotive interests. Whether you're interested in the latest advancements in electric vehicles, performance upgrades, safety innovations, or simply want to stay up-to-date with the hottest trends, MOTONEWS is your trusted source.
                But we're more than just a news outlet. We're a community of automotive enthusiasts united by our love for all things on wheels. Our interactive platform allows you to connect with like-minded individuals, share your passion for automobiles, and engage in lively discussions about the latest developments in the industry.
                Whether you're a casual reader, a seasoned gearhead, or a professional in the automotive field, MOTONEWS is your ultimate destination for everything automotive. Join us on our journey as we navigate the fast-paced world of cars, trucks, motorcycles, and beyond. Welcome to MOTONEWS – where the road never ends.
            </div>
    </main>
    <div id="trapez">
        <div class="trapez"></div>
    </div>
    <footer class="startfooter">
        <section>
            <div><img class="logo" src="img/BLOGO.png"></div>
                    <div id="footerCointan">
                    <div id="contact">
                        <p>CONTACT:</p>
                        <div id="data">
                            TEL: <a href="tel:+48777777777">+48 777 777 777</a><br>
                            MAIL: <a href="mailto:'contact@motonews.pl'">CONTACT@MOTONEWS.PL</a>
                        </div> 
                    </div>
                    <div id="sponsors">
                        <p>SPONSORS:</p>
                            <div>
                            <img src="img/SPONSOR1.png" width="200px" height="200px">
                            <img src="img/SPONSOR2.webp" width="280px" height="200px">
                        </div>
                    </div>
                </div>
        </section>
    </footer>
</body>
</html>

<?php if(isset($conn)) { mysqli_close($conn); } ?>