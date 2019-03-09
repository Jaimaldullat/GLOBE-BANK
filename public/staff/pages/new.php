<?php require_once('../../../private/initialize.php'); ?>

<?php $page_title = 'Create Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main id="create-subject">
    <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

    <div class="create-page">
        <h1>Create Page</h1>
        <form class="new-form" action="<?php echo url_for('/staff/pages/create.php'); ?>" method="post">
            <div class="form-control">
                <label>Menu Name
                    <input type="text" name="menu_name" value=""/>
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
                <button type="submit">Create Page</button>
            </div>
        </form>
    </div>
</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
