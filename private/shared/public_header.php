<?php if (!isset($page_title)) {
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
    <title>Globe Bank <?php echo '- '.h($page_title); ?>
    <?php if(isset($preview) && $preview ) { echo '[PREVIEW]'; } ?>
    </title>
    <link rel="stylesheet" href="<?php echo url_for('/stylesheets/public.css') ?>">
</head>
<body>
<header>
    <h1>
        <a href="<?php echo url_for('/index.php'); ?>">
            <img src="<?php echo url_for('/images/gbi_logo.png'); ?>" width="298" height="71" alt="" />
        </a>
    </h1>
</header>