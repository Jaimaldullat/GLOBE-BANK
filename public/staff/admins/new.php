<?php require_once('../../../private/initialize.php'); ?>
<?php
require_login();
if(is_post_request()) {

    $admin = [];
    $admin['first_name'] = $_POST['first_name'] ?? '';
    $admin['last_name'] = $_POST['last_name'] ?? '';
    $admin['email'] = $_POST['email'] ?? '';
    $admin['username'] = $_POST['username'] ?? '';
    $admin['password'] = $_POST['password'] ?? '';
    $admin['confirm_password'] = $_POST['confirm_password'] ?? '';

    $result = insert_admin($admin);
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = "The admin was created successfully.";
        redirect_to(url_for('/staff/admins/show.php?id=' . $new_id));
    } else {
        $errors = $result;
    }

} else {

    $admin = [];
    $admin['first_name'] = '';
    $admin['last_name'] = '';
    $admin['email'] = '';
    $admin['username'] = '';

}

?>
<?php $page_title = 'Create Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main id="create-admin">
    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

    <div class="create-admin">
        <h1>Create admin</h1>

        <?php echo display_errors($errors); ?>

        <form class="new-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

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
                    <input type="text" name="confirm_password" value=""/>
                </label>
            </div>
            <p>
                Passwords should be at least 12 characters and include at least one uppercase letter, lowercase letter, number, and symbol.
            </p>
            <div class="form-control">
                <button type="submit">Create Admin</button>
            </div>
        </form>
    </div>
</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
