<?php
    require_once('../../config.php');
    require_once("$CFG->libdir/formslib.php");
 
    class message_form extends moodleform {
        //Add elements to form
        public function definition() {
            global $CFG, $DB;
 
            $mform = $this->_form; // Don't forget the underscore! 

            $mform->addElement('hidden', 'to_h', null);
            $mform->addElement('hidden', 'to_id', null);
            $mform->addElement('hidden', 'from_h', null);
            $mform->addElement('hidden', 'from_id', null);
            $mform->addElement('hidden', 'subj_h', null);
            $mform->addElement('hidden', 'backto', null);

            $mform->addElement('static', 'to', get_string('message_lbl_recipient', 'local_mentoring'));
            $mform->addElement('static', 'from', get_string('message_lbl_sender', 'local_mentoring'));
            $mform->addElement('static', 'subj', get_string('message_lbl_subject', 'local_mentoring'));

            $mform->addElement('textarea', 'body', get_string('message_lbl_message', 'local_mentoring'));
            $mform->addElement('submit', 'submit', get_string('message_lbl_submit', 'local_mentoring'));
        }

        //Custom validation should be added here
        function validation($data, $files) {
            return array();
        }
    }
?>
