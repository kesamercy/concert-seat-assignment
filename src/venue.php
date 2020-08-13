<?php
session_start();

$numrows = 0;
$numcols = 0;
$a = 0;
$b = 0;
$newval = "";
$seats = array();

// use sessions to update the seats

if (count($_POST) > 0) {
    $venue = $_POST['venue'];

}

function printValues($arr)
{
    global $count;
    global $values;

    // Check input is an array
    if (!is_array($arr)) {
        die("ERROR: Input is not an array");
    }

    /*
    Loop through array, if value is itself an array recursively call the
    function else add the value found to the output items array,
    and increment counter by 1 for each value found
     */
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            printValues($value);
        } else {
            $values[] = $value;
            $count++;
        }
    }

    // Return total count and values found in array
    return array('total' => $count, 'values' => $values);
}

function parseJsonFile($filename)
{
    global $numrows;
    global $numcols;
    global $newval;
    global $seats;

    if (file_exists($filename)) {

        $json = file_get_contents($filename);

        if (!empty($json)) {

            $filecontent = json_decode($json, true);
            $numrows = $filecontent['venue']['layout']['rows'];
            $numcols = $filecontent['venue']['layout']['column'];

            $seats = array($newval);

            foreach ($filecontent['seats'] as $key => $value) {
                // echo $value['row'];
                // echo $value['column'];

                $postn = ord(strtoupper($value['row'])) - ord('A') + 1;
                // echo $postn;

                $rowstr = strval($postn);
                $colstr = strval($value['column']);

                $newval = $rowstr . $colstr;

                array_push($seats, $newval);

                // echo $newval, "this is the letter value";

                // make a list of the seats available

            }

            $_SESSION['seats-available'] = $seats;
        } else {
            echo "Error, Json file has no content";
        }

    } else {
        echo "Error, The file does not exist.";
    }

    return $filecontent;
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
            <li><a class='logo' href='index.html'>The Venue</a></li>
            <li class='right'><a href='venue.php'>Select Seat</a></li>
            <li class='right'><a href='about.php'>About</a></li>
            <li class='right'><a class='active' href='index.php'>Home</a></li>
        </ul>

        <div class="w3-row seat-arrangment">

            <div class="w3-half w3-center">

                <?php
                if ($venue == "madison") {
                    $content = parseJsonFile("assets/madison.json");
                    $result = printValues($content);
                    echo "<h1 class='w3-padding-64'>Madison Square Garden Seating</h1>";
                } elseif ($venue == "criscross") {
                    $content = parseJsonFile("assets/criscross.json");
                    $result = printValues($content);
                    echo "<h1 class='w3-padding-64>Criscross Seating.</h1>";
                } elseif ($venue == "kenedy") {
                    $content = parseJsonFile("assets/kenedy.json");
                    $result = printValues($content);
                    echo "<h1 class='w3-padding-64>JF Kenedey Center Seating.</h1>";
                } else {
                    echo "Error, invalid input";
                }
                    global $a;
                    global $b;
                    $status = false;

                    $_SESSION['rows'] = $numrows;
                    $_SESSION['cols'] = $numcols;

                    echo "<table class='w3-table'>";
                    while ($a <= $numrows) {
                        echo "<tr>";
                        while ($b <= $numcols) {

                            $stra = strval($a);
                            $strb = strval($b);
                            $newab = $stra . $strb;

                            // check if the row and col are in avail seat list.
                            foreach ($seats as $key => $value) {

                                if ($newab == $value) {

                                    $status = true;
                                    break;
                                }

                            }
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
                        $b = 0;
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
                        <option value="4">4</option>
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