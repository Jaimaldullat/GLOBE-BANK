<?php
// Include initialize.php to initialize all the needed functions before page load
require_once '../../private/initialize.php';
?>

<?php $page_title = "Staff Menu"; ?>
<?php include SHARED_PATH. '/staff_header.php' ?>

<main id="staff">
    <ul>
        <li><a href="<?php echo url_for('/staff/subjects/index.php'); ?>">Subjects</a></li>
        <li><a href="<?php echo url_for('/staff/pages/index.php'); ?>">Pages</a></li>
    </ul>
</main>

<?php include SHARED_PATH. '/staff_footer.php' ?>
