<?php


if (count($_POST) > 0) {
    $venue = $_POST['venue'];

    if ($venue == "madison") {
        $content = parseJsonFile("assets/madison.json");
        $result = printValues($content);
        // echo "<h3>" . $result["total"] . " value(s) found: </h3>";
        echo "<p>Madison</p>";
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

    if (file_exists($filename)) {

        $json = file_get_contents($filename);
        if (!empty($json)) {

            $filecontent = json_decode($json, true);
        } else {
            echo "Error, Json file has no content";
        }

    } else {
        echo "Error, The file does not exist.";
    }

    return $filecontent;
}

