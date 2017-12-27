<?php
    require_once('../../config.php');
    require_once($CFG->libdir . '/accesslib.php');
    require_once('forms/apply_form.php');
 
    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
    
    $PAGE->set_url('/local/mentoring/apply.php');
    $PAGE->set_title(get_string('page_name_apply', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_apply', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB, $USER;

    $mform = new apply_form();

    // get the old application, if one exists.
    $old_app = $DB->get_record_sql('SELECT ma.id, ma.submission_date, ma.approved
        FROM {mentor_application} ma WHERE ma.user_id = ' . $USER->id);

    $single_pattern = "/^q\d$/";
    $multi_pattern = "/^q\d-\d+$/";

    // if we're working with a submitted form...
    if ($fromform = $mform->get_data()) {
        $keys = array_keys(get_object_vars($fromform));
        $single_keys = preg_grep($single_pattern, $keys);
        $multi_keys = preg_grep($multi_pattern, $keys);

        $app = new stdClass();
        $app->user_id = $USER->id;
        $app->submission_date = time();
        $app->approved = 0;

        // if we're working with an existing application, overwrite.
        if (isset($old_app->id)) {
            $app->id = $old_app->id;
            $DB->update_record('mentor_application', $app);

            $DB->delete_records_select('mentor_application_items', 'application_id = ?', array($app->id));
            $DB->delete_records_select('category_user_map', 'user_id=' . $USER->id . " AND is_mentor=1");
        } else {
            $app->id = $DB->insert_record('mentor_application', $app);
        }

        // either way, add the responses. if there were old ones, they've already been deleted.
        foreach($single_keys as $key) {
            $appq = new stdClass();
            $appq->question_number = str_replace('q', '', $key);
            $appq->question_response = $fromform->$key;
            $appq->application_id = $app->id;

            $DB->insert_record('mentor_application_items', $appq);
        }

        foreach($multi_keys as $key) {
            $catmap = new stdClass();
            $catmap->category_id = preg_replace("/^q\d-/", '', $key);
            $catmap->user_id = $USER->id;
            $catmap->is_mentor = 1;

            $DB->insert_record("category_user_map", $catmap);
        }

        $mentor_managers = get_users_by_capability(context_system::instance(), 'local/mentoring:manage_mentors');
        foreach ($mentor_managers as $mgr) {
            email_to_user($mgr, get_string('email_from_name', 'local_mentoring'),
                get_string('email_application_received_subject', 'local_mentoring'), 
                get_string('email_application_received_text', 'local_mentoring'), '', '', '', true);
        }

        email_to_user($USER, get_string('email_from_name', 'local_mentoring'),
            get_string('email_application_received_user_subject', 'local_mentoring'), 
            get_string('email_application_received_user_text', 'local_mentoring'), '', '', '', true);

        $content = "<div class=\"isa_success\">Your mentoring application was received! The mentoring administrator will review it and you'll receive a status update at a later date.
            <br />Thank you for your interest!</div>";
    } else {
        $old_app_note = '';

        if (isset($old_app->id)) {
            $form_data = array();

            $old_app_questions = $DB->get_records_sql('SELECT aq.id, aq.question_number, aq.question_response
                FROM {mentor_application_items} aq WHERE aq.application_id = ' . $old_app->id);

            // do some stuff with the question responses.
            foreach ($old_app_questions as $old_q) {
                $form_data['q' . $old_q->question_number] = $old_q->question_response;
            }

            $old_cats = $DB->get_records_sql('SELECT c.category_id FROM {category_user_map} c
                WHERE c.is_mentor = 1 AND c.user_id = ' . $USER->id);

            // this q5 business shouldn't be hard-coded like this...
            foreach ($old_cats as $old_cat) {
                $form_data['q5-' . $old_cat->category_id] = 'checked';
            }

            $mform = new apply_form();
            $mform->set_data($form_data);

            // then construct a note indicating a past submitted response.
            $old_app_note = "<div class=\"isa_info\"><div style=\"font-size: 1.5em; font-weight: bold; padding-bottom: 0.1em; \">Application Status: ";
            if ($old_app->approved == 1) { $old_app_note .= "Approved"; }
            else if ($old_app->approved == 0) { $old_app_note .= "Pending Review"; }
            else if ($old_app->approved == -1) { $old_app_note .= "Denied"; }
            else { $old_app_note .= "UNKNOWN"; }
            $old_app_note .= "</div><br />";

            $old_app_note .= "You submitted an application with the below information on " . 
                date('j F Y', $old_app->submission_date) . " at " . date('g:i:s a', $old_app->submission_date) . 
                ".<br />You can submit this form again at any time to update your answers.";

            $old_app_note .= "</div>";
        }

        $content = $old_app_note . "<div class=\"apply-form\">" . $mform->render() . "</div>";
    }

    echo $OUTPUT->header();
    echo $content;
    echo $OUTPUT->footer();
?>
