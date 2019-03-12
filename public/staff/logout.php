<?php
// Include initialize.php to initialize all the needed functions before page load
require_once '../../private/initialize.php';

unset($_SESSION['username']);
// OR $_SESSION['username'] = null

redirect_to(url_for('/staff/login.php'));

?>
