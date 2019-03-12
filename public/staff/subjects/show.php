<?php require_once('../../../private/initialize.php'); ?>

<?php
require_login();
// $id = isset($_GET['id']) ? $_GET['id'] : '1';
$id = $_GET['id'] ?? '1'; // PHP > 7.0

$subject = find_subject_by_id($id);

$page_set = find_pages_by_subject_id($id);
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
            </table>
    </div>
    <hr>
    <h2>Pages</h2>
    <div class="actions">
        <a class="action" href="<?php echo url_for('/staff/pages/new.php?subject_id=' . h(u($subject['id']))); ?>">Create New Page</a>
    </div>
    <table class="list">
        <tr>
            <th>ID</th>
            <th>Position</th>
            <th>Visible</th>
            <th>Name</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>

        <?php while ($page = mysqli_fetch_assoc($page_set)):
            $subject = find_subject_by_id($page['subject_id']);
            ?>
            <tr>
                <td><?php echo h($page['id']); ?></td>
                <td><?php echo h($page['position']); ?></td>
                <td><?php echo $page['visible'] == 1 ? 'true' : 'false'; ?></td>
                <td><?php echo h($page['menu_name']); ?></td>
                <td><a class="action" href="<?php echo url_for('/staff/pages/show.php?id=' . h(u($page['id']))); ?>">View</a></td>
                <td><a class="action" href="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($page['id']))); ?>">Edit</a></td>
                <td><a class="action" href="<?php echo url_for('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php mysqli_free_result($page_set); ?>

</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
