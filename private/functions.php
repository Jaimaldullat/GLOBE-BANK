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
?>