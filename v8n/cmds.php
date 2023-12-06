<?php

require_once("cmd_utils.php");

function cmd_help(){
    echo "\n";
    echo "help: show this message.\n";
    echo "open: open for auto-access cookie.\n";
    echo "close: close for auto-access cookie.\n";
    echo "showam: show current storage access method.\n";
    echo "\n";
}

function cmd_open(){
    set_system_status("open");
}

function cmd_close(){
    set_system_status("close");
}

?>