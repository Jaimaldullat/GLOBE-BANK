<?php require_once('../../../private/initialize.php'); ?>

<?php
// $id = isset($_GET['id']) ? $_GET['id'] : '1';
$id = $_GET['id'] ?? '1'; // PHP > 7.0
$page = find_page_by_id($id);
$subject = find_subject_by_id($page['subject_id']);
?>

<?php $page_title = 'Show Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main id="page">

    <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

    <div class="page show">

        <h1>Page: <?php echo h($page['menu_name']); ?></h1>
        <div class="actions">
            <a class="action" href="<?php echo url_for('/index.php?id=' . h(u($page['id'])) . '&preview=true');  ?>"
               target="_blank">Preview</a>
        </div>
        <table >
            <tr><td>Menu Name:</td> <td><?php echo h($page['menu_name']); ?></td></tr>
            <tr><td>Subject:</td> <td><?php echo h($subject['menu_name']); ?></td></tr>
            <tr><td>Position:</td> <td><?php echo h($page['position']); ?></td></tr>
            <tr><td>Visible:</td> <td><?php echo $page['visible'] == '1' ? 'True' : 'False'; ?></td></tr>
            <tr><td>Content:</td> <td><?php echo h($page['content']); ?></td></tr>
        </table>

    </div>

</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
