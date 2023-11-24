<?php

require_once('storage_files.php');
require_once('storage_db.php');

function access_method(){
    // returns file or sqlite etc. based on current access methods based on functionality/settings, etc.
    // persistent af to maintain usability.
    if(db_exists()) return "db";
    return "file";
}

?>