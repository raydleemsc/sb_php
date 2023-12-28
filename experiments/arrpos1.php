<?php

$needles = array( ''
    ,'dev'
    ,'local'
    ,'test'
    ,'local'
);
// $needles = implode(" ",$needles);
$needles="local";
var_dump($needles);

$haystack = $_SERVER['SERVER_NAME'];
var_dump($haystack);

include("fn_arrpos.php");

$found = arrpos($haystack,$needles);

if($found>0)echo("found at ".$found);
else echo("lost");

?>