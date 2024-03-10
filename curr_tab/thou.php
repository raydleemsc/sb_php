<?php

$fname=$argv[1].'.php';

if(file_exists($fname)){
    for ($i=0; $i < 1000; $i++) { 
        include($fname);
    }
} else {
    echo $fname.' not found';
}

?>