<?php
    require_once('../../config.php');
    require_once('forms/configuration_categories_form.php');
 
    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
    
    $PAGE->set_url('/local/mentoring/configure.php');
    $PAGE->set_title(get_string('page_name_config', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_config', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB;

    $mform = new configuration_categories_form();
    $added_category = false;

    if ($fromform = $mform->get_data()) {
        $newcat = new stdClass();
        $newcat->category_name = $fromform->category;
        $newcat->category_desc = $fromform->cat_desc;

        $DB->insert_record('mentoring_category', $newcat);
        $added_category = true;

        $mform->set_data(array());
    } else {
        $mform->set_data($mform->get_data());
    }

    echo $OUTPUT->header();
?>
<h2>Available Categories</h2>
<?php
    $cats = $DB->get_records('mentoring_category', null, 'category_name, category_desc');
    $table = new html_table();
    $table->head = array('Category', 'Description', 'Actions');
    $table->data = array();

    $del_url = new moodle_url("/local/mentoring/actions/delete_category.php");

    foreach ($cats as $cat) {
        $this_del_url = "<a href=\"${del_url}?cat=" . $cat->id . "\">delete</a>";
        array_push($table->data, array($cat->category_name, $cat->category_desc, $this_del_url));
    }

    echo html_writer::table($table);

    $mform->display();

    echo $OUTPUT->footer();
?>
