<?php

$needles = array( ''
    ,'dev'
    ,'local'
    ,'test'
    ,'local'
);
// $needles = implode(" ",$needles);
$needles="local";
echo("<br>needles=");
var_dump($needles);

$haystack = $_SERVER['SERVER_NAME'];
echo("<br>haystack=");
var_dump($haystack);

include("fn_arrpos.php");

$found = arrpos($haystack,$needles);

if($found>0)echo("found at ".$found);
else echo("<br>lost needle in haystack");

?>