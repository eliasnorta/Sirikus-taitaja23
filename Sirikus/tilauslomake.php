<?php
    // yhdistäminen tietokantaan
	include "connect.php";

    $esitys = $_GET['esitys'];

    /* hakee esityksen tiedot */
	$sql = "SELECT * FROM esitys where esitysID='{$esitys}'";
	$result = mysqli_query($conn, $sql);

	// hakee päivämäärän ja muotoilee sen eurooppalaiseen tapaan
	$sql2 = "SELECT DATE_FORMAT(pvm, GET_FORMAT(DATE,'EUR')) AS DAY FROM esitys where esitysID='{$esitys}'";
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
                                // näyttää päivämäärän eurooppalaisessa muodossa
                                while($rows2 = mysqli_fetch_array($result2)) {
                                    echo $rows2['DAY'];
                                }
                            ?>
                        </div>
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-clock-24.png" alt="time">
                            <?php
                                $time = $rows['aika'];
                                $test = substr($time, 0, -3);
                                echo $test;
                            ?>
                        </div>
                    </div>
                    <div class="esitys_row">
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-location-32.png" alt="location">
                        
                            <?php echo $rows['esityspaikka']; ?> - <?php echo $rows['kaupunki']; ?>
                        </div>
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-seats.png" alt="">
                            <?php 
                                echo $rows['vapaitapaikkoja'];?> / <?php echo $rows['paikat']; 
                                
                                $availableseats = $rows['vapaitapaikkoja'];
                            ?>
                        </div>
                    </div>
                </div>
                
                <?php
                    }
                ?>
            </div>

            <div id="varaus_lomake">
                <div class="lomake_form">
                    <!-- form for reserving a ticket -->
                    <form method="POST">
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
                            <small class="error"></small>
                            <br>
                            <button type="submit" name="submit" id="lomake_submit">Varaa</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <?php 

        // check if form is submitted
        if (isset($_POST['submit'])) {
            // database connection
            include "connect.php";
            // get data from form
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $ticket = mysqli_real_escape_string($conn, $_POST['ticket']);
            $esitys = mysqli_real_escape_string($conn, $_POST['esitys']);
            // check that all form fields are filled
            if (empty($email) || empty($phone) || empty($ticket) || empty($esitys)) {
                echo "<script>$(document).ready(function(){ $('.error').html('Täytä kaikki tiedot!'); });</script>";
                exit();
            } else {
                // check for invalid email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<script>$(document).ready(function(){ $('.error').html('You used invalid characters'); });</script>";
                    exit();
                } else {
                    if ($ticket > $availableseats) {
                        echo "<script>$(document).ready(function(){ $('.error').html('Yritit tilata liian monta lippua.'); });</script>";
                        exit();
                    } else {
                        // submit form data to database
                        $sql = "insert into `tilaaja` (sposti, puhelin, paikkojenlkm, esitysID) values (?, ?, ?, ?);";
        
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "SQL error";
                        } else {
                            mysqli_stmt_bind_param($stmt, "ssii", $email, $phone, $ticket, $esitys);
                            mysqli_stmt_execute($stmt);
                        }
                        echo'<script>alert("Varasit liput onistuneesti! Vahvistus lähetetty osoitteeseen: '.$email.'")</script>';
                        echo("<script>location.href = './index.php';</script>");
                        exit();
                    }
                }
                
                
            }
        }

    ?>

</body>
</html>
