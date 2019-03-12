<?php
// Include initialize.php to initialize all the needed functions before page load
require_once '../../private/initialize.php';
?>
<?php

$errors = [];
$username = '';
$password = '';

if(is_post_request()){

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $_SESSION['username'] = $username;
    redirect_to(url_for('/staff/index.php'));
}

?>
<?php $page_title = "Staff Login"; ?>
<?php include SHARED_PATH. '/staff_header.php' ?>

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

<?php include SHARED_PATH. '/staff_footer.php' ?>
