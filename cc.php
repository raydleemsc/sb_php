<?php

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
    if(in_array($level,array("admin","access"))){
        error_log( "CR:checking for $level rights");
        $level_list=get_file2arr("$level.txt",$debug=$debug);
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
    if($status_filename=="") $status_filename="status.txt";
    error_log( "SSS:Setting system status (in $status_filename) to $status");
    // echo "SSS:Setting system status (in $status_filename) to $status";
    file_put_contents($status_filename,$status);
}

function get_system_status($status_filename,$debug=false){
    if($status_filename=="") $status_filename="status.txt";
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

function cc_validate($debug=false){
    $status_filename="status.txt";
    // 0. check for setcookie urlparm and setcookie then reload page
    foreach($_REQUEST as $k => $v){
        switch ($k) {
            case "setcookie":
                setcookie($v,$v);
                header("Refresh:0; url=/");
                continue;
            default:
                continue;
        }
    }
    // 1. if no cookies, skip to step 4.
    if(count($_COOKIE)>0){
        // 2. check for admin, if found, case command
        $admin=check_rights("admin",$debug=$debug);
        if($admin){
            error_log( "CCV:Admin granted");
            $oc_array=array("open","close");
            $req_key="";
            foreach($oc_array as $oc_key){
                if(array_key_exists($oc_key,$_REQUEST)){
                    $req_key=$oc_key;
                    break;
                }
            }

            if($req_key){
                $new_status=$req_key;
                error_log( "CCV:New status = $new_status");
                set_system_status($new_status,$status_filename,$debug);
            }
        } else {
            // 3. check for access, if found, grant access
            $access=check_rights("access",$debug=$debug);
        }
        // if either admin or access approved
        if($admin || $access){
            // permit access
        error_log( "CCV:Access granted");
        return true;
        } else {
            clear_cookies();
        }
    }
    // 4. check for site status, if open, create cookie and add to access list
    $status=get_system_status($status_filename,$debug);
    error_log( "CCV:System status=$status");
    if(in_array($status,array("open"))){
        error_log( "CCV:Generate cookie");
        $new_cookie="access_".(string)random_int(1698733138,time());
        error_log( "CCV:Add cookie=$new_cookie to whitelist");
        $fp = fopen("access.txt", 'a');
        fwrite($fp, $new_cookie.PHP_EOL);
        fclose($fp);
        error_log( "CCV:Set client cookie=$new_cookie");
        $try_cookie=false;
        $try_cookie=setcookie($new_cookie,$new_cookie);
        if(!$try_cookie) header("Refresh:0; url=/?setcookie=$new_cookie");
        error_log( "CCV:Access granted");
        return true;
    } else {
        error_log( "CCV:Access denied");
    }
    // 4. deny access
    return false;
}

?>