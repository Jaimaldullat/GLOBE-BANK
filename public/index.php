<?php require_once '../private/initialize.php'; ?>
<?php
$preview = false;
if(isset($_GET['preview'])) {
     $preview = $_GET['preview'] == 'true' && is_logged_in() ? true : false;
}
$visible = !$preview;
if (isset($_GET['id'])) {
    $page_id = $_GET['id'];
    $page = find_page_by_id($page_id, ['visible'=>$visible]);
    if (!$page) {
        redirect_to(url_for('index.php'));
    }
    $subject_id = $page['subject_id'];
    $subject = find_subject_by_id($subject_id, ['visible'=>$visible]);

    if(!$subject){
        redirect_to(url_for('index.php'));
    }
} elseif(isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    $subject = find_subject_by_id($subject_id, ['visible'=>$visible]);
    if(!$subject){
        redirect_to(url_for('index.php'));
    }
    $page_set = find_pages_by_subject_id($subject_id, ['visible'=>$visible]);
    $page = mysqli_fetch_assoc($page_set);
    mysqli_free_result($page_set);
    if(!$page){
        redirect_to(url_for('index.php'));
    }else{
        $page_id = $page['id'];
    }

}else {
    // Nothing selected; show the homepage

}
?>
<?php $page_title = "Public"; ?>
<?php include SHARED_PATH . '/public_header.php'; ?>
<main id="public-index">
    <div id="left-menu">
        <?php include SHARED_PATH . '/public_navigation.php'; ?>
    </div>
    <div id="right-content">
        <?php
        if (isset($page)) {
            // Show the page from database
            $allowed_tags = '<div><img><ul><li><a><p><h1><h2><br><strong><em>';
            echo strip_tags($page['content'],$allowed_tags);
        } else {
            // Show static homepage
            // The homepage content could:
            // be static content (here or in a shared file)
            // show the first page from nav
            // be in the database but add code to hide in the nav
            include SHARED_PATH . '/static_homepage.php';
        }
        ?>
    </div>
</main>
<?php include SHARED_PATH . '/public_footer.php'; ?>
