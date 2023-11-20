<?php

echo("<br>Index:_COOKIE=".print_r($_COOKIE,true));
echo("<br>Index:_REQUEST=".print_r($_REQUEST,true));

include("v8n/cc.php");
$cc=cc_validate(true);
echo("<br>Index:cc_validate=$cc");

?>