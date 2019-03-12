<?php require_once '../../private/initialize.php';
?>
<?php

$errors = [];
$username = '';
$password = '';

if (is_post_request()) {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if(is_blank($username)) {
        $errors[] = "Username cannot be blank.";
    }

    if(is_blank($password)) {
        $errors[] = "Password cannot be blank.";
    }

    // if there were no error, try to login
    if(empty($errors)) {
        // using one variable to ensure the msg is same
        $admin = find_admin_by_username($username);

        $login_failure_msg = "Login was unsuccessful.";
        if($admin) {
            if(password_verify($password, $admin['hashed_password'])) {
                // Password matches

                log_in_admin($admin);
                redirect_to(url_for('/staff/index.php'));
            }else {
                // user found but password doesn't match
                $errors[] = $login_failure_msg;
            }
        }
        else {
            // No username found
            $errors[] = $login_failure_msg;
        }
    }
}

?>
<?php $page_title = "Staff Login"; ?>
<?php include SHARED_PATH . '/staff_header.php' ?>

<main id="login">
    <h1>Staff Login</h1>

    <?php echo display_errors($errors); ?>

    <form class="new-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-control">
            <label>Username
                <input type="text" name="username" value="<?php echo h($username); ?>"/>
            </label>
        </div>
        <div class="form-control">
            <label>Password
                <input type="password" name="password" value=""/>
            </label>
        </div>
        <div class="form-control">
            <button type="submit" name="submit">Login</button>
        </div>
    </form>
</main>

<?php include SHARED_PATH . '/staff_footer.php' ?>
