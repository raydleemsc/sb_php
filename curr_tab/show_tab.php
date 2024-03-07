<?php

// read in the json

$jsondata = file_get_contents('buynote_lgs2.json');
$data = json_decode($jsondata, true);
$nl= "\n";
$tab="\t";

if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'json_last_error_msg='.json_last_error_msg();
}

foreach ($data as $k => $d) {
    $data[$k]['sp'] = strpos($d["id"],"ctx");
    $flag = 'false';
    if($data[$k]['sp']) $flag = 'true';
    $data[$k]['flag'] = $flag;
}

// parse down to ctx and iso codes
$data0 = array_filter($data, function($d) {
    // echo $d['id']."\t".$d['flag'];
    // if($d['flag'] === 'true') echo ' & yes';
    $return_flag = false;
    if(strpos($d["id"],"ctx")) {
        echo $d['id']."\t".$d['flag'];
        echo ' & more';
        echo "\n";
        // $return_flag = $d;
        return $d;
    }
    // echo "\n";
    // $d['sp'] = strpos($d["id"],"ctx");
    // return !(strpos($d["id"],"ctx") === false);
    // return $return_flag;
    // return true;
//     // return !(strpos($d["id"],"ctx") === false);
});


// sort by iso codes alpha descending
// assign rc index by col then row
// eg.
// 01 11 21 31
// 02 12 22 32
// 03 13 23 33
// etc
// sort by rc
// display in table

// echo 'data0='; print_r($data0);

echo ('<br>');
// Step 3: Use the data
if(is_array($data0) && isset($data0[0])) {
    foreach ($data0 as $d) {
        echo 'd='; print_r($d); echo $nl;
        foreach($d as $k => $v){
            echo $tab.$k.': '.$tab.$v;
        }
        // echo '-------------------';
        // echo ('<br>');
        echo ($nl);
    }
}

?>