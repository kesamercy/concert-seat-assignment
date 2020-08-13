<?php
session_start();

if (count($_POST) > 0) {

    $names = $_POST['names'];
    $email = $_POST['email'];

    $to = $_POST["email"];
    $message = "Concert Reciept ";
    $message = $_POST['names'];
    $message = "Seat Number";
    $message = $_SESSION['seat-num'];
    $message = "Please bring this reciept with you. You will need this to pay for your seat at the concert venue.";
    $from = "info@venuebooking.com";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/plain; charset=iso-8859-1" . "\r\n";
    $headers .= "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $from . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    $headers .= "X-Priority: 1" . "\r\n";
    mail($to, $subject, $message, $headers);

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Concert Seats</title>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

    <div class="content">


        <div class="w3-display-middle w3-padding w3-center w3-text-black">
            <h1>Thank you for booking with us!</h1>

            <h4>Please check your email for your booking reciept</h4>

            <a class="w3-button w3-amber w3-center" href="index.html"> Exit</a>
        </div>


    </div>
</body>

</html>