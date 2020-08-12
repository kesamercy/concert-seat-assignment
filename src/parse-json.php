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

    if ($venue == "madison") {
        $content = parseJsonFile("assets/madison.json");
        $result = printValues($content);
        echo "<h3>" . $result["total"] . " value(s) found: </h3>";
        echo implode("<br>", $result["values"]);

        // get the number of rows and cols.accordion
        // get the list of the number of seats available. 
        // draw the seat for the stadium based on the number of rows and cols
        // add an image of empty seat to all the seats
        // add an image of available seat to all the open seats based on the return from the json
        




    } elseif ($venue == "criscross") {
        $content = parseJsonFile("assets/criscross.json");
        $result = printValues($content);
        echo "<h3>" . $result["total"] . " value(s) found: </h3>";
        echo "<p> Welcome Criscross</p>";
    } elseif ($venue == "kenedy") {
        $content = parseJsonFile("assets/kenedy.json");
        $result = printValues($content);
        echo "<h3>" . $result["total"] . " value(s) found: </h3>";
        echo "<p> Welcome Kenedy</p>";
    } else {
        echo "Error, invalid input";
    }

}

function printValues($arr) {
    global $count;
    global $values;
    
    // Check input is an array
    if(!is_array($arr)){
        die("ERROR: Input is not an array");
    }
    
    /*
    Loop through array, if value is itself an array recursively call the
    function else add the value found to the output items array,
    and increment counter by 1 for each value found
    */
    foreach($arr as $key=>$value){
        if(is_array($value)){
            printValues($value);
        } else{
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
            $numrows =  $filecontent['venue']['layout']['rows'];
            $numcols =  $filecontent['venue']['layout']['column'];

            $seats = array($newval);


            foreach($filecontent['seats'] as $key=>$value){
                // echo $value['row'];
                // echo $value['column'];

                $postn = ord(strtoupper($value['row'])) - ord('A') + 1;
                // echo $postn;

                $rowstr = strval($postn);
                $colstr = strval($value['column']);

                $newval = $rowstr.$colstr;

                
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

<body>


    <?php

    // echo $numcols;
    // echo $numrows;

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
            $newab = $stra.$strb;
           
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
        $b =0;
    }
    echo "</table>"

    
    ?>

    <div>
        <form method="post" action="find-seat.php">
            <label for="seat-choice">How many seats would you like to book:</label>

            <select id="seat-choice" name="seat-choice">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <!-- <input type="hidden" name="seats-avail" value="$seats" id=""> -->
            <input type="submit" value="Submit">
        </form>


    </div>

    <script>
    </script>

</body>

</html>