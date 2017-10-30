<?php
    require_once('../moodle/config.php');
    require_once('../moodle/lib/accesslib.php');
    require_once('forms/apply_form.php');
 
    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
    
    $PAGE->set_url('/local/mentoring/apply.php');
    $PAGE->set_title(get_string('page_name_apply', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_apply', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB, $USER;

    $mform = new apply_form();

    $single_pattern = "/^q\d$/";
    $multi_pattern = "/^q\d-\d+$/";

    if ($fromform = $mform->get_data()) {
        $keys = array_keys(get_object_vars($fromform));
        $single_keys = preg_grep($single_pattern, $keys);
        $multi_keys = preg_grep($multi_pattern, $keys);

        $app = new stdClass();
        $app->user_id = $USER->id;
        $app->submission_date = time();
        $app->approved = 0;
        $app_id = $DB->insert_record('mentor_application', $app);

        foreach($single_keys as $key) {
            $appq = new stdClass();
            $appq->question_number = str_replace('q', '', $key);
            $appq->question_response = $fromform->$key;
            $appq->application_id = $app_id;

            $DB->insert_record('mentor_application_items', $appq);
        }

        $DB->delete_records_select('category_user_map', 'user_id=' . $USER->id);
        foreach($multi_keys as $key) {
            $catmap = new stdClass();
            $catmap->category_id = preg_replace("/^q\d-/", '', $key);
            $catmap->user_id = $USER->id;
            $catmap->is_mentor = 1;

            $DB->insert_record("category_user_map", $catmap);
        }

        $mentor_managers = get_users_by_capability(context_system::instance(), 'local/mentoring:manage_mentors');
        error_log(count($mentor_managers));
        foreach ($mentor_managers as $mgr) {
            email_to_user($mgr, get_string('email_from_name', 'local_mentoring'),
                get_string('email_application_received_subject', 'local_mentoring'), 
                get_string('email_application_received_text', 'local_mentoring'), '', '', '', true);
        }

        email_to_user($USER, get_string('email_from_name', 'local_mentoring'),
            get_string('email_application_received_user_subject', 'local_mentoring'), 
            get_string('email_application_received_user_text', 'local_mentoring'), '', '', '', true);

        $mform->set_data(array());
    } else {
        $mform->set_data($mform->get_data());
    }

    echo $OUTPUT->header();
    echo "<div class=\"apply-form\">";
    $mform->display();
    echo "</div>";
    echo $OUTPUT->footer();
?>
