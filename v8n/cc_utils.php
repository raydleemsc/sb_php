<?php

require_once('cc_storage.php');

define('DEBUG_DEFAULT',true);

define('ACCESS_URL','/');
define('NOACCESS_URL','/login2.php');

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

function set_system_status($status,$status_filename,$debug=DEBUG_DEFAULT){
    if($status=="") $status="close";
    if($status_filename=="") $status_filename=STATUS_FILE;
    if($debug) error_log( "SSS:Setting system status (in $status_filename) to $status");
    // echo "SSS:Setting system status (in $status_filename) to $status";
    file_put_contents($status_filename,$status);
}

function get_system_status($status_filename,$debug=DEBUG_DEFAULT){
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

function set_admin($debug=DEBUG_DEFAULT){

    // Dangerous to leave unsecured
    // 1698733138 is used as it is the base time for generation of this module
    // It is also the lower bound for the randomly generated access cookies

    $set_file=false;
    $set_cookie=false;
    $admin_cookie="";
    foreach($_COOKIE as $k => $v){
        if($k==$v && substr($k,0,6)=="admin_") {
            $admin_cookie=$k;
            if($debug) error_log("SA:Found admin_cookie in cookies - $admin_cookie");
            $set_cookie=true;
            break;
        }
    }
    if(!$admin_cookie) {
        $admin_cookie="admin_".(string)random_int(1698733138,time());
        if($debug) error_log("SA:Set new admin_cookie=$admin_cookie");
    }

    $af_contents=get_file2arr(ADMIN_FILE);
    foreach($af_contents as $af_item){
        if($admin_cookie==$af_item) $set_file=true;
    }

    if(!$set_file){
        $filemode=file_exists(ADMIN_FILE)?'a':'w';
        // if(!file_exists(ADMIN_FILE)) $filemode='w';
        if($debug) error_log("SA:filemode=$filemode");
        // error_log("SA:file_exists(ADMIN_FILE)=".(string)file_exists(ADMIN_FILE));
        $fp = fopen(ADMIN_FILE, file_exists(ADMIN_FILE)?'a':'w');
        if($fp){
            fwrite($fp, $admin_cookie.PHP_EOL);
            fclose($fp);
        }else{
            if($debug) error_log("SA:ERROR:Write to ".ADMIN_FILE." not possible");
        }
    } else if($debug) error_log("SA:Cookie $admin_cookie already found in admin file.");
    if(!$set_cookie){
        $arr_cookie_options = array ('' // empty string to enable comma prefix on array member lines below
            // ,'expires' => time() + 60*60*24*30 // number of seconds from epoch start
            ,'path' => '/'
            // ,'domain' => '.example.com' // leading dot for compatibility or use subdomain
            // ,'secure' => true     // or false - available only to https connections
            // ,'httponly' => true    // or false - available only to http connections
            // ,'samesite' => 'None' // None || Lax  || Strict - CORS policy adherance
            //   from https://web.dev/articles/samesite-cookies-explained
            //   RFC6265bis - https://datatracker.ietf.org/doc/html/draft-ietf-httpbis-cookie-same-site-00
            );
        // setcookie('TestCookie', 'The Cookie Value', $arr_cookie_options);  
        setcookie("admin_cookie", $admin_cookie, $arr_cookie_options);
        if($debug) error_log("SA:_COOKIE=".print_r($_COOKIE,true));
    }
    header("Refresh:0; url=".(ACCESS_URL));
}

?>