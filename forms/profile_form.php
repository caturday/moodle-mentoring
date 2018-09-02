<?php
    require_once('../../config.php');
    require_once("$CFG->libdir/formslib.php");
    require_once('lib.php');
 
    class profile_form extends moodleform {
        //Add elements to form
        public function definition() {
            global $CFG, $DB;
 
            $mform = $this->_form; // Don't forget the underscore! 

            add_contact_info_elements_to_form($mform); 
            add_profile_elements_to_form($mform);

            $mform->addElement('submit', 'submit', get_string('profile_lbl_submit', 'local_mentoring'));
        }

        //Custom validation should be added here
        function validation($data, $files) {
            return array();
        }
    }
?>
