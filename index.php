<?php
// $ck_opts="";
// setcookie("test", "test", time()-3600);
// setcookie("test", "test", time()-3600);
// setcookie("red", "red", time()-3600);
// setcookie("blue", "blue", time()-3600);
setcookie("admin", "admin", time()+3600);

// echo "<br>setcookie(test)=".$cookie_test;
echo "<br>_COOKIE="; print_r($_COOKIE);
echo "<br>_REQUEST="; print_r($_REQUEST);

echo "<br>";
include("cc.php");
$cc=cc_validate(true);
echo "<br>cc_validate=(".$cc.")";
// echo "<br>cc_validate=(".b2s($cc[0]).", ".b2s($cc[1]).")";

?>