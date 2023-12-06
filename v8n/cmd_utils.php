<?php

require_once('utils.php');


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
    // header("Refresh:0; url=".(ACCESS_URL));
}


?>