<?php
    require_once('../../../config.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());

    $app_id = required_param('appid', PARAM_INT);
    $status = required_param('status', PARAM_INT);

    if ($status !== 0 && $status !== 1 && $status !== -1) {
        return;
    }

    global $DB;

    $updateObj = new stdClass();
    $updateObj->id = $app_id;
    $updateObj->approved = $status;
    $DB->update_record('mentor_application', $updateObj);

    $userid = $DB->get_field_select('mentor_application', 'user_id', 'id=' . $app_id);
    $user = $DB->get_record('user', array('id' => $userid));

    $status_text = '';

    switch ($status) {
        case 0:
            $status_text = get_string('email_application_status_unreviewed', 'local_mentoring');
            break;
        case 1:
            $status_text = get_string('email_application_status_approved', 'local_mentoring');
            break;
        case -1:
            $status_text = get_string('email_application_status_denied', 'local_mentoring');
            break;
    }

    $email_text = get_string('email_application_status_text', 'local_mentoring');
    $email_text = str_replace('%STATUS%', $status_text, $email_text);

    email_to_user($user, get_string('email_from_name', 'local_mentoring'), 
        get_string('email_application_status_subject', 'local_mentoring'), $email_text, '', '', '', true);

    redirect(new moodle_url('/local/mentoring/manage_mentors.php', null));
?>
