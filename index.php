<?php

echo "<br>setcookie(test)=".setcookie("test");
echo "<br>_COOKIE="; print_r($_COOKIE);
echo "<br>_REQUEST="; print_r($_REQUEST);

echo "<br>";
include("cc.php");
$cc=cc_validate(true);
echo "<br>cc_validate=(".b2s($cc[0]).", ".b2s($cc[1]).")";

?>