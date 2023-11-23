<?php

echo "PHP CC command\n";

require_once("utils.php");
// var_dump($argc); //number of arguments passed 
// var_dump($argv); //the arguments passed
$start=1;
if ($argc>$start){
    // echo "processing: ";
    // var_dump($argv);
    for ($x=$start; $x < count($argv); $x++) { 
        echo "$x:$argv[$x]\n";
    }
}

?>