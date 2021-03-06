<?php

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

<body class="index-page">
    <div class="content">
        <div class="w3-display-container w3-animate-opacity description-container">
            <div class="w3-display-topleft w3-padding"><img src="images/guitar-32.png" alt="guitar"></div>
            <div class="w3-display-topright w3-padding"><img src="images/side-drum-32.png" alt="drums"></div>
            <div class="w3-display-bottomleft w3-padding"><img height="30px" src="images/guitar-32.png" alt="sun"></div>
            <div class="w3-display-bottomright w3-padding"><img height="30px" src="images/side-drum-32.png"
                    alt="diamond"></div>

            <div class="index-title w3-center w3-padding-64">
                <h1> The Venue</h1>
                <h3> Choose a venue where you would like to book a seat for your next concert.</h3>
            </div>

            <div class="w3-display-middle w3-padding">
                <form method="post" action="venue.php">
                    <input type="hidden" name="venue" value="madison">
                    <p>
                        <input class="w3-button w3-amber w3-block w3-large" type="submit" value="Madison Square Garden">
                    </p>
                </form>

                <form method="post" action="venue.php">
                    <input type="hidden" name="venue" value="criscross">
                    <p>
                        <input class="w3-button w3-amber w3-block w3-large" type="submit" value="Criscross Raging Ball">
                    </p>
                </form>

                <form method="post" action="venue.php">
                    <input type="hidden" name="venue" value="kenedy">
                    <p>
                        <input class="w3-button w3-amber w3-block w3-large" type="submit" value="JF Kenedy Center"></p>
                </form>
            </div>
        </div>

    </div>
    <script>
    </script>

</body>

</html>