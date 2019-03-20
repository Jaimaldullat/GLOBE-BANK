<?php

if (!isset($page_title)) {
    $page_title = '';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GBI - <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="<?php echo url_for('/stylesheets/staff.css') ?>">
</head>
<body>
<header>
    <h1>GBI Staff Area</h1>
</header>
<nav id="staff-nav">
    <ul>
        <li>User: <?php echo $_SESSION['username'] ?? ''; ?></li>
        <li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
		<?php if(is_logged_in()){ ?>
        <li><a href="<?php echo url_for('/staff/logout.php'); ?>">Logout</a></li>
		<?php } ?>
    </ul>
</nav>

<?php echo display_session_message(); ?>