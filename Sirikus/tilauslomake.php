<?php
    // yhdistäminen tietokantaan
	include "connect.php";

    $esitys = $_GET['esitys'];

    /* hakee esityksen tiedot */
	$sql = "SELECT * FROM esitys where esitysID='{$esitys}'";
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
    <title>Lomake</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="tilauslomake.css">
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
</head>
<body>
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

    <!-- lippujen varaus -->
    <section id="lippujen_varaus">
    <a href="index.php" type="submit">Takaisin</a>
        <h1 class="varaus_title"><span>Varaa liput</span></h1>
        <div class="varaus_content">
            <div id="varaus_esitys">
                <?php
                    while($rows = mysqli_fetch_array($result)) {
                    ?>
                <div class="esitys_title">
                    <h5> <?php echo $rows['teema']; ?> </h5>
                </div>
                <div class="esitys_info">
                    <div class="esitys_row">
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-calendar-24.png" alt="calendar">
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
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-clock-24.png" alt="time">
                            <?php echo $rows['aika']; ?>
                        </div>
                    </div>
                    <div class="esitys_row">
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-location-32.png" alt="location">
                        
                            <?php echo $rows['esityspaikka']; ?> - <?php echo $rows['kaupunki']; ?>
                        </div>
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-seats.png" alt="">
                            <?php echo $rows['vapaitapaikkoja'];?> / <?php echo $rows['paikat']; ?>
                        </div>
                    </div>
                </div>
                
                <?php
                    }
                ?>
            </div>

            <div id="varaus_lomake">
                <div class="lomake_form">

                    <form action="lipunVaraus.php" method="POST">
                        <label for="">Sähköposti: *</label>
                        <br>
                        <input style="display:none;" name="esitys" type="number" value="<?php echo $esitys?>">
                        <input class="lomake_input" placeholder="pekka.puoti@sposti.com" type="email" name="email">
                        <br>
                        <label for="">Puh-numero: *</label>
                        <br>
                        <input class="lomake_input" placeholder="+358-123-456-789" type="text" name="phone">
                        <br>
                        <label for="">Lippujen määrä: *</label>
                        <br>
                        <input class="lomake_input lomake_liput-maara" value="1" type="number" name="ticket">

                        <div class="lomake_nappi">
                            <small class="error">Yritit tilata liian monta lippua!</small>
                            <br>
                            <button type="submit" name="submit" id="lomake_submit">Varaa</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <?php
        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if (strpos($fullUrl, "form=empty") == true) {
            echo "<script>alert('fill in all fields');</script>";
            exit();
        } else if (strpos($fullUrl, "form=email") == true) {
            echo "<script>alert('You used invalid characters');</script>";
            exit();
        } else if (strpos($fullUrl, "form=success") == true) {
            echo "You have bought tickets!";
            exit();
        }
    ?>

</body>
</html>