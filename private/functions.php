<?php
// Convert static URL into Dynamic URL
function url_for($script_path) {
    // Add a leading "/" if not present
    if($script_path[0] != '/') {
        $script_path = '/'.$script_path;
    }
    return WWW_ROOT.$script_path;
}

// Custom short function to encode URL
function u($string = '') {
    return urlencode($string);
}

// Custom function to convert into HTML special Chars
function h($string = '') {
    return htmlspecialchars($string);
}

function error_404(){
    header($_SERVER["SERVER_PROTOCOL"] . "404 Not Found");
    exit();
}

function error_500(){
    header($_SERVER["SERVER_PROTOCOL"] . "400 Internal Server Error");
    exit();
}

function redirect_to($string){
    header("Location: $string");
    exit();
}

// Check if request is POST
function is_post_request(){
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}
// Check if request is GET
function is_get_request(){
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}
?>