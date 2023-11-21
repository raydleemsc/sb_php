<?php

define('STATUS_FILE',V8N_HOME.'/status.txt');
define('ADMIN_FILE',V8N_HOME.'/admin.txt');
define('ACCESS_FILE',V8N_HOME.'/access.txt');
define('FILE_ARRAY',array("admin"=>ADMIN_FILE,"access"=>ACCESS_FILE));


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