<?php
    require_once('../../config.php');
    require_once("$CFG->libdir/formslib.php");
    require_once('lib.php');
    require_once('state_dropdown.php');
 
    class apply_form extends moodleform {
        //Add elements to form
        public function definition() {
            global $CFG, $DB;
 
            $mform = $this->_form; // Don't forget the underscore! 

            add_contact_info_elements_to_form($mform);

            // If you change this form, you MUST also modify add_mentor.php to include 
            // blank inserts for each of the form fields here. In other words, for each of
            // q1 to qN, you must also cause that script to insert a blank value for
            // each of question_number 1 to N.

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
