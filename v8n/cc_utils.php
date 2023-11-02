<?php

define('V8N_HOME',__DIR__);
define('STATUS_FILE',V8N_HOME.'/status.txt');
define('ADMIN_FILE',V8N_HOME.'/admin.txt');
define('ACCESS_FILE',V8N_HOME.'/access.txt');

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

function get_file2arr($filename,$debug=false){
    // get whitelist
    $whitelist = array();
    if(file_exists($filename)) {
        $whitelist = array_map('trim',explode("\n",file_get_contents($filename)));
        error_log( "GFA:$filename=". print_r($whitelist,true));
    } else {
        error_log("GFA:$filename=not found");
    }
    return $whitelist;
}

function check_rights($level="",$debug=false){
    $approved=false;
    $file_array=array("admin"=>ADMIN_FILE,"access"=>ACCESS_FILE);
    if(array_key_exists($level,$file_array)){
        error_log( "CR:checking for $level rights");
        $level_list=get_file2arr($file_array[$level],$debug=$debug);
        $cookie_index=0;
        while(!$approved && $cookie_index<count($_COOKIE)){
            $ck_item=assoc_index($_COOKIE,$cookie_index);
            error_log( "CR:ck_item=$ck_item");
            if(in_array($ck_item,$level_list)) $approved=true;
            error_log( "CR:approved=$approved");
            $cookie_index++;
        }
    }
    return $approved;
}

function clear_cookies(){
    error_log("CC:Clearing all cookies");
    foreach($_COOKIE as $k => $v){
        error_log("CC:Clearing $k => $v");
        setcookie($k,$v,time()-3600);
    }
}

function set_system_status($status,$status_filename,$debug=false){
    if($status=="") $status="close";
    if($status_filename=="") $status_filename=STATUS_FILE;
    error_log( "SSS:Setting system status (in $status_filename) to $status");
    // echo "SSS:Setting system status (in $status_filename) to $status";
    file_put_contents($status_filename,$status);
}

function get_system_status($status_filename,$debug=false){
    if($status_filename=="") $status_filename=STATUS_FILE;
    $status="";
    error_log( "GSS:Getting system status from $status_filename");
    if(!file_exists($status_filename)){
        // create system status file as closed
        $status="close";
        // set_system_status($status,$status_filename=$status_filename,$debug=$debug);
        error_log( "GSS:Setting system status (in $status_filename) to $status");
        // echo "GSS:Setting system status (in $status_filename) to $status";
        set_system_status($status,$status_filename,$debug);
    }
    if($status==""){
        $status=get_file2arr($status_filename,$debug)[0];
        error_log("GSS:Current system status (in $status_filename)=".print_r($status,true));
    }
    return $status;
}


?>