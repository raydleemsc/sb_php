<?php

$directory = 'experiments';
$files = array_diff(scandir($directory), array('..', '.'));

// $files = scandir("experiments");
foreach ($files as $file_k) {
    $stat = stat("$directory/$file_k");
    $stat_full = print_r($stat,true);
    $stat_ctime = print_r($stat['ctime'],true);
    $stat_mtime = print_r($stat['mtime'],true);
    echo("<br>$file_k &nbsp $stat_mtime");
}

?>