<?php
require_once 'db_credentials.php';

// Create a connection to the database
function db_connect(){
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    confirm_db_connect();
    return $connection;
}
// Close a connection to the database
function db_disconnect($connection){
    if(isset($connection)){
        mysqli_close($connection);
    }
}
// Custom short function for escaping characters
function db_escape($connection, $string) {
    return mysqli_real_escape_string($connection, $string);
}

// Confirm if database connected successfully
function confirm_db_connect(){
    if(mysqli_connect_errno()){
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }
}
// Confirm if query is executed successfully
function confirm_result($result_set){
    if(!$result_set) {
        exit("Database query failed.");
    }
}
?>