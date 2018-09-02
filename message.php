<?php
    require_once('../../config.php');
    require_once($CFG->dirroot . '/user/profile/lib.php');

    require_once('forms/message_form.php');

    require_login(null, true, null);
    $PAGE->set_context(context_system::instance());
 
    $PAGE->set_url('/local/mentoring/message.php');
    $PAGE->set_title(get_string('page_name_message', 'local_mentoring'));
    $PAGE->set_heading(get_string('page_name_message', 'local_mentoring'));
    $PAGE->set_pagelayout('standard');

    global $DB, $USER;
    $valid_types = array('m', 'a');

    $to = array_key_exists('to', $_GET) ? $_GET['to'] : null;
    $type = array_key_exists('type', $_GET) ? $_GET['type'] : null;
    $backto = array_key_exists('backto', $_GET) ? $_GET['backto'] : null;

    $to_user = $DB->get_record('user', array('id' => $to));

    $mform = new message_form();

    if ($fromform = $mform->get_data()) {
        $to_user = $DB->get_record('user', array('id' => $fromform->to_id));

        $message = new \core\message\message();
        $message->component = 'moodle';
        $message->name = 'instantmessage';
        $message->userfrom = $USER;
        $message->userto = $to_user;
        $message->subject = $fromform->subj_h;
        $message->fullmessage = $fromform->body;
        $message->notification = '0';

        $messageid = message_send($message);

        if (isset($fromform->backto)) {
            $return = new moodle_url($fromform->backto);
            echo "<meta http-equiv='refresh' content='1;url=" . $return . "'>";
        }

        echo $OUTPUT->header();
?>
<h3>Message Sent</h3>
<p>Your message has been sent to <?=$fromform->to_h?>.</p>
<?php
    } else if (is_numeric($to) && $to > 1 && in_array($type, $valid_types)) {
        echo $OUTPUT->header();
?>
<h3>Compose Message</h3>
<div class="message-form">
<?php
        $to_user = $DB->get_record('user', array('id' => $to));

        if (!$to_user) {
            echo "Not a valid user.";
        } else {
            $formdata = new stdClass();

            switch ($type) {
                case 'a':
                    $formdata->subj = get_string('email_message_application_subject', 'local_mentoring');
                    break;
                case 'm':
                    $formdata->subj = get_string('email_message_request_subject', 'local_mentoring');
                    break;
                case 't':
                    $formdata->subj = get_string('email_message_techsupport_subject', 'local_mentoring');
                    break;
                case 'h':
                    $formdata->subj = get_string('email_message_help_subject', 'local_mentoring');
                    break;
            }

            $formdata->subj_h = $formdata->subj;
            $formdata->to = $to_user->firstname . " " . $to_user->lastname;
            $formdata->to_h = $formdata->to;
            $formdata->to_id = $to;
            $formdata->from = $USER->firstname . " " . $USER->lastname;
            $formdata->from_id = $USER->id;

            if (isset($backto)) {
                $formdata->backto = $backto;
            }

            $mform->set_data($formdata);
            $mform->display();
        }
?>
</div>
<?php
    } else {
        // redirect, because the user has done something bad...
        echo "Invalid option.";
    }
    echo $OUTPUT->footer();
?>
