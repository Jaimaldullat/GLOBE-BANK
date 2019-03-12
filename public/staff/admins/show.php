<?php require_once('../../../private/initialize.php'); ?>

<?php
// $id = isset($_GET['id']) ? $_GET['id'] : '1';
$id = $_GET['id'] ?? '1'; // PHP > 7.0

$admin = find_admin_by_id($id);
?>

<?php $page_title = 'Show Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main id="admin">

    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

    <div class="admin show">

        <h1>Admin: <?php echo h($admin['first_name']) . ' ' . h($admin['last_name']); ?></h1>
        <table >
            <tr><td>First Name:</td> <td><?php echo h($admin['first_name']); ?></td></tr>
            <tr><td>Last Name:</td> <td><?php echo h($admin['last_name']); ?></td></tr>
            <tr><td>Email:</td> <td><?php echo $admin['email']; ?></td></tr>
            <tr><td>Username:</td> <td><?php echo $admin['username']; ?></td></tr>
        </table></li>
    </div>

</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
