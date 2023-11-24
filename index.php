<?php

echo("<br>Index:_COOKIE=".print_r($_COOKIE,true));
echo("<br>Index:_REQUEST=".print_r($_REQUEST,true));

include("v8n/validate.php");
$v8n=validate(true);
echo("<br>Index:validate=$v8n");

?>