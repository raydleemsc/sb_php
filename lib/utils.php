<?php

function include_recent($from_dir,$debug=false){
    // $files = array_diff(scandir($from_dir), array('..', '.'));

    // // $files = scandir("experiments");
    // foreach ($files as $file_k) {
    //     $stat = stat("$from_dir/$file_k");
    //     // $stat_full = print_r($stat,true);
    //     // $stat_ctime = print_r($stat['ctime'],true);
    //     $stat_mtime = print_r($stat['mtime'],true);

    //     // $epoch = 1344988800;
    //     $epoch = $stat_mtime;
    //     $dt = new DateTime("@$epoch");

    //     $stat_mtime = $dt->format('Y-m-d H:i:s');
    //     echo("<br>$file_k &nbsp $stat_mtime");
    // }

    $fileList = array();
    $files = array_diff(scandir($from_dir), array('..', '.'));
    // print_r($files);
    // $files = glob($from_dir+'/*');
    foreach ($files as $filename) {
        // echo("<br>filename=$filename");
        $filename = $from_dir."/".$filename;
        // echo("<br>filename=$filename");
        $fileList[filemtime($filename)] = $filename;
    }
    // echo("<br>");
    // print_r($fileList);
    // echo("<br>");
    ksort($fileList);
    // print_r($fileList);
    // echo("<br>");
    $fileList = array_reverse($fileList, TRUE);
    // print_r($fileList);
    // foreach ($fileList as $file_k=>$file_v) {
    //     $file_k = new DateTime("@$file_k");
    //     $file_k = $file_k->format('Y-m-d H:i:s');
    //     echo("<br>$file_k &nbsp $file_v");
    // }

    $latest=array_values($fileList)[0];
    if ($debug) {
        echo("<br>Including most recent experimental update=".$latest);
    }

    include($latest);

}

?>