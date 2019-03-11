<?php
ob_start(); // Output buffering is turned on
// Assign file paths to PHP constants
// __FILE__ returns the current path to this file
// dirname() returns the path to the parent directory
define("PRIVATE_PATH",dirname(__FILE__));
define("PROJECT_PATH",dirname(PRIVATE_PATH));
define("SHARED_PATH",PRIVATE_PATH. '/shared');
define("PUBLIC_PATH",PROJECT_PATH. '/public');

$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);

require_once 'functions.php';
require_once 'database.php';
require_once 'query_functions.php';
require_once 'validation_functions.php';

// Global databse variable
$db = db_connect();
$errors = [];
?>