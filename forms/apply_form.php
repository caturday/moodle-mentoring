<?php
    require_once('../../config.php');
    require_once("$CFG->libdir/formslib.php");
    require_once('lib.php');
 
    class apply_form extends moodleform {
        //Add elements to form
        public function definition() {
            global $CFG, $DB;
 
            $mform = $this->_form; // Don't forget the underscore! 
 
            $mform->addElement('textarea', 'q1', get_string('apply_lbl_q1', 'local_mentoring'), 'class="custom-question"');
            $mform->setType('q1', PARAM_TEXT);
            $mform->addRule('q1', get_string('form_err_generic_required', 'local_mentoring'), 'required');

            $mform->addElement('textarea', 'q2', get_string('apply_lbl_q2', 'local_mentoring'));
            $mform->setType('q2', PARAM_TEXT);
            $mform->addRule('q2', get_string('form_err_generic_required', 'local_mentoring'), 'required');

            $mform->addElement('textarea', 'q3', get_string('apply_lbl_q3', 'local_mentoring'));
            $mform->setType('q3', PARAM_TEXT);
            $mform->addRule('q3', get_string('form_err_generic_required', 'local_mentoring'), 'required');

            $mform->addElement('textarea', 'q4', get_string('apply_lbl_q4', 'local_mentoring'));
            $mform->setType('q4', PARAM_TEXT);
            $mform->addRule('q4', get_string('form_err_generic_required', 'local_mentoring'), 'required');

            add_profile_elements_to_form($mform);

            $mform->addElement('submit', 'submit', get_string('apply_lbl_submit', 'local_mentoring'));
        }

        //Custom validation should be added here
        function validation($data, $files) {
            return array();
        }
    }
?>
