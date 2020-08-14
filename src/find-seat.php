<?php
session_start();

if (count($_POST) > 0) {
    define('ONE_SEAT', 1);
    define('TWO_SEAT', 2);
    define('THREE_SEAT', 3);
    $seats = $_SESSION['seats-available'];
    $seatrequest = $_POST['seat-choice'];
    $numrows = $_SESSION['rows'];
    $numcols = $_SESSION['cols'];
    $seatAssigned = false;
    $doubleseats = array();
    $tripleseats = array();
    $mid = ceil($numcols / 2);
    $status = false;
    $seatToCheck = array();

    if ($seatrequest == ONE_SEAT) {
        for ($row = 1; $row <= $numrows; $row++ && !$seatAssigned) {

            $postn = 1;
            $seatsCounted = 1;
            $checkMiddleSeat = false;
            $checkLeft = false;
            $checkRight = false;

            while ($seatsCounted <= $numcols && !$seatAssigned) {
                //    check if the best seat (front and center) is available
                if (!$checkMiddleSeat) {

                    processSeatRequest($row, $mid);
                    $checkMiddleSeat = true;

                } else {
                    //   check the right side of the best seat to determine if a seat is available
                    if (!$checkRight) {

                        $findSeat = ceil($numcols / 2) + $postn;
                        processSeatRequest($row, $findSeat);
                        $checkRight = true;
                        ++$seatsCounted;

                    } elseif (!$checkLeft) {
                        //   check the left side of the best seat to determine if a seat is available
                        $findSeat = ceil($numcols / 2) - $postn;
                        processSeatRequest($row, $findSeat);
                        $checkLeft = true;
                        ++$seatsCounted;

                    } elseif ($checkLeft && $checkRight && !$seatAssigned) {
                        $checkLeft = false;
                        $checkRight = false;
                        ++$postn;

                    }

                }

            }
        }
    } elseif ($seatrequest == TWO_SEAT) {
        global $doubleseats;
        // check the rows only if a seat has not been assigned
        for ($row = 1; $row <= $numrows; $row++ && !$seatAssigned) {
            $postn = 1;
            $seatsCounted = 1;
            $checkMiddleSeat = false;
           

            $checkLeft = false;
            $checkRight = false;

            while ($seatsCounted <= $numcols && !$seatAssigned) {
                
                //    first check the middle seat for assignment
                if (!$checkMiddleSeat) {

                    processTwoSeatRequest($row, $mid);
                    $checkMiddleSeat = true;

                } else {
                    //   check the left postion
                    if (!$checkRight) {
                        $findSeat = ceil($numcols / 2) + $postn;

                        processTwoSeatRequest($row, $findSeat);
                        $checkRight = true;
                        ++$seatsCounted;

                    } elseif (!$checkLeft) {
                        $findSeat = ceil($numcols / 2) - $postn;

                        processTwoSeatRequest($row, $findSeat);
                        $checkLeft = true;
                        ++$seatsCounted;

                    } elseif ($checkLeft && $checkRight && !$seatAssigned) {
                        $checkLeft = false;
                        $checkRight = false;
                        ++$postn;

                    }

                }

            }
        }
    } elseif ($seatrequest == 3) {
        global $tripleseats;
        // check the rows only if a seat has not been assigned
        for ($row = 1; $row <= $numrows; $row++ && !$seatToCheck) {
            $postn = 1;
            $seatsCounted = 1;
            $checkMiddleSeat = false;
            $empty = "";

            $checkLeft = false;
            $checkRight = false;

            while ($seatsCounted <= $numcols && !$seatAssigned) {
                $tripleseats = array($empty);
                //    first check the middle seat for assignment
                if (!$checkMiddleSeat) {
                    $mid = ceil($numcols / 2);
                    $stra = strval($row);
                    $strb = strval($mid);
                    $seatToCheck = $stra . $strb;
                    $leftseat = false;
                    $rightseat = false;

                    // print_r($seats);

                    // check the array of seats available to find if it matches the current seat
                    foreach ($seats as $key => $value) {

                        // if the middle seat is available, check if neighto right is avail
                        if ($seatToCheck == $value) {

                            // echo "the middle seat checks out";
                            // check if the neigh seat
                            $midright = ceil($numcols / 2) + 1;
                            $stra = strval($row);
                            $strb = strval($midright);
                            $seatTocheckRight = $stra . $strb;

                            // echo $seatTocheckRight, "the right seat";
                            // print_r($seats);

                            $midleft = ceil($numcols / 2) - 1;
                            $stra = strval($row);
                            $strb = strval($midleft);
                            $seatTocheckLeft = $stra . $strb;

                            if (in_array($seatTocheckRight, $seats)) {

                                // set the right seat as true
                                $rightseat = true;
                                // echo "the right seat checks out";

                            }
                            if (in_array($seatTocheckLeft, $seats)) {

                                // echo "the left seat checks out";

                                $leftseat = true;

                            }

                            if ($leftseat && $rightseat) {
                                array_push($tripleseats, $seatToCheck);

                                array_push($tripleseats, $seatTocheckRight);
                                array_push($tripleseats, $seatTocheckLeft);
                                $seatAssigned = true;
                                // echo "was found";
                                // print_r($tripleseats);
                                break;

                            } else {
                                // check if mid right +1 is true
                                if ($rightseat) {

                                    $rightmidright = $midright + 1;
                                    $newstra = strval($row);
                                    $newstrb = strval($rightmidright);
                                    $rightseatTocheckRight = $newstra . $newstrb;

                                    if (in_array($rightseatTocheckRight, $seats)) {

                                        array_push($tripleseats, $seatToCheck);

                                        array_push($tripleseats, $seatTocheckRight);
                                        array_push($tripleseats, $rightseatTocheckRight);
                                        $seatAssigned = true;
                                        echo "was found here";
                                        break;

                                    }

                                } else if ($leftseat) {
                                    // check the left side
                                    $leftmidleft = $midleft - 1;
                                    $newstra = strval($row);
                                    $newstrb = strval($leftmidleft);
                                    $leftseatTocheckLeft = $newstra . $newstrb;

                                    if (in_array($leftseatTocheckLeft, $seats)) {

                                        array_push($tripleseats, $seatToCheck);

                                        array_push($tripleseats, $seatTocheckLeft);
                                        array_push($tripleseats, $leftseatTocheckLeft);
                                        $seatAssigned = true;
                                        // echo "no luck either";
                                        break;
                                    }
                                }

                            }

                        }

                    }

                    $checkMiddleSeat = true;
                } else {
                    //   check the left postion
                    if (!$checkRight) {
                        $findSeat = ceil($numcols / 2) + $postn;
                        $stra = strval($row);
                        $strb = strval($findSeat);
                        $seatToCheck = $stra . $strb;

                        // check the array of seats available to find if it matches the current seat
                        foreach ($seats as $key => $value) {

                            // if the middle seat is available, assign it
                            if ($seatToCheck == $value) {
                                // check if the neigh seat
                                $midright = $findSeat + 1;
                                $stra = strval($row);
                                $strb = strval($midright);
                                $seatTocheckRight = $stra . $strb;

                                // echo $seatTocheckRight, "the right seat";
                                // print_r($seats);

                                $midleft = ceil($numcols / 2) - 1;
                                $stra = strval($row);
                                $strb = strval($midleft);
                                $seatTocheckLeft = $stra . $strb;

                                if (in_array($seatTocheckRight, $seats)) {

                                    // set the right seat as true
                                    $rightseat = true;
                                    // echo "the right seat checks out";

                                }
                                if (in_array($seatTocheckLeft, $seats)) {

                                    // echo "the left seat checks out";

                                    $leftseat = true;

                                }

                                if ($leftseat && $rightseat) {
                                    array_push($tripleseats, $seatToCheck);

                                    array_push($tripleseats, $seatTocheckRight);
                                    array_push($tripleseats, $seatTocheckLeft);
                                    $seatAssigned = true;
                                    // echo "was found";
                                    // print_r($tripleseats);
                                    break;

                                } else {
                                    // check if mid right +1 is true
                                    if ($rightseat) {

                                        $rightmidright = $midright + 1;
                                        $newstra = strval($row);
                                        $newstrb = strval($rightmidright);
                                        $rightseatTocheckRight = $newstra . $newstrb;

                                        if (in_array($rightseatTocheckRight, $seats)) {

                                            array_push($tripleseats, $seatToCheck);

                                            array_push($tripleseats, $seatTocheckRight);
                                            array_push($tripleseats, $rightseatTocheckRight);
                                            $seatAssigned = true;
                                            echo "was found here";
                                            break;

                                        }

                                    } else if ($leftseat) {
                                        // check the left side
                                        $leftmidleft = $midleft - 1;
                                        $newstra = strval($row);
                                        $newstrb = strval($leftmidleft);
                                        $leftseatTocheckLeft = $newstra . $newstrb;

                                        if (in_array($leftseatTocheckLeft, $seats)) {

                                            array_push($tripleseats, $seatToCheck);

                                            array_push($tripleseats, $seatTocheckLeft);
                                            array_push($tripleseats, $leftseatTocheckLeft);
                                            $seatAssigned = true;
                                            // echo "no luck either";
                                            break;
                                        }
                                    }

                                }

                            }

                        }
                        $checkRight = true;
                        ++$seatsCounted;
                    } elseif (!$checkLeft) {
                        $leftseat = false;
                        $rightseat = false;

                        $findSeat = ceil($numcols / 2) - $postn;
                        $stra = strval($row);
                        $strb = strval($findSeat);
                        $seatToCheck = $stra . $strb;

                        // check the array of seats available to find if it matches the current seat
                        foreach ($seats as $key => $value) {

                            // if the middle seat is available, assign it
                            if ($seatToCheck == $value) {
                                // check if the neigh seat
                                $midright = $findSeat + 1;
                                $stra = strval($row);
                                $strb = strval($midright);
                                $seatTocheckRight = $stra . $strb;

                                // echo $seatTocheckRight, "the right seat";
                                // print_r($seats);

                                $midleft = $findSeat - 1;
                                $stra = strval($row);
                                $strb = strval($midleft);
                                $seatTocheckLeft = $stra . $strb;

                                if (in_array($seatTocheckRight, $seats)) {

                                    // set the right seat as true
                                    $rightseat = true;

                                    // echo "the right seat checks out";

                                }
                                if (in_array($seatTocheckLeft, $seats)) {

                                    // echo "the left seat checks out";

                                    $leftseat = true;

                                }

                                if ($leftseat && $rightseat) {

                                    array_push($tripleseats, $seatToCheck);

                                    array_push($tripleseats, $seatTocheckRight);
                                    array_push($tripleseats, $seatTocheckLeft);
                                    $seatAssigned = true;
                                    // echo "was found";
                                    // print_r($tripleseats);
                                    break;

                                } else {
                                    // check if mid right +1 is true

                                    if ($rightseat) {

                                        $rightmidright = $midright + 1;
                                        $newstra = strval($row);
                                        $newstrb = strval($rightmidright);
                                        $rightseatTocheckRight = $newstra . $newstrb;

                                        if (in_array($rightseatTocheckRight, $seats)) {

                                            array_push($tripleseats, $seatToCheck);

                                            array_push($tripleseats, $seatTocheckRight);
                                            array_push($tripleseats, $rightseatTocheckRight);
                                            $seatAssigned = true;
                                            echo "was found here";
                                            break;

                                        }

                                    } else if ($leftseat) {
                                        echo "should execute", $midleft;

                                        // check the left side
                                        $leftmidleft = $midleft - 1;
                                        $newstra = strval($row);
                                        $newstrb = strval($leftmidleft);
                                        $leftseatTocheckLeft = $newstra . $newstrb;

                                        if (in_array($leftseatTocheckLeft, $seats)) {

                                            array_push($tripleseats, $seatToCheck);

                                            array_push($tripleseats, $seatTocheckLeft);
                                            array_push($tripleseats, $leftseatTocheckLeft);
                                            $seatAssigned = true;
                                            // echo "no luck either";
                                            break;
                                        }
                                    }

                                }

                            }
                        }

                        $checkLeft = true;
                        ++$seatsCounted;
                    } elseif ($checkLeft && $checkRight && !$seatAssigned) {
                        $checkLeft = false;
                        $checkRight = false;
                        ++$postn;

                    }

                }

            }
        }
    } else {
        echo "Invalid number of seats requested";
    }

} else {
    echo "error, submission not valid";
}

