<?php require_once('../../../private/initialize.php'); ?>

<?php
if(!isset($_GET['id'])) {
    redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

    $admin = [];

    $admin['id'] = $id;
    $admin['first_name'] = $_POST['first_name'] ?? '';
    $admin['last_name'] = $_POST['last_name'] ?? '';
    $admin['email'] = $_POST['email'] ?? '';
    $admin['username'] = $_POST['username'] ?? '';
    $admin['password'] = $_POST['password'] ?? '';
    $admin['confirm_password'] = $_POST['confirm_password'] ?? '';

    $result = update_admin($admin);
    if($result === true) {
        $_SESSION['message'] = "The admin was updated successfully.";
        redirect_to(url_for('/staff/admins/show.php?id=' . $id));
    } else {
        $errors = $result;
    }

} else {

    $admin = find_admin_by_id($id);

}


?>


<?php $page_title = 'Edit Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<main id="edit-admin">
    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

    <div class="edit-admin">
        <h1>Edit Admin</h1>

        <?php echo display_errors($errors); ?>

        <form class="new-form" action="<?php echo $_SERVER['PHP_SELF'] .'?id=' . h(u($id)); ?>" method="post">

            <div class="form-control">
                <label>First Name
                    <input type="text" name="first_name" value="<?php echo h($admin['first_name']); ?>"/>
                </label>
            </div>
            <div class="form-control">
                <label>Last Name
                    <input type="text" name="last_name" value="<?php echo h($admin['last_name']); ?>"/>
                </label>
            </div>
            <div class="form-control">
                <label>Email
                    <input type="text" name="email" value="<?php echo h($admin['email']); ?>"/>
                </label>
            </div>
            <div class="form-control">
                <label>Username
                    <input type="text" name="username" value="<?php echo h($admin['username']); ?>"/>
                </label>
            </div>
            <div class="form-control">
                <label>Password
                    <input type="password" name="password" value=""/>
                </label>
            </div>
            <div class="form-control">
                <label>Confirm Password
                    <input type="password" name="confirm_password" value=""/>
                </label>
            </div>
            <p>
                Passwords should be at least 12 characters and include at least one uppercase letter, lowercase letter, number, and symbol.
            </p>
            <div class="form-control">
                <button type="submit">Edit Admin</button>
            </div>
        </form>
    </div>
</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
