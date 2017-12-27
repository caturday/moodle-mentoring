<?php
    require_once('../../config.php');
    require_once($CFG->dirroot . '/user/profile/lib.php');

    require_once('forms/help_form.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
 
    $PAGE->set_url('/local/mentoring/help.php');
    $PAGE->set_title(get_string('page_name_help', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_help', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB, $USER;
    // $valid_types = array('t', 'm');
    // $type = array_key_exists('type', $_GET) ? $_GET['type'] : 'm';

    $mform = new help_form();

    if ($fromform = $mform->get_data()) {
        $to_users = array();

        $from = $USER->firstname . " " . $USER->lastname;
        $email = $USER->email;
        $body = $fromform->body;
        $start = "The following support request was submitted in Masonic Mentoring:";

        $email_text = "${start}\nFrom: ${from}\nEmail: ${email}\n\n${body}";
        $email_html = "${start}<br />From: ${from}<br />Email: ${email}<br /><br />${body}";

        if ($fromform->type == 't') {
            $to_users = get_users_by_capability(context_system::instance(), 'local/mentoring:technical_help');
            $subj = get_string('help_subj_technical', 'local_mentoring');
        } else {
            $to_users = get_users_by_capability(context_system::instance(), 'local/mentoring:mentoring_help');
            $subj = get_string('help_subj_mentoring', 'local_mentoring');
        }

        foreach ($to_users as $to_user) {
            email_to_user($to_user, get_string('email_from_name', 'local_mentoring'),
                $subj . $from, $email_text, $email_html, '', '', true);
        }

        echo $OUTPUT->header();
?>
<h3>Message Sent</h3>
<p>Your message has been sent. The Online Masonic Mentoring team will reply to you soon!</p>
<?php
    } else {
        echo $OUTPUT->header();
?>
<h3>Contact the Online Masonic Mentoring Team for Help</h3>
<?php
        $formdata = new stdClass();

        $formdata->from_id = $USER->id;
        
        /*if ($type == 't') {
            $subj = get_string('help_lbl_technical', 'local_mentoring');
        } else {
            $subj = get_string('help_lbl_mentoring', 'local_mentoring');
        }

        $formdata->subj = $subj;
        $formdata->type_h = $type;*/

        $mform->set_data($formdata);
        $mform->display();
    }

    echo $OUTPUT->footer();
?>
