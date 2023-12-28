<?php

function arrpos($haystack, $needles){

    switch(gettype($needles)){
        case 'array':
            break;
        case 'string':
            $needles = explode(" ", $needles);
            break;
        case 'boolean':
        case 'integer':
        case 'double':
        case 'object':
        case 'resource':
            $needles = array ( $needles );
            break;
        default:
            $needles = array ( $needles );
        }

    $i=0;
    $found = 0;
    foreach ($needles as $needle) {
        if($needle && gettype($needle)=='string'){
            $sp = strpos($haystack,$needle);
            if($sp && !$found)$found=$i;
        }
        $i++;
    }
    return $found;
}


?>