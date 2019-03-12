<?php require_once('../../../private/initialize.php'); ?>
<?php

$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set) + 1;
mysqli_free_result($subject_set);

if(is_post_request()) {

$subject = [];
$subject['menu_name'] = $_POST['menu_name'] ?? '';
$subject['position'] = $_POST['position'] ?? '';
$subject['visible'] = $_POST['visible'] ?? '';

$result = insert_subject($subject);
if($result === true) {
$new_id = mysqli_insert_id($db);
$_SESSION['message'] = "The subject was created successfully.";
redirect_to(url_for('/staff/subjects/show.php?id=' . $new_id));
} else {
$errors = $result;
}

} else {
// display the blank form
$subject = [];
$subject["menu_name"] = '';
$subject["position"] = $subject_count;
$subject["visible"] = '';
}

?>
<?php $page_title = 'Create Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main id="create-subject">
    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="create-subject">
        <h1>Create Subject</h1>

        <?php echo display_errors($errors); ?>

        <form class="new-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-control">
                <label>Menu Name
                    <input type="text" name="menu_name" value=""/>
                </label>
            </div>
            <div class="form-control">
                <label>Position
                    <select name="position">
                        <?php
                        for($i=1; $i <= $subject_count; $i++){
                            echo "<option value=\"{$i}\"";
                            if($subject['position'] == $i) {
                                echo "selected";
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
                    <input type="checkbox" name="visible" value="1"/>
                </label>
            </div>
            <div class="form-control">
                <button type="submit">Create Subject</button>
            </div>
        </form>
    </div>
</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