function convertIntToAlphabet($i)
{
    $arrayletters = array('0', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X ', 'Y', 'Z');

    $letter = $arrayletters[$i];

    return $letter;
}

function convertSeatFromIntToString($row, $col)
{
    $rowString = strval($row);
    $colString = strval($col);
    $seatInStringForm = $rowString . $colString;

    return $seatInStringForm;

}

function determineIfSeatIsAvailable($row, $col)
{
    global $seatToCheck;
    $seatStatus = false;

    $seatToCheck = convertSeatFromIntToString($row, $col);

    $seatStatus = findSeatAmongSeatsAvailable($seatToCheck);

    return $seatStatus;
}

function findSeatAmongSeatsAvailable($seat)
{
    $status = false;
    $seats = $_SESSION['seats-available'];

    if (in_array($seat, $seats)) {
        $status = true;

    }

    return $status;

}

function processSeatStatus($status)
{
    global $seatAssigned;

    if ($status) {
        $seatAssigned = true;

    }

}

function processSeatRequest($row, $col)
{
    $status = determineIfSeatIsAvailable($row, $col);
    processSeatStatus($status);
}

function processTwoSeatRequest($row, $col){

    global $seatToCheck;
    global $seatAssigned;
    global $doubleseats;

    $status = determineIfSeatIsAvailable($row, $col);

    if ($status) {

        // check if the neigh seat
        $midright = $col + 1;
        $midleft = $col - 1;

        $seatTocheckRight = convertSeatFromIntToString($row, $midright);
        $seatTocheckLeft = convertSeatFromIntToString($row, $midleft);

        $statusForRightSeat = findSeatAmongSeatsAvailable($seatTocheckRight);
        $statusForLeftSeat = findSeatAmongSeatsAvailable($seatTocheckLeft);

        if ($statusForRightSeat) {
            array_push($doubleseats, $seatToCheck);
            array_push($doubleseats, $seatTocheckRight);
            $seatAssigned = true;

        } else if ($statusForLeftSeat) {
            array_push($doubleseats, $seatToCheck);
            array_push($doubleseats, $seatTocheckLeft);
            $seatAssigned = true;

        }
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

<body class="seat-page">


    <div class="content">

        <ul class='topnav'>
            <li><a class='logo' href='index.html'>The Venue</a></li>

        </ul>

        <div class="w3-display-middle w3-padding">


            <?php
if ($seatrequest == ONE_SEAT) {
    $rowNum = $seatToCheck[0];
    $colNum = $seatToCheck[1];
    $rowLetter = convertIntToAlphabet($rowNum);
    $finalseatAssigned = $rowLetter . $colNum;

    echo "<h1> Best Seat Option: ", $finalseatAssigned . "</h1>";

} elseif ($seatrequest == TWO_SEAT) {

    $getfirstseat = $doubleseats[0][0];
    $seatletterone = convertIntToAlphabet($getfirstseat);
    $firstcolnum = $doubleseats[0][1];
    $seatone = $seatletterone . $firstcolnum;

    $getsecondseat = $doubleseats[1][0];
    $seatlettertwo = convertIntToAlphabet($getsecondseat);
    $secondcolnum = $doubleseats[1][1];
    $seattwo = $seatlettertwo . $secondcolnum;

    echo "<h1> Best Seat Option: ", $seatone . " , ", $seattwo . "</h1>";
} elseif ($seatrequest == 3) {

    $getfirstseat = $tripleseats[1][0];
    $seatletterone = $arrayletters[$getfirstseat];
    $firstcolnum = $tripleseats[1][1];
    $seatone = $seatletterone . $firstcolnum;

    $getsecondseat = $tripleseats[2][0];
    $seatlettertwo = $arrayletters[$getsecondseat];
    $secondcolnum = $tripleseats[2][1];
    $seattwo = $seatlettertwo . $secondcolnum;

    $getthirdseat = $tripleseats[3][0];
    $seatletterthree = $arrayletters[$getsecondseat];
    $thirdcolnum = $tripleseats[3][1];
    $seatthree = $seatletterthree . $thirdcolnum;

    echo "<h1> Best Seat Option: ", $seatone . " , ", $seattwo . ", ", $seatthree . "</h1>";

}

?>

            <div class="w3-container w3-center">
                <br><br>
                <p>
                    <a class="w3-btn w3-black" href="index.html">Thank you, order complete</a> </p>




            </div>
        </div>

    </div>
</body>

</html>