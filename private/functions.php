<?php
// Convert static URL into Dynamic URL
function url_for($script_path)
{
    // Add a leading "/" if not present
    if ($script_path[0] != '/') {
        $script_path = '/' . $script_path;
    }
    return WWW_ROOT . $script_path;
}

// Custom short function to encode URL
function u($string = '')
{
    return urlencode($string);
}

// Custom function to convert into HTML special Chars
function h($string = '')
{
    return htmlspecialchars($string);
}

function error_404()
{
    header($_SERVER["SERVER_PROTOCOL"] . "404 Not Found");
    exit();
}

function error_500()
{
    header($_SERVER["SERVER_PROTOCOL"] . "400 Internal Server Error");
    exit();
}

function redirect_to($string)
{
    header("Location: $string");
    exit();
}

// Check if request is POST
function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

// Check if request is GET
function is_get_request()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

// Display error on page with formatting
function display_errors($errors = array())
{
    $output = '';
    if (!empty($errors)) {
        $output .= "<div class=\"errors\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $error) {
            $output .= "<li>" . h($error) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

// Get message from session and clear it
function get_and_clear_session_message()
{
    if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
        $msg = $_SESSION['message'];
        unset($_SESSION['message']);
        return $msg;
    }
}

// Display session messages
function display_session_message()
{
    $msg = get_and_clear_session_message();
    if (!is_blank($msg)) {
        return "<div id='message'>" . h($msg) . "</div>";
    }
}

?>