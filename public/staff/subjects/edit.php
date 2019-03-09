<?php require_once('../../../private/initialize.php'); ?>

<?php

if(!isset($_GET['id'])) {
    redirect_to(url_for('/staff/subjects/index.php'));
}
$id = $_GET['id'];
$menu_name = '';
$position = '';
$visible = '';
if(is_post_request()) {
// Handle form values sent by new.php

    $menu_name = $_POST['menu_name'] ?? '';
    $position = $_POST['position'] ?? '';
    $visible = $_POST['visible'] ?? '';

    echo "Form parameters<br>";
    echo "Menu name: " . $menu_name . "<br>";
    echo "Position: " . $position . "<br>";
    echo "Visible: " . $visible . "<br>";
}
?>


<?php $page_title = 'Edit Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<main id="edit-subject">
    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="edit-subject">
        <h1>Edit Subject</h1>
        <form class="new-form" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . h(u($id)); ?>" method="post">
            <div class="form-control">
                <label>Menu Name
                    <input type="text" name="menu_name" value="<?php echo $menu_name; ?>"/>
                </label>
            </div>
            <div class="form-control">
                <label>Position
                    <select name="position">
                        <option value="1">1</option>
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
                <button type="submit">Edit Subject</button>
            </div>
        </form>
    </div>
</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
