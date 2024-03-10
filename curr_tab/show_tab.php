<?php

include_once('show_tab_fn.php');

$nl='';
$test = $_SERVER['DOCUMENT_ROOT'];
if (isset($test) && ($test != '')) {
    $nl = "<br>";
} else {
    $nl = "\n";
}


// read in the json

$jsondata = file_get_contents('buynote_lgs2.json');
$data = json_decode($jsondata, true);
// $nl= "\n";
$tab="\t";

if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'json_last_error_msg='.json_last_error_msg();
}

// foreach ($data as $k => $d) {
//     $data[$k]['sp'] = strpos($d["id"],"ctx");
//     $flag = 'false';
//     if($data[$k]['sp']) $flag = 'true';
//     $data[$k]['flag'] = $flag;
// }

// parse down to ctx and iso codes
$data0 = array_filter($data, function($d) {
    // echo $d['id']."\t".$d['flag'];
    // if($d['flag'] === 'true') echo ' & yes';
    // $return_flag = false;
    if(strpos($d["id"],"ctx")) {
        // echo $d['id']."\t".$d['flag'];
        // echo ' & more';
        // echo "\n";
        // $return_flag = $d;
        // $e = array();
        // $e['text'] = $d['text'];
        // $e['iso'] = $d['iso'];
        return $d;
    } else {
        return false;
    }
    // echo "\n";
    // $d['sp'] = strpos($d["id"],"ctx");
    // return !(strpos($d["id"],"ctx") === false);
    // return $return_flag;
    // return true;
//     // return !(strpos($d["id"],"ctx") === false);
});

$data1 = array();
foreach ($data0 as $key => $value) {
    $d1 = $value['iso'].' = '.substr($value['text'],0,2);
    $dt_found = "false";
    foreach ($data1 as $dt1) {
        if(in_array($d1,$dt1)){
            $dt_found = "true";
        }
    }
    // if(!in_array($d1,$data1)){ $data1[]['text'] = $d1; }
    if($dt_found=="false"){ $data1[]['text'] = $d1; }
}

// sort by iso codes alpha descending
$data2 = $data1;
// sort( $data2 );
usort( $data2, "comparatortext" );

// assign rc index by col then row

$data5 = array();
$key = 0;
$data3 = $data2;
for ($col=0; $col < 4; $col++) { 
    for ($row=0; $row < 10; $row++) { 
        if(isset($data3[$key])){
            // $data3[$key]['loc'] = "$row$col";
            if(!isset($data5[$row])) $data5[$row] = array();
            $data5[$row][$col] = $data3[$key]['text'];
        }
        $key += 1;
    }
}

// eg.
// 01 11 21 31
// 02 12 22 32
// 03 13 23 33
// etc
// sort by rc
// $data4 = $data3;
// sort( $data2 );
// usort( $data4, "comparatorloc" );

// display in table

// echo 'data0='; print_r($data0);

$data9 = $data5;
// echo 'data9='; print_r($data9);

echo ($nl);
// Step 3: Use the data
if(is_array($data9)) {
    foreach ($data9 as $dk => $d) {
        echo '['.$dk.'] => Array (';
        if(is_array($d)) {
            foreach($d as $k => $v){
                echo '['.$k.'] => '.$tab.$v;
            }
        } else {
            echo print_r($d,true);
        }
        // echo '-------------------';
        // echo ('<br>');
        echo (')'.$nl);
    }
}

?>