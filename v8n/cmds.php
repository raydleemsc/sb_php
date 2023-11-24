<?php

require_once("validate.php");

function cmd_help(){
    echo "\n";
    echo "v8n <t|f>: call standard validation check with debug flag\n";
    echo "\n";
}

function cmd_validate($debug=false){
    return validate($debug);
}

function cmd_open(){
    set_system_status("open");
}

function cmd_close(){
    set_system_status("close");
}

?>