<?php
    require_once('../../config.php');
    require_once('./forms/add_mentor_form.php');
    require_once('./lib.php');
 
    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
    
    $PAGE->set_url('/local/mentoring/add_mentor.php');
    $PAGE->set_title(get_string('page_name_add_mentor', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_add_mentor', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB;

    $mform = new add_mentor_form();
    $non_mentor_selector = new non_mentor_user_selector('mentor_selector');
    $selected_users = $non_mentor_selector->get_selected_users();
    $selected_user = reset($selected_users);

    $multi_pattern = "/^q\d-\d+$/";

    echo $OUTPUT->header();

    if ($fromform = $mform->get_data()) {
        $keys = array_keys(get_object_vars($fromform));
        $multi_keys = preg_grep($multi_pattern, $keys);

        $app = new stdClass();
        $app->user_id = $selected_user->id;
        $app->submission_date = time();
        $app->approved = 1;
        $app->id = $DB->insert_record('mentor_application', $app);

        $DB->delete_records_select('category_user_map', 'user_id=' . $selected_user->id);
        foreach($multi_keys as $key) {
            $catmap = new stdClass();
            $catmap->category_id = preg_replace("/^q\d-/", '', $key);
            $catmap->user_id = $selected_user->id;
            $catmap->is_mentor = 1;

            $DB->insert_record("category_user_map", $catmap);
        }

        $mform->set_data(array());

        echo "<div class=\"isa_success\">Mentor added successfully!</div>";
    }

    $mentor_form = new add_mentor_form();
    $mentor_form->set_data(array());
    $mentor_form->display();

    echo $OUTPUT->footer();
?>
