<?php

foreach ($_SERVER as $key => $value) {
    echo $key.': '.print_r($value,true);
    $test = $_SERVER['DOCUMENT_ROOT'];
    if (isset($test) && ($test != '')) {
        echo "<br>";
        echo "<br>";
    } else {
        echo "\n";
    }
}

?>