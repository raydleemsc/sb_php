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

function b2s ($value) { return (gettype($value)=='boolean' && $value?"true":"false"); }

// cookie checker

function cc_validate($debug=false){

    // set whitelist filename
    $wl_filename = "whitelist.txt";
    // set urlparm not valid
    $urlparm_validity = false;
    // set cookie not valid
    $cookie_validity = false;

    // get urlparm
    $urlparm = parse_url($_SERVER['REQUEST_URI'])["query"];
    if($debug) echo "<br>urlparm=$urlparm";
    // get cookies
    $cookies = $_COOKIE;
    if($debug) {echo "<br>request="; print_r($_REQUEST);}
    if($debug) {echo "<br>cookie="; print_r($_COOKIE);}
    if($debug) {echo "<br>cookies="; print_r($cookies);}
    // get whitelist
    $whitelist = array();
    if(file_exists($wl_filename)) $whitelist = explode("\n",file_get_contents($wl_filename));
    if($debug) {echo "<br>whitelist="; print_r($whitelist);}

    $cookie_index = 0;
    // for each cookie while cookie and urlparm not valid,
    while ( ( $cookie_index < count( $cookies ) ) && !$urlparm_validity ) {
        $ck_item = assoc_index($cookies,$cookie_index);
        // if urlparm, if urlparm equals cookie - set valid urlparm
        if($urlparm && $urlparm==$ck_item) $urlparm_validity = true;
        // for each whitelist while cookie and urlparm not valid,
        $wl_index = 0;
        while($wl_index<count($whitelist) && !$urlparm_validity && !$cookie_validity){
            // if cookie equals whitelist, set valid cookie
            if($ck_item==assoc_index($whitelist,$wl_index++)) $cookie_validity = true;
        }
        $cookie_index++;
    }
    if($debug) echo "<br>urlparm_validity=".b2s($urlparm_validity).", cookie_validity=".b2s($cookie_validity);
    return array($urlparm_validity, $cookie_validity);

}

?>