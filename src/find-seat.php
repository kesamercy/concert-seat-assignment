<?php
session_start();

if (count($_POST) > 0) {

    $seats = $_SESSION['seats-available'];
    $numseats = $_POST['seat-choice'];

    print_r($seats);

    $numrows = $_SESSION['rows'];
    $numcols = $_SESSION['cols'];

    echo $numcols, "the number of rows";
    echo $numrows, "the number of cols";

    $a = 0;
    $b = 0;
    $count = 0;
    $time = 0;

    $status = false;
    $rightChecked = false;

    $mid = ceil($numcols / 2);

    while ($a <= $numrows && !$status) {

        $mid = ceil($numcols / 2);
        $count = 0;
        while ($b != $numcols && !$status) {
            $mid = ceil($numcols / 2);
            if ($rightChecked = false && $time != 0) {
                $mid = $mid + $count;
                $rightChecked = true;
            } else {
                $mid = $mid - $count;
                $rightChecked = false;
            }

            $stra = strval($a);
            $strb = strval($mid);
            $newab = $stra . $strb;

            // check if the middle seat appears in the array for the available seats
            foreach ($seats as $key => $value) {

                echo $value;
                echo "<br>";
                echo "the value for ab";
                echo $newab;
                if ($newab == $value) {
                    $status = true;
                    break;
                }

            }

            ++$time;
            if ($status) {
                # return the seat assigned
                echo "the seat assinged is ", $newab;

                break;
            } else {
                //update mid to check for the next value on the right

                ++$count;

            }
            ++$b;
        }
        ++$a;
    }

} else {
    echo "error, the prog did not work";
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

        <?php
    echo "the seat assinged is ", $newab;
    ?>

        <div>
            <a href="confirm">Yes</a>
            <a>No, I want to exit</a>
            <a>Select more seats</a>
        </div>

        <div class="w3-container">
            <h1>WOuld you like to confirm your order?</h1>
            <button onclick="document.getElementById('id01').style.display='block'"
                class="w3-button w3-black">Yes</button>
            <a class="w3-btn w3-black" href="index.html">No, I want to exit</a>
            <div id="id01" class="w3-modal">
                <div class="w3-modal-content">
                    <div class="w3-container">
                        <span onclick="document.getElementById('id01').style.display='none'"
                            class="w3-button w3-display-topright">&times;</span>
                        <form class="w3-container w3-card-4" action="confirm.php">
                            <h2 class="w3-text-blue">Input Form</h2>
                            <p>Use any of the w3-text-color classes to color your labels.</p>
                            <p>
                                <label class="w3-text-blue"><b>First and Last Name</b></label>
                                <input class="w3-input w3-border" name="first" type="text"></p>
                            <p>
                                <label class="w3-text-blue"><b>Email</b></label>
                                <input class="w3-input w3-border" name="last" type="text"></p>
                            <p>
                                <button class="w3-btn w3-blue">Confirm Order</button></p>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>