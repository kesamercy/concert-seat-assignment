<?php
session_start();
include('common-functions.php');

if (count($_POST) > 0) {
    define('ONE_SEAT', 1);
    define('TWO_SEAT', 2);
    define('THREE_SEAT', 3);
    $seats = $_SESSION['seats-available'];
    $seatRequest = $_POST['seat-choice'];
    $numRows = $_SESSION['rows'];
    $numCols = $_SESSION['cols'];
    $seatAssigned = false;
    $twoSeats = array();
    $threeSeats = array();
    $mid = ceil($numCols / 2);
    $status = false;
    $seatToCheck = array();

    if ($seatRequest == ONE_SEAT) {
        for ($row = 1; $row <= $numRows; $row++ && !$seatAssigned) {
            initializeFunctionVariables();

            while ($seatsCounted <= $numCols && !$seatAssigned) {

                if (!$checkMiddleSeat) {

                    processSingleSeatRequest($row, $mid);
                    $checkMiddleSeat = true;

                } elseif (!$checkRight) {

                    $findSeat = $mid + $postn;
                    processSingleSeatRequest($row, $findSeat);
                    $checkRight = markSeatAsChecked($checkRight);

                } elseif (!$checkLeft) {

                    $findSeat = $mid - $postn;
                    processSingleSeatRequest($row, $findSeat);
                    $checkLeft = markSeatAsChecked($checkLeft);

                } elseif ($checkLeft && $checkRight && !$seatAssigned) {
                    resetFunctionVariables();

                }

            }
        }
    } elseif ($seatRequest == TWO_SEAT) {
        global $twoSeats;
        for ($row = 1; $row <= $numRows; $row++ && !$seatAssigned) {
            initializeFunctionVariables();

            while ($seatsCounted <= $numCols && !$seatAssigned) {

                if (!$checkMiddleSeat) {

                    processTwoSeatRequest($row, $mid);
                    $checkMiddleSeat = true;

                } elseif (!$checkRight) {

                    $findSeat = $mid + $postn;
                    processTwoSeatRequest($row, $findSeat);
                    $checkRight = markSeatAsChecked($checkRight);

                } elseif (!$checkLeft) {

                    $findSeat = $mid - $postn;
                    processTwoSeatRequest($row, $findSeat);
                    $checkLeft = markSeatAsChecked($checkLeft);

                } elseif ($checkLeft && $checkRight && !$seatAssigned) {
                    resetFunctionVariables();

                }

            }
        }
    } elseif ($seatRequest == THREE_SEAT) {
        global $threeSeats;
        for ($row = 1; $row <= $numRows; $row++ && !$seatAssigned) {
            initializeFunctionVariables();

            while ($seatsCounted <= $numCols && !$seatAssigned) {

                if (!$checkMiddleSeat) {

                    $leftseat = false;
                    $rightseat = false;

                    $status = determineIfSeatIsAvailable($row, $mid);

                    if ($status) {

                        $midright = $mid + 1;
                        $midleft = $mid - 1;

                        $seatTocheckRight = convertSeatFromIntToString($row, $midright);
                        $seatTocheckLeft = convertSeatFromIntToString($row, $midleft);

                        $statusForRightSeat = findSeatAmongSeatsAvailable($seatTocheckRight);
                        $statusForLeftSeat = findSeatAmongSeatsAvailable($seatTocheckLeft);

                        if ($statusForRightSeat) {
                            $rightseat = true;

                        }
                        if ($statusForLeftSeat) {
                            $leftseat = true;

                        }

                        if ($leftseat && $rightseat) {
                            array_push($threeSeats, $seatToCheck, $seatTocheckRight, $seatTocheckLeft);
                            $seatAssigned = true;

                        } else if ($rightseat) {

                                $rightmidright = $midright + 1;
                                processThreeSeatAllocation($row, $midright, $seatTocheckRight);

                            } else if ($leftseat) {

                                $leftmidleft = $midleft - 1;
                                processThreeSeatAllocation($row, $midleft, $seatTocheckLeft);
                            }


                    }
                    $checkMiddleSeat = true;

                } else if (!$checkRight) {
                    $findSeat = $mid + $postn;
                    $status = determineIfSeatIsAvailable($row, $findSeat);

                    if ($status) {

                        $midright = $findSeat + 1;
                        determineThreeSeatsAvailablilty($row, $midright, false);

                    }
                    $checkRight = markSeatAsChecked($checkRight);

                } elseif (!$checkLeft) {
                    $findSeat = $mid - $postn;
                    $status = determineIfSeatIsAvailable($row, $findSeat);

                    if ($status) {
                        $midleft = $findSeat - 1;
                        determineThreeSeatsAvailablilty($row, $midleft, true);
                    }

                    $checkLeft = markSeatAsChecked($checkLeft);

                } elseif ($checkLeft && $checkRight && !$seatAssigned) {
                    resetFunctionVariables();
                }

            }
        }
    } else {
        echo "Invalid number of seats requested";
    }

} else {
    echo "error, submission not valid";
}

