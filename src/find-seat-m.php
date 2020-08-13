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

    $a = 1;
    $b = 1;
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
                  echo $newab, "this is the num";
                    break;
                }

            }

            ++$time;
            if ($status) {
                # return the seat assigned
                // echo "the seat assinged is ", $newab;

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

<body class="seat-page">


    <div class="content">

        <ul class='topnav'>
            <li><a class='logo' href='index.html'>The Venue</a></li>
            <li class='right'><a href='venue.php'>Select Seat</a></li>
            <li class='right'><a class='active' href='index.html'>Home</a></li>
        </ul>

        <div id="id01" class="w3-modal">
            <div class="w3-modal-content">

                <span onclick="document.getElementById('id01').style.display='none'"
                    class="w3-button w3-display-topright">&times;</span>
                <form class="w3-container w3-card-4" action="confirm.php">
                    <h2 class="w3-text-black">Personal Info</h2>
                    <p>Enter personal information for your booking.</p>
                    <p>
                        <label class="w3-text-black"><b>First and Last Name</b></label>
                        <input class="w3-input w3-border" name="names" type="text"></p>
                    <p>
                        <label class="w3-text-black"><b>Email</b></label>
                        <input class="w3-input w3-border" name="email" type="text"></p>
                    <p>
                        <button class="w3-btn w3-black">Confirm Order</button></p>
                </form>


            </div>
        </div>

        <div class="w3-display-middle w3-padding">


            <?php
            $arrayletters = array('0','A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');
            // get the first char of the string 
            // convert row to a string 
            // add it back to newab and then display the number 
                $getrow = $newab[0];
                $getnum = $newab[1];
                $rowletter = $arrayletters[$getrow];
                $newseat = $rowletter . $getnum;

                echo "<h1> Best Seat Option: ", $newseat . "</h1>";

                // print_r($seats);

                $_SESSION['seat-num'] = $newseat;


            ?>

            <div class="w3-container w3-center">
                <br><br>
                <h4 class="w3-center">Would you like to confirm your order?</h4>
                <br><br>
                <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-black">Yes,
                    confirm</button>
                <p>
                    <a class="w3-btn w3-black" href="index.html">No, I want to exit</a> </p>




            </div>
        </div>

    </div>
</body>

</html>