<?php

require_once('storage_files_config.php');

function get_file2arr($filename,$debug=DEBUG_DEFAULT){
    // get whitelist
    $whitelist = array();
    if(file_exists($filename)) {
        $whitelist = array_map('trim',explode("\n",file_get_contents($filename)));
        if($debug) error_log( "GFA:$filename=". print_r($whitelist,true));
    } else {
        if($debug) error_log("GFA:$filename=not found");
    }
    return $whitelist;
}

?>