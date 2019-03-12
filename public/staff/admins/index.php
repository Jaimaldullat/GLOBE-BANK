<?php require_once '../../../private/initialize.php'; ?>
<?php
$admin_set = find_all_admins();
?>
<?php $page_title = "Admins"; ?>
<?php include SHARED_PATH . '/staff_header.php' ?>

<main id="admins">
    <h1>Admins</h1>
    <div class="actions">
        <a class="action" href="<?php echo url_for('/staff/admins/new.php'); ?>">Create New Admin</a>
    </div>
    <table class="list">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>

        <?php
        while ($admin = mysqli_fetch_assoc($admin_set)):
            ?>
            <tr>
                <td><?php echo h($admin['id']); ?></td>
                <td><?php echo h($admin['first_name']); ?></td>
                <td><?php echo h($admin['last_name']); ?></td>
                <td><?php echo h($admin['email']); ?></td>
                <td><?php echo h($admin['username']); ?></td>
                <td><a class="action" href="<?php echo url_for('/staff/admins/show.php?id=' . h($admin['id'])); ?>">View</a>
                </td>
                <td><a class="action" href="<?php echo url_for('/staff/admins/edit.php?id=' . h($admin['id'])); ?>">Edit</a>
                </td>
                <td><a class="action" href="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($admin['id']))); ?>">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php mysqli_free_result($admin_set); ?>
</main>

<?php include SHARED_PATH . '/staff_footer.php' ?>
