<?php
    require_once('../../config.php');
    require_once("$CFG->libdir/formslib.php");
 
    class help_form extends moodleform {
        //Add elements to form
        public function definition() {
            global $CFG, $DB;
 
            $mform = $this->_form; // Don't forget the underscore! 

            $options = array(
                'm' => get_string('help_lbl_mentoring', 'local_mentoring'),
                't' => get_string('help_lbl_technical', 'local_mentoring')
            );

            $mform->addElement('select', 'type', get_string('help_lbl_type', 'local_mentoring'), $options);

            // $mform->addElement('static', 'subj', get_string('help_lbl_subject', 'local_mentoring'));
            // $mform->addElement('hidden', 'type_h', null);
            $mform->addElement('textarea', 'body', get_string('help_lbl_message', 'local_mentoring'), 'rows="10"');
            $mform->addElement('submit', 'submit', get_string('help_lbl_submit', 'local_mentoring'));
        }

        //Custom validation should be added here
        function validation($data, $files) {
            return array();
        }
    }
?>
