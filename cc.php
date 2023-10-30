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
        if($debug) {echo "<br>$filename="; print_r($whitelist);}
    } else {
        if($debug) {echo "<br>$filename=not found";}
    }
    return $whitelist;
}

function check_rights($level="",$debug=false){
    $approved=false;
    if($level){
        if($debug) echo "<br><br>checking for $level rights";
        $level_list=get_file2arr("$level.txt",$debug=$debug);
        $cookie_index=0;
        while(!$approved && $cookie_index<count($_COOKIE)){
            $ck_item=assoc_index($_COOKIE,$cookie_index);
            if($debug) echo "<br>ck_item=$ck_item";
            if(in_array($ck_item,$level_list)) $approved=true;
            if($debug) echo "<br>approved=$approved";
            $cookie_index++;
        }
    }
    return $approved;
}

function set_system_status($status="closed",$status_filename="status.txt",$debug=false){
    if($debug) echo "<br>Setting system status (in $status_filename) to $status";
    file_put_contents($status_filename,$status);
}

function get_system_status($status_filename="status.txt",$debug=false){
    if(!file_exists($status_filename)){
        // create system status file as closed
        set_system_status($status_filename=$status_filename,$debug=$debug);
    }
    if($status){
        $status=get_file2arr($status_filename,$debug=$debug)[0];
        if($debug && $status){echo "<br><br>status=";print_r($status);}
    }
}

function cc_validate($debug=false){
    // 0. if no cookies, skip to step 3.
    if(count($_COOKIE)>0){
        // 1. check for admin, if found, case command
        $admin=check_rights("admin",$debug=$debug);
        if($admin){
            if($debug) echo "<br>Admin granted";
            $oc_array=array("open","close");
            $req_key="";
            foreach($oc_array as $oc_key){
                if(array_key_exists($oc_key,$_REQUEST)){
                    $req_key=$oc_key;
                }
            }

            if($req_key){
                $new_status=$req_key;
                if($debug) echo "<br>New status = $new_status";
                set_system_status($new_status,$debug=$debug);
            }
        } else {
            // 2. check for access, if found, grant access
            $access=check_rights("access",$debug=$debug);
        }
        // if either admin or access approved
        if($admin || $access){
            // permit access
        if($debug) echo "<br>Access granted";
        return true;
        }
    }
    // 3. check for site status, if open, create cookie and add to access list
    $status=get_system_status($debug);
    if($debug) echo "<br>System status=$status";
    if(in_array($status,array("open"))){
        if($debug) echo "<br>Generate cookie";
        if($debug) echo "<br>Set client cookie";
        if($debug) echo "<br>Add cookie to whitelist";
        if($debug) echo "<br>Access granted";
        return true;
    } else {
        if($debug) echo "<br>Access denied";
    }
    // 4. deny access
    return false;
}

?>