function determineThreeSeatsAvailablilty($row, $col, $left)
{

    $seatTocheck = convertSeatFromIntToString($row, $col);
    $seatTocheckStatus = findSeatAmongSeatsAvailable($seatTocheck);

    if ($seatTocheckStatus) {
        if ($left) {
            $leftSeat = $col - 1;
        } else {
            $leftSeat = $col + 1;
        }

        processThreeSeatAllocation($row, $leftSeat, $seatTocheck);

    }

}

function processThreeSeatAllocation($row, $col, $secondSeat)
{
    global $seatToCheck;
    global $seatAssigned;
    global $threeSeats;

    $thirdSeat = convertSeatFromIntToString($row, $col);
    $thirdSeatStatus = findSeatAmongSeatsAvailable($secondSeat);

    if ($thirdSeatStatus) {

        array_push($threeSeats, $seatToCheck, $secondSeat, $thirdSeat);
        $seatAssigned = true;

    }

}
function markSeatAsChecked($seatChecked)
{
    global $seatsCounted;

    $seatChecked = true;
    ++$seatsCounted;

    return $seatChecked;

}

function resetFunctionVariables()
{
    global $postn;
    global $checkLeft;
    global $checkRight;

    $checkLeft = false;
    $checkRight = false;
    ++$postn;

}

function initializeFunctionVariables()
{
    global $postn;
    global $seatsCounted;
    global $checkMiddleSeat;
    global $checkLeft;
    global $checkRight;

    $postn = 1;
    $seatsCounted = 1;
    $checkMiddleSeat = false;

    $checkLeft = false;
    $checkRight = false;
}

function convertIntToAlphabet($i)
{
    $arrayletters = array('0', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X ', 'Y', 'Z');

    $letter = $arrayletters[$i];

    return $letter;
}
function processSeatStatus($status)
{
    global $seatAssigned;

    if ($status) {
        $seatAssigned = true;

    }

}

function processSingleSeatRequest($row, $col)
{
    $status = determineIfSeatIsAvailable($row, $col);
    processSeatStatus($status);
}

function processTwoSeatRequest($row, $col)
{

    global $seatToCheck;
    global $seatAssigned;
    global $twoSeats;

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
            array_push($twoSeats, $seatToCheck, $seatTocheckRight);

            $seatAssigned = true;

        } else if ($statusForLeftSeat) {
            array_push($twoSeats, $seatToCheck, $seatTocheckLeft);
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
            <li><a class='logo' href='index.php'>The Venue</a></li>

        </ul>

        <div class="w3-display-middle w3-padding">


            <?php
        if ($seatRequest == ONE_SEAT) {

            if (!empty($seatToCheck)) {
                $rowNum = $seatToCheck[0];
                $colNum = $seatToCheck[1];
                $rowLetter = convertIntToAlphabet($rowNum);
                $finalseatAssigned = $rowLetter . $colNum;

                echo "<h1> Best Seat Option: ", $finalseatAssigned . "</h1>";
            } else {
                echo "<h1>Sorry, no seats available</h1>";
            }

        } elseif ($seatRequest == TWO_SEAT) {

            if (!empty($twoSeats)) {

                $getfirstseat = $twoSeats[0][0];
                $seatletterone = convertIntToAlphabet($getfirstseat);
                $firstcolnum = $twoSeats[0][1];
                $seatone = $seatletterone . $firstcolnum;

                $getsecondseat = $twoSeats[1][0];
                $seatlettertwo = convertIntToAlphabet($getsecondseat);
                $secondcolnum = $twoSeats[1][1];
                $seattwo = $seatlettertwo . $secondcolnum;

                echo "<h1> Best Seat Option: ", $seatone . " , ", $seattwo . "</h1>";
            } else {
                echo "<h1>Sorry, two seats are not available</h1>";
            }

        } elseif ($seatRequest == THREE_SEAT) {

            if (!empty($threeSeats)) {
                # code...

                $getfirstseat = $threeSeats[0][0];
                $seatletterone = convertIntToAlphabet($getfirstseat);
                $firstcolnum = $threeSeats[0][1];
                $seatone = $seatletterone . $firstcolnum;

                $getsecondseat = $threeSeats[1][0];
                $seatlettertwo = convertIntToAlphabet($getsecondseat);
                $secondcolnum = $threeSeats[1][1];
                $seattwo = $seatlettertwo . $secondcolnum;

                $getthirdseat = $threeSeats[2][0];
                $seatletterthree = convertIntToAlphabet($getthirdseat);
                $thirdcolnum = $threeSeats[2][1];
                $seatthree = $seatletterthree . $thirdcolnum;

                echo "<h1> Best Seat Option: ", $seatone . " , ", $seattwo . ", ", $seatthree . "</h1>";
            } else {
                echo "<h1>Sorry, three seats are not available</h1>";
            }

        }

        ?>

            <div class="w3-container w3-center">
                <br><br>
                <p>
                    <a class="w3-btn w3-black" href="index.php">Thank you, order complete</a> </p>




            </div>
        </div>

    </div>
</body>

</html>