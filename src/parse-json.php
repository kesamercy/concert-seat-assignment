<?php

function parseJsonFile($filename)
{

    if (file_exists($filename)) {

        $json = file_get_contents($filename);
        if (!empty($json)) {
            var_dump(json_decode($json, true));
            // $filecontent = json_decode($json, true);
        } else {
            echo "Error, Json file has no content";
        }

    } else {
        echo "Error, The file does not exist.";
    }

    // return $filecontent;
}

parseJsonFile("assets/madison.json");
