<?php
    require_once('../../config.php');
    require_once($CFG->libdir . '/accesslib.php');
    require_once('forms/profile_form.php');
 
    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
    
    $PAGE->set_url('/local/mentoring/profile.php');
    $PAGE->set_title(get_string('page_name_profile', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_profile', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB, $USER;

    // this needs to be initially populated with whatever the user's profile already is.

    $mform = new profile_form();

    $single_pattern = "/^q\d$/";
    $multi_pattern = "/^q\d-\d+$/";

    if ($fromform = $mform->get_data()) {
        $keys = array_keys(get_object_vars($fromform));
        $multi_keys = preg_grep($multi_pattern, $keys);

        $DB->delete_records_select('category_user_map', 'user_id=' . $USER->id);
        foreach($multi_keys as $key) {
            $catmap = new stdClass();
            $catmap->category_id = preg_replace("/^q\d-/", '', $key);
            $catmap->user_id = $USER->id;
            $catmap->is_mentor = 1;

            $DB->insert_record("category_user_map", $catmap);
        }

        $mform->set_data(array());
    } else {
        $old_cats = $DB->get_records_sql('SELECT c.category_id FROM {category_user_map} c
            WHERE c.is_mentor = 1 AND c.user_id = ' . $USER->id);

        // this q5 business shouldn't be hard-coded like this...
        foreach ($old_cats as $old_cat) {
            $form_data['q5-' . $old_cat->category_id] = 'checked';
        }

        $mform = new profile_form();
        $mform->set_data($form_data);
    }

    echo $OUTPUT->header();
    echo "<div class=\"profile-form\">";
    $mform->display();
    echo "</div>";
    echo $OUTPUT->footer();
?>
