<?php

require_once('utils_config.php');
require_once('storage.php');

function assoc_index ($arr, $index) {
    $return_value = "";
    if ($index < count($arr)) {
        $ci=0;
        foreach($arr as $val){
            if(($ci++)==$index){
                $return_value = $val;
            }
        }
    }
    return $return_value;
}

function check_rights($level="",$debug=DEBUG_DEFAULT){
    $approved=false;
    $file_array=FILE_ARRAY;
    if(array_key_exists($level,$file_array)){
        if($debug) error_log( "CR:checking for $level rights");
        $level_list=get_file2arr($file_array[$level],$debug=$debug);
        $cookie_index=0;
        while($approved==false && $cookie_index<count($_COOKIE)){
            $ck_item=assoc_index($_COOKIE,$cookie_index);
            if($debug) error_log( "CR:ck_item=$ck_item");
            if(in_array($ck_item,$level_list)) $approved=$ck_item;
            if($debug) error_log( "CR:approved=$approved");
            $cookie_index++;
        }
    }
    return $approved;
}

function clear_cookies($debug=DEBUG_DEFAULT){
    if($debug) error_log("CC:Clearing all cookies");
    foreach($_COOKIE as $k => $v){
        if($debug) error_log("CC:Clearing $k => $v");
        setcookie($k,$v,time()-3600);
    }
}

function set_system_status($status,$status_filename="",$debug=DEBUG_DEFAULT){
    if($status=="") $status="close";
    if($status_filename=="") $status_filename=STATUS_FILE;
    if($debug) error_log( "SSS:Setting system status (in $status_filename) to $status");
    // echo "SSS:Setting system status (in $status_filename) to $status";
    file_put_contents($status_filename,$status);
}

function get_system_status($status_filename="",$debug=DEBUG_DEFAULT){
    if($status_filename=="") $status_filename=STATUS_FILE;
    $status="";
    if($debug) error_log( "GSS:Getting system status from $status_filename");
    if(!file_exists($status_filename)){
        // create system status file as closed
        $status="close";
        // set_system_status($status,$status_filename=$status_filename,$debug=$debug);
        if($debug) error_log( "GSS:Setting system status (in $status_filename) to $status");
        // echo "GSS:Setting system status (in $status_filename) to $status";
        set_system_status($status,$status_filename,$debug);
    }
    if($status==""){
        $status=get_file2arr($status_filename,$debug)[0];
        if($debug) error_log("GSS:Current system status (in $status_filename)=".print_r($status,true));
    }
    return $status;
}

?>