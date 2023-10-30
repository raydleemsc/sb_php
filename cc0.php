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
    if(file_exists($wl_filename)) $whitelist = array_map('trim',explode("\n",file_get_contents($wl_filename)));
    if($debug) {echo "<br>whitelist="; print_r($whitelist);}

    if($debug) echo "<br>";
    $cookie_index = 0;
    // for each cookie while cookie and urlparm not valid,
    while ( ( $cookie_index < count( $cookies ) ) && !$urlparm_validity ) {
        if($debug) {echo "<br>cookies=";print_r($cookies);echo ", cookie_index=".$cookie_index;}
        $ck_item = assoc_index($cookies,$cookie_index);
        // if urlparm, if urlparm equals cookie - set valid urlparm
        // wrong, because the urlparm is only valid if it's found in the whitelist
        // if($debug) echo "<br>urlparm=".$urlparm.", ck_item=".$ck_item;
        // if($urlparm && $urlparm==$ck_item) $urlparm_validity = true;
        // for each whitelist while cookie and urlparm not valid,
        $wl_index = 0;
        while($wl_index<count($whitelist)){// && !$urlparm_validity && !$cookie_validity){
            $wl_item=assoc_index($whitelist,$wl_index++);
            // if urlparm, if urlparm equals wl_item - set valid urlparm
            if($debug && !$urlparm_validity) echo "<br>urlparm=".$urlparm.", wl_item=".$wl_item.", url_match=".($wl_item==$urlparm);
            if($urlparm && $urlparm==$wl_item) $urlparm_validity = true;
            // if cookie equals whitelist, set valid cookie
            if($debug && !$cookie_validity) echo "<br>cookie=".$ck_item.", wl_item=".$wl_item.", ck_match=".($wl_item==$ck_item);
            if($ck_item==$wl_item) $cookie_validity = true;
        }
        $cookie_index++;
    }
    if($debug) echo "<br>";
    if($debug) echo "<br>urlparm_validity=".b2s($urlparm_validity).", cookie_validity=".b2s($cookie_validity);
    return array($urlparm_validity, $cookie_validity);

}

?>