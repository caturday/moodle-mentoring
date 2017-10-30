<?php
    require_once('../moodle/user/profile/lib.php');
    require_once('../moodle/config.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
 
    $PAGE->set_url('/local/mentoring/categories.php');
    $PAGE->set_title(get_string('page_name_categories', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_categories', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB;

    $cats = $DB->get_records('mentoring_category', null, 'category_name, category_desc');

    echo $OUTPUT->header();
?>
<?php foreach ($cats as $cat): ?>
<div style="font-weight: bold;"><?=$cat->category_name?></div>
<div style="margin-bottom: 10px;"><?=$cat->category_desc?></div>
<?php
    endforeach;
    echo $OUTPUT->footer();
?>
