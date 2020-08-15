<?php
session_start();
include('common-functions.php');

if (count($_POST) > 0) {
    $venue = $_POST['venue'];
    $numRows = 0;
    $numCols = 0;
    $a = 1;
    $b = 1;
    $availableSeat;
    $seats = array();
}

function parseJsonFile($filename)
{
    global $numRows;
    global $numCols;
    global $availableSeat;
    global $seats;

    if (file_exists($filename)) {

        $json = file_get_contents($filename);

        if (!empty($json)) {

            $fileContent = json_decode($json, true);
            $numRows = $fileContent['venue']['layout']['rows'];
            $numCols = $fileContent['venue']['layout']['column'];
            $seats = array($availableSeat);

            //loop through the json file to find all available seats.Update the array 'seats' which carries the collection of all seats available
            foreach ($fileContent['seats'] as $key => $value) {
                // get the numeric equivalent of the the row alphabet.
                $postn = ord(strtoupper($value['row'])) - ord('A') + 1;
                $availableSeat = convertSeatFromIntToString($postn, $value['column']);
                array_push($seats, $availableSeat);
            }

            $_SESSION['seats-available'] = $seats;
        } else {
            echo "Error, Json file has no content";
        }

    } else {
        echo "Error, The file does not exist.";
    }
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

<body class="venue-content">

    <div class="content">

        <ul class='topnav'>
            <li><a class='logo' href='index.php'>The Venue</a></li>
        </ul>

        <div class="w3-row">

            <div class="w3-half seat-arrangment w3-center">

                <?php
                if ($venue == "madison") {
                    parseJsonFile("assets/madison.json");
                    echo "<h1 class='w3-padding-32'>Madison Square Garden Seating</h1>";
                } elseif ($venue == "criscross") {
                    parseJsonFile("assets/criscross.json");
                    echo "<h1 class='w3-padding-32'>Criscross Raging Ball Seating.</h1>";
                } elseif ($venue == "kenedy") {
                    parseJsonFile("assets/kenedy.json");
                    echo "<h1 class='w3-padding-32'>JF Kenedey Center Seating.</h1>";
                } else {
                    echo "Error, invalid input";
                }
                    global $a;
                    global $b;
                    $status = false;
                    $_SESSION['rows'] = $numRows;
                    $_SESSION['cols'] = $numCols;
                    $reset = 1;

                    echo "<table class='w3-table'>";
                    while ($a <= $numRows) {
                        echo "<tr>";
                        while ($b <= $numCols) {
                            $status = determineIfSeatIsAvailable($a, $b);
                            if ($status) {
                                echo " <td><img src='images/empty-seat.png' alt='occupied seat'></td>";
                            } else {
                                echo " <td><img src='images/occupied-seat.png' alt='occupied seat'></td>";
                            }
                            $status = false;
                            ++$b;
                        }
                        echo "</tr>";
                        ++$a;
                        $b = $reset;
                    }
                    echo "</table>"

                    ?>
            </div>
            <div class="w3-half seat-form w3-center">
                <form method="post" action="find-seat.php">
                    <p>
                    <label for="seat-choice"> <h3> How many seats would you like to book:</h3></label></p>

                    <select class="w3-select w3-center" id="seat-choice" name="seat-choice">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                    <p>
                    <input class="w3-button w3-amber" type="submit" value="Submit"></p>
                </form>

            </div>

        </div>

    </div>

    <script>
    </script>

</body>

</html>