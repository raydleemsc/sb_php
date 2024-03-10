<?php

if(isset($argv[1])){
    $thou_fname=$argv[1].'.php';

    $limit = 1;
    if(isset($argv[2])){
        if(is_numeric($argv[2])){
            $limit = (int)$argv[2];
        }
    }

    if(file_exists($thou_fname)){
        for ($thou_i=0; $thou_i < $limit; $thou_i++) { 
            include($thou_fname);
        }
    } else {
        echo $thou_fname.' not found';
    }
}
