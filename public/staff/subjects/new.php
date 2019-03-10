<?php require_once('../../../private/initialize.php'); ?>

<?php
$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set) + 1;
mysqli_free_result($subject_set);

$subject = [];
$subject['position'] = $subject_count;
?>

<?php $page_title = 'Create Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main id="create-subject">
    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="create-subject">
        <h1>Create Subject</h1>
        <form class="new-form" action="<?php echo url_for('/staff/subjects/create.php'); ?>" method="post">
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
