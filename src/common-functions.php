<?php


function determineIfSeatIsAvailable($row, $col)
{
    global $seatToCheck;
    $seatStatus = false;

    $seatToCheck = convertSeatFromIntToString($row, $col);
    $seatStatus = findSeatAmongSeatsAvailable($seatToCheck);

    return $seatStatus;
}

function convertSeatFromIntToString($row, $col)
{
    $rowString = strval($row);
    $colString = strval($col);
    $seatInStringForm = $rowString . $colString;

    return $seatInStringForm;
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
