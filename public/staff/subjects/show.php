<?php require_once('../../../private/initialize.php'); ?>

<?php
// $id = isset($_GET['id']) ? $_GET['id'] : '1';
$id = $_GET['id'] ?? '1'; // PHP > 7.0

$subject = find_subject_by_id($id);
?>

<?php $page_title = 'Show Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main id="subject">

    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="subject show">

       <h1>Subject: <?php echo h($subject['menu_name']); ?></h1>
            <table >
                <tr><td>Menu Name:</td> <td><?php echo h($subject['menu_name']); ?></td></tr>
                <tr><td>Position:</td> <td><?php echo h($subject['position']); ?></td></tr>
                <tr><td>Visible:</td> <td><?php echo $subject['visible'] == '1' ? 'True' : 'False'; ?></td></tr>
            </table></li>
    </div>

</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
