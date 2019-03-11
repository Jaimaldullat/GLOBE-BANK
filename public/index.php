<?php require_once '../private/initialize.php'; ?>

<?php $page_title = "Public"; ?>
<?php include SHARED_PATH . '/public_header.php'; ?>

<main id="public-index">
    <div id="left-menu">
        <?php include SHARED_PATH . '/public_navigation.php'; ?>
    </div>
    <div id="right-content">
        <?php

        // Show static homepage
        // The homepage content could:
        // be static content (here or in a shared file)
        // show the first page from nav
        // be in the database but add code to hide in the nav
        include SHARED_PATH . '/static_homepage.php';

        ?>
    </div>
</main>
<?php include SHARED_PATH . '/public_footer.php'; ?>
