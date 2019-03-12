<?php require_once('../../../private/initialize.php'); ?>

<?php
require_login();
if(!isset($_GET['id'])) {
    redirect_to(url_for('/staff/subjects/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
// Handle form values sent by new.php
    $subject = [];
    $subject['id'] = $id;
    $subject['menu_name'] = $_POST['menu_name'] ?? '';
    $subject['position'] = $_POST['position'] ?? '';
    $subject['visible'] = $_POST['visible'] ?? '';

    $result = update_subject($subject);
    if($result === true) {
        $_SESSION['message'] = "The subject was updated successfully.";
        redirect_to(url_for('/staff/subjects/show.php?id=' . $id));
    } else {
        $errors = $result;
        //var_dump($errors);
    }

} else {

    $subject = find_subject_by_id($id);

}

$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set);
mysqli_free_result($subject_set);

?>


<?php $page_title = 'Edit Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<main id="edit-subject">
    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="edit-subject">
        <h1>Edit Subject</h1>
        <?php echo display_errors($errors); ?>
        <form class="new-form" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . h(u($id)); ?>" method="post">
            <div class="form-control">
                <label>Menu Name
                    <input type="text" name="menu_name" value="<?php echo h($subject['menu_name']); ?>"/>
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
                    <input type="checkbox" name="visible" value="1"
                        <?php if($subject['visible'] == 1) echo "checked"; ?>
                    />
                </label>
            </div>
            <div class="form-control">
                <button type="submit">Edit Subject</button>
            </div>
        </form>
    </div>
</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
