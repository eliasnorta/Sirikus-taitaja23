<?php
    // yhdistäminen tietokantaan
	include "connect.php";
    // gets details for which show info to display
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
    <!-- jquery import -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="tilauslomake.css">
</head>
<body>
    <!-- header -->
    <header id="header">
        <div class="header_container">
            <!-- header "navbar" list -->
            <ul class="nav-list">
                <li><a href="#">Meistä</a></li>
                <li><a href="#">Esitykset</a></li>
            </ul>
            <!-- header logo -->
            <div class="logo">
                <a href="index.php">
                    <img src="kuvat/Sirikus-logo.svg" alt="sirikus logo">
                </a>
            </div>
            <!-- header "navbar" list -->
            <ul class="nav-list">
                <li><a href="#">Yhteystiedot</a></li>
                <li><a href="#">Liput</a></li>
            </ul>
            <!-- hamburger menu for header in mobile width -->
            <div class="nav-mobile">
                <a id="nav-toggle" href="#!">
                    <span>
                    </span>
                </a>
            </div>
        </div>
    </header>

    <!-- handles header menu in mobile width -->
    <script type="text/javascript">
		$(document).ready(function(){
            (function($) { // Begin jQuery
            $(function() { // DOM ready
                // If a link has a dropdown, add sub menu toggle.
                $('nav ul li a:not(:only-child)').click(function(e) {
                    $(this).siblings('.nav-dropdown').toggle();
                    // Close one dropdown when selecting another
                    $('.nav-dropdown').not($(this).siblings()).hide();
                        e.stopPropagation();
                });
                // Toggle open and close nav styles on click
                $('#nav-toggle').click(function() {
                    $('.header_container .nav-list').fadeToggle(100);
                });
                // Hamburger to X toggle
                $('#nav-toggle').on('click', function() {
                    this.classList.toggle('active');
                });
            }); // end DOM ready
            })(jQuery);
           
		})
	</script>

    <!-- lippujen varaus -->
    <section id="lippujen_varaus">
        <!-- back button that goes to main page -->
        <a href="index.php" type="submit"><img src="kuvat/icons/icons8-back-arrow-30.png" alt="back"></a>
        <!-- main title with bg image from css -->
        <h1 class="varaus_title"><span>Varaa liput</span></h1>
        <div class="varaus_content">
            <!-- show info box -->
            <div id="varaus_esitys">
                <!-- gves results for tickets from database -->
                <?php
                    while($rows = mysqli_fetch_array($result)) {
                    ?>
                <!-- show theme name -->
                <div class="esitys_title">
                    <h5> <?php echo $rows['teema']; ?> </h5>
                </div>
                <!-- show details -->
                <div class="esitys_info">
                    <!-- first row container -->
                    <div class="esitys_row">
                        <!-- show date. Each data area has its own icon -->
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-calendar-24.png" alt="calendar">
                            <?php
                                // näyttää päivämäärän eurooppalaisessa muodossa
                                while($rows2 = mysqli_fetch_array($result2)) {
                                    echo $rows2['DAY'];
                                }
                            ?>
                        </div>
                        <!-- shows time -->
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-clock-24.png" alt="time">
                            <?php
                                $time = $rows['aika'];
                                $test = substr($time, 0, -3);
                                echo $test;
                            ?>
                        </div>
                    </div>
                    <!-- second row container -->
                    <div class="esitys_row">
                        <!-- show location -->
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-location-32.png" alt="location">
                        
                            <?php echo $rows['esityspaikka']; ?> - <?php echo $rows['kaupunki']; ?>
                        </div>
                        <!-- show total seats and available seats -->
                        <div class="esitys_info-item">
                            <img src="kuvat/icons/icons8-seats.png" alt="">
                            <?php 
                                echo $rows['vapaitapaikkoja'];?>/<?php echo $rows['paikat']; 
                                
                                $availableseats = $rows['vapaitapaikkoja'];
                            ?>
                        </div>
                    </div>
                </div>
                
                <?php
                    }
                ?>
            </div>
            <!-- reserve seats for show form -->
            <div id="varaus_lomake">
                <div class="lomake_form">
                    <!-- form for reserving a ticket -->
                    <form method="POST">
                        <label for="">Sähköposti: *</label>
                        <br>
                        <!-- hidden esitys id value for submitting to the right show in database -->
                        <input style="display:none;" name="esitys" type="number" value="<?php echo $esitys?>">
                        <!-- email -->
                        <input class="lomake_input" placeholder="pekka.puoti@sposti.com" type="email" name="email">
                        <br>
                        <label for="">Puh-numero: *</label>
                        <br>
                        <!-- phone number -->
                        <input class="lomake_input" placeholder="+358-123-456-789" type="text" name="phone">
                        <br>
                        <label for="">Lippujen määrä: *</label>
                        <br>
                        <!-- amount of tickets, maximum being 5 and minimum 1 -->
                        <input class="lomake_input lomake_liput-maara" value="1" type="number" min="1" max="5" name="ticket">
                        <!-- submit button -->
                        <div class="lomake_nappi">
                            <!-- error message will be displayed in "error" class as text -->
                            <small class="error"></small>
                            <br>
                            <button type="submit" name="submit" id="lomake_submit">Varaa</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <!-- error handling for form -->
    <?php 
        // check if form is submitted
        if (isset($_POST['submit'])) {
            // database connection
            include "connect.php";
            // get data from form while preventing SQL injection
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
                    // check if cose amount of seats exceeds available seats
                    if ($ticket > $availableseats) {
                        echo "<script>$(document).ready(function(){ $('.error').html('Yritit tilata liian monta lippua.'); });</script>";
                        exit();
                    } else {
                        // if all errors are clear, submit form data to database
                        // perpared all form data for submitting to database
                        
                        // insert statement
                        $sql = "insert into `tilaaja` (sposti, puhelin, paikkojenlkm, esitysID) values (?, ?, ?, ?);";
                        // for updating available seats after form submission
                        $uusiarvo = $availableseats - $ticket;
                        $sql1 = "update `esitys` set vapaitapaikkoja = $uusiarvo where esitysID = $esitys";
                        // check for last errors. If all error are clear, send data to database
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "SQL error";
                        } else {
                            // "ssii" refers to data types being sent. s=string, i=integer, d=float, b= a blob and will be sent in packets
                            mysqli_stmt_bind_param($stmt, "ssii", $email, $phone, $ticket, $esitys);
                            mysqli_stmt_execute($stmt);
                        }
                        // for updating available seats
                        if ($conn->query($sql1) === TRUE) {
                            echo "Record updated successfully";
                        } else {
                            echo "Error updating record: " . $conn->error;
                        };
                        // success message
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
