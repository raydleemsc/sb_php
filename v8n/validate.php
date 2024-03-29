<?php

require_once('utils.php');

function validate($debug=DEBUG_DEFAULT){
    $status_filename=STATUS_FILE;
    // 0. check for setcookie urlparm and setcookie then reload page
    foreach($_REQUEST as $k => $v){
        switch ($k) {
            case "setcookie":
                $vk=$v;
                $vv=$v;
                if(strpos($v,":")){
                    $v_colon=strpos($v,":");
                    $vk=substr($v,0,$v_colon);
                    $vv=substr($v,$v_colon+1);
                }
                if($debug) error_log("CCV:Setting cookie, vk=$vk, vv=$vv");
                setcookie($vk,$vv);
                break;
            default:
                break;
        }
    }
    // 1. if no cookies, skip to step 4.
    if(count($_COOKIE)>0){
        // 2. check for admin, if found, case command
        $admin=check_rights("admin",$debug=$debug);
        if($admin){
            if($debug) error_log( "CCV:Admin granted");
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
                if($debug) error_log( "CCV:New status = $new_status");
                set_system_status($new_status,$status_filename,$debug);
            }
        } else {
            // 3. check for access, if found, grant access
            $access=check_rights("access",$debug=$debug);
        }
        // if either admin or access approved
        if($admin || $access){
            // permit access
            if($debug) error_log( "CCV:Access granted");
            return true;
        } else {
            clear_cookies($debug);
        }
    }
    // 4. check for site status, if open, create cookie and add to access list
    $status=get_system_status($status_filename,$debug);
    if($debug) error_log( "CCV:System status=$status");
    if(in_array($status,array("open"))){
        if($debug) error_log( "CCV:Generate cookie");
        $new_cookie="access_".(string)random_int(1698733138,time());
        if($debug) error_log( "CCV:Add cookie=$new_cookie to whitelist");
        $fp = fopen(ACCESS_FILE, 'a');
        fwrite($fp, $new_cookie.PHP_EOL);
        fclose($fp);
        if($debug) error_log( "CCV:Set client cookie=$new_cookie");
        $try_cookie=false;
        $try_cookie=setcookie($new_cookie,$new_cookie);
        if(!$try_cookie) header("Refresh:0; url=/?setcookie=access_cookie:$new_cookie");
        if($debug) error_log( "CCV:Access granted");
        return true;
    } else {
        if($debug) error_log( "CCV:Access denied");
    }
    // 4. deny access
    return false;
}

?>