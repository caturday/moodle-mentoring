<?php
    require_once('../../config.php');
    require_once("$CFG->libdir/formslib.php");
    require_once("lib.php");
 
    class add_mentor_form extends moodleform {
        //Add elements to form
        public function definition() {
            global $CFG, $DB;
 
            $mform = $this->_form; // Don't forget the underscore! 

            $mform->addElement('static', 'choose_member_text', get_string('add_lbl_choose_member', 'local_mentoring'));

            $userselector = new non_mentor_user_selector('mentor_selector');
            $mform->addElement('html', $userselector->display(true));

            add_profile_elements_to_form($mform);

            $mform->addElement('submit', 'submit', get_string('add_lbl_submit', 'local_mentoring'));
        }

        //Custom validation should be added here
        function validation($data, $files) {
            return array();
        }
    }
?>
