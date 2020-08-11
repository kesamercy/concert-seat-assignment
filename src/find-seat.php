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

}
else {
    echo "error, the prog did not work";
}

?>
