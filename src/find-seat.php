<?php
session_start();

if (count($_POST) > 0) {

    $seats = $_SESSION['seats-available'];
    $seatrequest = $_POST['seat-choice'];
    $numrows = $_SESSION['rows'];
    $numcols = $_SESSION['cols'];
    $seatassigned = false;
    $doubleseats = array();

    if ($seatrequest == 1) {

        // check the rows only if a seat has not been assigned
        for ($row = 1; $row <= $numrows; $row++ && !$seattocheck) {
            $postn = 1;
            $seatscounted = 1;
            $checkmiddle = false;

            $checkleft = false;
            $checkright = false;
            while ($seatscounted <= $numcols && !$seatassigned) {
                //    first check the middle seat for assignment
                if (!$checkmiddle) {
                    $mid = ceil($numcols / 2);
                    $stra = strval($row);
                    $strb = strval($mid);
                    $seattocheck = $stra . $strb;

                    // check the array of seats available to find if it matches the current seat
                    foreach ($seats as $key => $value) {

                        // if the middle seat is available, assign it
                        if ($seattocheck == $value) {
                            $seatassigned = true;
                            // echo $seattocheck, "this is the seat";
                            break;
                        }

                    }

                    $checkmiddle = true;
                } else {
                    //   check the left postion
                    if (!$checkright) {
                        $findseat = ceil($numcols / 2) + $postn;
                        $stra = strval($row);
                        $strb = strval($findseat);
                        $seattocheck = $stra . $strb;

                        // check the array of seats available to find if it matches the current seat
                        foreach ($seats as $key => $value) {

                            // if the middle seat is available, assign it
                            if ($seattocheck == $value) {
                                $seatassigned = true;
                                // echo $seattocheck, "this is the seat";
                                break;
                            }

                        }
                        $checkright = true;
                        ++$seatscounted;
                    } elseif (!$checkleft) {
                        $findseat = ceil($numcols / 2) - $postn;
                        $stra = strval($row);
                        $strb = strval($findseat);
                        $seattocheck = $stra . $strb;

                        // check the array of seats available to find if it matches the current seat
                        foreach ($seats as $key => $value) {

                            // if the middle seat is available, assign it
                            if ($seattocheck == $value) {
                                $seatassigned = true;
                                // echo $seattocheck, "this is the seat";
                                break;
                            }

                        }

                        $checkleft = true;
                        ++$seatscounted;
                    } elseif ($checkleft && $checkright && !$seatassigned) {
                        $checkleft = false;
                        $checkright = false;
                        ++$postn;

                    }

                }

            }
        }
    } elseif ($seatrequest == 2) {
        global $doubleseats;
        // check the rows only if a seat has not been assigned
        for ($row = 1; $row <= $numrows; $row++ && !$seattocheck) {
            $postn = 1;
            $seatscounted = 1;
            $checkmiddle = false;
            $empty = "";

            $checkleft = false;
            $checkright = false;

            while ($seatscounted <= $numcols && !$seatassigned) {
                $doubleseats = array($empty);
                //    first check the middle seat for assignment
                if (!$checkmiddle) {
                    $mid = ceil($numcols / 2);
                    $stra = strval($row);
                    $strb = strval($mid);
                    $seattocheck = $stra . $strb;

                    // check the array of seats available to find if it matches the current seat
                    foreach ($seats as $key => $value) {

                        // if the middle seat is available, check if neighto right is avail
                        if ($seattocheck == $value) {

                            // check if the neigh seat
                            $midright = ceil($numcols / 2) + 1;
                            $stra = strval($row);
                            $strb = strval($midright);
                            $seattocheckright = $stra . $strb;

                            $midleft = ceil($numcols / 2) - 1;
                            $stra = strval($row);
                            $strb = strval($midleft);
                            $seattocheckleft = $stra . $strb;

                            if (in_array($seattocheckright, $seats)) {

                                array_push($doubleseats, $seattocheck);
                                // $doubleseats($seattocheck);
                                array_push($doubleseats, $seattocheckright);
                                $seatassigned = true;
                                echo "was assigned";
                                print_r($doubleseats);
                                break;
                            } elseif (in_array($seattocheckleft, $seats)) {
                                $doubleseats($seattocheck);
                                array_push($doubleseats, $seattocheckleft);
                                $seatassigned = true;
                                break;
                            }

                        }

                    }

                    $checkmiddle = true;
                } else {
                    //   check the left postion
                    if (!$checkright) {
                        $findseat = ceil($numcols / 2) + $postn;
                        $stra = strval($row);
                        $strb = strval($findseat);
                        $seattocheck = $stra . $strb;

                        // check the array of seats available to find if it matches the current seat
                        foreach ($seats as $key => $value) {

                            // if the middle seat is available, assign it
                            if ($seattocheck == $value) {
                               // check if the neigh seat
                               $midright = $findseat + 1;
                               $stra = strval($row);
                               $strb = strval($midright);
                               $seattocheckright = $stra . $strb;

                               $midleft = ceil($numcols / 2) - 1;
                               $stra = strval($row);
                               $strb = strval($midleft);
                               $seattocheckleft = $stra . $strb;

                               if (in_array($seattocheckright, $seats)) {

                                   array_push($doubleseats, $seattocheck);
                                   // $doubleseats($seattocheck);
                                   array_push($doubleseats, $seattocheckright);
                                   $seatassigned = true;
                                   echo "was assigned";
                                   print_r($doubleseats);
                                   break;
                               } elseif (in_array($seattocheckleft, $seats)) {
                                   $doubleseats($seattocheck);
                                   array_push($doubleseats, $seattocheckleft);
                                   $seatassigned = true;
                                   break;
                               }
                            }

                        }
                        $checkright = true;
                        ++$seatscounted;
                    } elseif (!$checkleft) {
                        $findseat = ceil($numcols / 2) - $postn;
                        $stra = strval($row);
                        $strb = strval($findseat);
                        $seattocheck = $stra . $strb;

                        // check the array of seats available to find if it matches the current seat
                        foreach ($seats as $key => $value) {

                            // if the middle seat is available, assign it
                            if ($seattocheck == $value) {
                                // check if the neigh seat
                                $midright = $findseat + 1;
                                $stra = strval($row);
                                $strb = strval($midright);
                                $seattocheckright = $stra . $strb;

                                $midleft = ceil($numcols / 2) - 1;
                                $stra = strval($row);
                                $strb = strval($midleft);
                                $seattocheckleft = $stra . $strb;

                                if (in_array($seattocheckright, $seats)) {

                                    array_push($doubleseats, $seattocheck);
                                    // $doubleseats($seattocheck);
                                    array_push($doubleseats, $seattocheckright);
                                    $seatassigned = true;
                                    echo "was assigned";
                                    print_r($doubleseats);
                                    break;
                                } elseif (in_array($seattocheckleft, $seats)) {
                                    $doubleseats($seattocheck);
                                    array_push($doubleseats, $seattocheckleft);
                                    $seatassigned = true;
                                    break;
                                }
                            }

                        }

                        $checkleft = true;
                        ++$seatscounted;
                    } elseif ($checkleft && $checkright && !$seatassigned) {
                        $checkleft = false;
                        $checkright = false;
                        ++$postn;

                    }

                }

            }
        }
    } elseif ($seatrequest == 3) {
        echo "3 seat request";
    } else {
        echo "Invalid number of seats requested";
    }

} else {
    echo "error, submission not valid";
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
$arrayletters = array('0', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X ', 'Y', 'Z');

if ($seatrequest == 1) {
    $getrow = $seattocheck[0];
    $getnum = $seattocheck[1];
    $rowletter = $arrayletters[$getrow];
    $newseat = $rowletter . $getnum;

    echo "<h1> Best Seat Option: ", $newseat . "</h1>";

    // print_r($seats);

    $_SESSION['seat-num'] = $newseat;

} elseif ($seatrequest == 2) {

    print_r($doubleseats);
    $getfirstseat = $doubleseats[1][0];
    $seatletterone = $arrayletters[$getfirstseat];
    $firstcolnum = $doubleseats[1][1];
    $seatone = $seatletterone . $firstcolnum;

    $getsecondseat = $doubleseats[2][0];
    $seatlettertwo = $arrayletters[$getsecondseat];
    $secondcolnum = $doubleseats[2][1];
    $seattwo = $seatlettertwo . $secondcolnum;

    echo "<h1> Best Seat Option: ", $seatone . " , ", $seattwo . "</h1>";
}

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