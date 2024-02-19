<?php

echo("<content>");
echo("<h1>");
echo("Content");

// include("experiments/get_recent.php");
include_recent('experiments',true);

echo("</h1>");
echo("</content>");


?>