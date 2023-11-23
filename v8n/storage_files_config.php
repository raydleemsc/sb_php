<?php

define('FILE_STORAGE_PREFIX','storage_file_');
define('STATUS_FILE',V8N_HOME.'/'.FILE_STORAGE_PREFIX.'status.txt');
define('ADMIN_FILE',V8N_HOME.'/'.FILE_STORAGE_PREFIX.'admin.txt');
define('ACCESS_FILE',V8N_HOME.'/'.FILE_STORAGE_PREFIX.'access.txt');
define('FILE_ARRAY',array("admin"=>ADMIN_FILE,"access"=>ACCESS_FILE));

?>