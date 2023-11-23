<?php

require_once('storage_db_config.php');

function create_db($new_db_file_name){
    close_db(open_db($new_db_file_name));
}

function error_call($e){
    echo $e->getMessage();
}

function open_db($db_file_name){
    try {    
        return new PDO(DB_PREFIX.':'.$db_file_name);
    } catch(PDOException $e) {
        error_call($e);
    }
}

function close_db($db_file_handle){
    try {    
        return $db_file_handle = null;
    } catch(PDOException $e) {
        error_call($e);
    }
}

function table_exists(){
    return false;
}

function create_table($new_table_name){

}

if(!file_exists(FILE_DB)) create_db(FILE_DB);
foreach (["admin","access"] as $table) {
    if(!table_exists($table)) create_table($table);
}
?>