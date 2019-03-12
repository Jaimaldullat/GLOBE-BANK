<?php require_once('../../../private/initialize.php'); ?>
<?php
require_login();
if(is_post_request()) {

    $page = [];
    $page['subject_id'] = $_POST['subject_id'] ?? '';
    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['content'] = $_POST['content'] ?? '';

    $result = insert_page($page);
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = "The page was created successfully.";
        redirect_to(url_for('/staff/pages/show.php?id=' . $new_id));
    } else {
        $errors = $result;
    }

} else {

    $page = [];
    $page['subject_id'] = $_GET['subject_id'] ?? '';
    $page['menu_name'] = '';
    $page['position'] = '';
    $page['visible'] = '';
    $page['content'] = '';

}

$page_set = find_all_pages();
$page_count = mysqli_num_rows($page_set) + 1;
mysqli_free_result($page_set);

?>
<?php $page_title = 'Create Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main id="create-subject">
    <a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($page["subject_id"]))); ?>">&laquo; Back to Subject Page</a>

    <div class="create-page">
        <h1>Create Page</h1>

        <?php echo display_errors($errors); ?>

        <form class="new-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <div class="form-control">
                <label>Menu Name
                    <input type="text" name="menu_name" value="<?php echo h($page['menu_name']); ?>"/>
                </label>
            </div>
            <div class="form-control">
                <label>Subject
                    <select name="subject_id">
                        <?php
                        $subject_set = find_all_subjects();
                        while ($subject = mysqli_fetch_assoc($subject_set)) {
                            echo "<option value=\"" . h($subject['id']) . "\"";
                            if ($page["subject_id"] == $subject['id']) {
                                echo " selected";
                            }
                            echo ">" . h($subject['menu_name']) . "</option>";
                        }
                        mysqli_free_result($subject_set);
                        ?>
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label>Position
                    <select name="position">
                            <?php
                            for ($i = 1; $i <= $page_count; $i++) {
                                echo "<option value=\"{$i}\"";
                                if ($page["position"] == $i) {
                                    echo " selected";
                                }
                                echo ">{$i}</option>";
                            }
                            ?>
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label>Visible
                    <input type="hidden" name="visible" value="0"/>
                    <input type="checkbox" name="visible" value="1" <?php if ($page['subject_id'] == "1") {
                        echo " checked";
                    } ?>/>
                </label>
            </div>
            <div class="form-control">
                <label>Content
                    <textarea name="content"  rows="6"><?php echo h($page['content']); ?></textarea>
                </label>
            </div>
            <div class="form-control">
                <button type="submit">Create Page</button>
            </div>
        </form>
    </div>
</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
