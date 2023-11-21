<?php

define('FILE_DB','cc_storage.sqlite3');

// Create or open a database file
$file_db = new PDO('sqlite:'.FILE_DB);

?>