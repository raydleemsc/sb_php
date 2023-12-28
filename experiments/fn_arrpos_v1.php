<?php

function arrpos($haystack, $needles){
    $i=0;
    $found = 0;
    foreach ($needles as $needle) {
        if($needle){
            $sp = strpos($haystack,$needle);
            if($sp && !$found)$found=$i;
        }
        $i++;
    }
    return $found;
}


?>