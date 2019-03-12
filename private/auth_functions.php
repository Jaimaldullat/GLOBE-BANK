<?php

// perform all the necessary actions related to admin auth

// log in admin
function log_in_admin($admin){

    // regenerating the ID protects the admin from fixation
    session_regenerate_id();
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['username'] = $admin['username'];
    $_SESSION['last_login'] = time();
    return true;
}
?>