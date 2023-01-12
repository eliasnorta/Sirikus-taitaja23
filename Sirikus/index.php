<?php
    // yhdistäminen tietokantaan
	include "connect.php";
    /* hakee tiedot renkaiden koista */
	$sql = "SELECT * FROM esitys ORDER BY pvm";
	$result = mysqli_query($conn, $sql);

	$sql2 = "SELECT DAY(pvm) AS DAY FROM esitys";
	$result2 = mysqli_query($conn, $sql2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rye">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<body>
    <div id="test">
    <div id="test-inside">

    <!-- ylätunniste header -->
    <header id="header">
        <div class="header_container">
            <ul>
                <li><a href="#">Meistä</a></li>
                <li><a href="#">Esitykset</a></li>
            </ul>
            <div class="logo">
                <a href="index.php">
                    <img src="kuvat/Sirikus-logo.svg" alt="sirikus logo">
                </a>
            </div>
            <ul>
                <li><a href="#">Yhteystiedot</a></li>
                <li><a href="#">Liput</a></li>
            </ul>
        </div>
    </header>

    <script type="text/javascript">
        // When the user scrolls down 50px from the top of the document, resize the header's font size
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 150) {
                $(".header_container").css({"height": "80px"});
                $(".logo img").css({"width": "80px", "margin": "0 -1.5em"});
                $(".header_container ul li").css({"margin": "0.5em"});
                document.querySelector('header').style.background = 'rgba(44, 25, 25, 0.9)';
                document.querySelector('header').style.marginBottom = '-6em';
                document.querySelector('header').style.backdropFilter = 'blur(10px)';
            } else {
                $(".logo img").css({"width": "auto", "margin": "0 0em"})
                $(".header_container").css({ "height": "190px"});
                $(".header_container ul li").css({"margin": "2em"});
                document.querySelector('header').style.background = '#00000000';
                document.querySelector('header').style.marginBottom = '-12em';
                document.querySelector('header').style.backdropFilter = 'blur(0px)';
            }
        }
    </script>

    <section id="hero">
        <div class="hero_container">
            <div class="hero_curved_text">
                <img src="kuvat/curved-title2.svg" alt="title">
            </div>
            <p class="hero_reviews">
                ⭐ “Mahtava!” ⭐ “Uskomaton!” ⭐ “Kiva!”
            </p>
            <!-- <img src="Blue_Stripes_with_Cream_Shape.png" alt="star"> -->
            <div class="circus_frame">
                <h1>Tulevat näytökset</h1>
                <div class="frame_content">
                    <div class="frame_info">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            <br><br>
                             Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                    </div>
                    <div class="frame_tickets">
                        <?php
                            while($rows = mysqli_fetch_array($result)) {
                            ?>
                                <div class="lippu">
                                    <div class="lippu_date">
                                        <?php
                                            $str = $rows['pvm'];
                                            $x = (explode("-",$str));
                                        ?>
                                            <small> <?php echo substr(date("l",mktime(0,0,0,$x[1],$x[2],$x[0])), 0, 3) ?> </small>
                                            <small> <?php echo substr(date("d",mktime(0,0,0,$x[1],$x[2],$x[0])), 0, 3) ?> </small>
                                            <small> <?php echo substr(date("M",mktime(0,0,0,$x[1],$x[2],$x[0])), 0, 5) ?> </small>
                                        <?php
                                        ?>
                                    </div>
                                    <div class="lippu_info">
                                        <div>
                                            <h5> <?php echo $rows['teema']; ?> </h5>
                                            <div>
                                                <small> <?php echo $rows['kaupunki']; ?> - <?php echo $rows['esityspaikka']; ?> </small>
                                            </div>
                                        </div>
                                        <div class="lippu_time">
                                            <small> <?php echo $rows['aika']; ?> </small>
                                        </div>
                                    </div>

                                    <a class="lippu_btn" href="tilauslomake.php?esitys=<?php echo $rows['esitysID']; ?>" >Varaa!</a>
                                </div>
                                <?php
                            }
                        ?>
                        <div class="frame_button">
                            <button>Katso Kaikki</button>
                        </div>
                    </div>
                </div>
                
                <!-- <script type="text/javascript">
                    $(document).ready(function(){

                        $('.lippu_btn').on('click', function(){
                            $eventID = $(this).attr("data");

                            alert($eventID);
                        })

                    })
                </script> -->

            </div>

            <div class="hero_circus-ball">
                <img src="kuvat/Blue_Stripes_with_Cream_Shape.png" alt="ball">
            </div>
        </div>
    </section>

    <section id="about">
        <div class="about_container">
            <h1>Meistä</h1>
            <p class="about_us">
                Sirikus on pieni sirkus, joka voi järjestää esityksensä missä tahansa. Esitys voi olla isossa teatterissa tai vaikka omassa kodissasi. Katsojamäärät vaihtelevat muutamasta ihmisestä jopa satoihin. Esitysten teema voi vaihdella asiakkaan toiveiden mukaan. Teemat vaihtelevat rauhallisesta ja eteerisestä jooga teemasta vaikka räjähtävään avaruuden valloitukseen.
                <br>
                <br>
                Sirkus Sirikuksessa työskentelee 5 innokasta ja taitavaa henkilöä. He vastaavat kaikesta esitysten vaatimista järjestelyistä. Sirkuksella on käytössään oma pakettiauto jonka kyydissä kulkee kaikki esityksessä tarvittava rekvisiitta.
            </p>
            <div class="contact_and_map">
                <p class="contact_info">
                Sirkuskoulu Sirikus <br> Kivenlahdentie 7 <br> 02320 Espoo <br><br> GSM: +358 50 567123 <br> sirikus@sirikus.fi
                </p>
                <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1985.7010724485303!2d24.660797499999997!3d60.1525721!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x468df4b1b436aa45%3A0x82d74da59421beb8!2sKivenlahdentie%207%2C%2002320%20Espoo!5e0!3m2!1sen!2sfi!4v1670584546479!5m2!1sen!2sfi" width="550" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
        </div>
    </section>

    </div>
    </div>

    <footer>
        <div class="footer_container">
            <div class="footer_logo">
                <img src="kuvat/Sirikus-logo.svg" alt="sirikus logo">
            </div>
           <p class="footer_contact-info">
            Sirkuskoulu Sirikus <br> Kivenlahdentie 7 <br> 02320 Espoo <br><br> GSM: +358 50 567123 <br> sirikus@sirikus.fi
           </p>
           <p class="footer_copyright">Ⓒ Sirikus</p>
        </div>
    </footer>
</body>
</html>