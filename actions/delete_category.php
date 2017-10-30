<?php
    require_once('../../moodle/config.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());

    $cat_to_delete = required_param('cat', PARAM_INT);

    global $DB;

    $DB->delete_records('mentoring_category', array('id' => $cat_to_delete));   

    redirect(new moodle_url('/local/mentoring/configure.php', null));
?>
