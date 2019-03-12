<?php
// Include initialize.php to initialize all the needed functions before page load
require_once '../../private/initialize.php';

log_out_admin();

redirect_to(url_for('/staff/login.php'));

?>
