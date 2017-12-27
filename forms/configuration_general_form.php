<?php
    require_once('../../config.php');
    require_once("$CFG->libdir/formslib.php");
 
    class configuration_general_form extends moodleform {
        //Add elements to form
        public function definition() {
            global $CFG;
 
            $mform = $this->_form; // Don't forget the underscore! 

            $mform->addElement('checkbox', 'application_status', get_string('cfg_lbl_application_status', 'local_mentoring'));

            $mform->addElement('submit', 'submit', get_string('cfg_lbl_general_submit', 'local_mentoring'));
        }

        //Custom validation should be added here
        function validation($data, $files) {
            return array();
        }
    }
?>
