<?php
    $esitys = $_GET['esitys'];
    // check if form is actually submited
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
            // header("Location: ./tilauslomake.php?esitys=$esitys?form=empty");
            echo "<script>alert('fill in all fields');</script>";
            exit();
        } else {
            // check for invalid email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ./tilauslomake.php?esitys=$esitys?form=invalidemail");
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
                // echo'<script>alert("You have succesfully bought tickets")</script>';
                header("Location: ./tilauslomake.php?esitys=$esitys?form=success");
                exit();
            }
        }
    } else {
        header("Location: ./tilauslomake.php?esitys=$esitys?form=error");
        exit();
    }
    
    
