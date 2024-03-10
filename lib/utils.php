<?php

function include_recent($from_dir,$debug=false){

    $fileList = array();
    $files = array_diff(scandir($from_dir), array('..', '.'));
    foreach ($files as $filename) {
        $filename = $from_dir."/".$filename;
        $fileList[filemtime($filename)] = $filename;
    }
    ksort($fileList);
    $fileList = array_reverse($fileList, TRUE);

    $latest=array_values($fileList)[0];
    if ($debug) {
        echo("<br>Including most recent experimental update=".$latest);
    }

    include($latest);

}

?>