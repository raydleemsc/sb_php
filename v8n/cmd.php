<?php

require_once("cmd_config.php");

require_once("cmds.php");
// var_dump($argc); //number of arguments passed 
// var_dump($argv); //the arguments passed
$start=1;
if ($argc>$start){
    $valid_cmds=0;
    $invalid_cmds=0;
    $cmds=count($argv)-1;
    // echo "processing: ";
    // var_dump($argv);
    for ($x=$start; $x < count($argv); $x++) { 
        echo "($x:$argv[$x]) ";
        switch ($argv[$x]) {
            case 'open':
            case 'close':
                $status=get_system_status();
                echo "set_system_status(".$status." -> ";
                if ($argv[$x]=='open') cmd_open(); else cmd_close();
                echo get_system_status().")\n";
                break;
            case 'status':
                echo "get_system_status()=".get_system_status()."\n";
                break;
            case 'showam':
                echo "access_method()=".access_method()."\n";
                break;
            default:
                $invalid_cmds++;
                echo "Undefined command '$argv[$x]'\n";
                break;
        }
    }
    if(($valid_cmds==0)&&($invalid_cmds>0)){
        echo "No valid commands provided\n";
        cmd_help();
    }
}

?>