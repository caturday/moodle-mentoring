<?php
    require_once('../moodle/config.php');
    require_once("$CFG->libdir/formslib.php");
 
    class configuration_categories_form extends moodleform {
        //Add elements to form
        public function definition() {
            global $CFG;
 
            $mform = $this->_form; // Don't forget the underscore! 
 
            $mform->addElement('text', 'category', get_string('cfg_lbl_category', 'local_mentoring'));
            $mform->setType('category', PARAM_TEXT);
            $mform->addRule('category', get_string('cfg_err_category', 'local_mentoring'), 'required');

            $mform->addElement('text', 'cat_desc', get_string('cfg_lbl_catdesc', 'local_mentoring'));
            $mform->setType('cat_desc', PARAM_TEXT);

            $mform->addElement('submit', 'submit', get_string('cfg_lbl_categories_submit', 'local_mentoring'));
        }

        //Custom validation should be added here
        function validation($data, $files) {
            return array();
        }
    }
?>
