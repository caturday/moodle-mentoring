<?php
    require_once('../../config.php');
    require_once("$CFG->libdir/formslib.php");
    require_once('lib.php');
 
    class profile_form extends moodleform {
        //Add elements to form
        public function definition() {
            global $CFG, $DB;
 
            $mform = $this->_form; // Don't forget the underscore! 
 
            /*$cats = $DB->get_records('mentoring_category', null, 'category_name, category_desc');

            $introText = get_string('profile_lbl_cats', 'local_mentoring') . 
                "<br /><span style=\"font-weight: normal; font-style: italic;\">" . get_string('form_lbl_all_that_apply', 'local_mentoring') . "</span>";
            $mform->addElement('static', 'category_question_text', $introText);

            foreach ($cats as $cat) {
                $label = "<b>" . $cat->category_name . "</b><div style=\"padding-left: 40px; font-style: italic;\">" . $cat->category_desc . "</div>";
                $mform->addElement('checkbox', 'q5-' . $cat->id, '', $label);
            }*/

            add_profile_elements_to_form($mform);

            $mform->addElement('submit', 'submit', get_string('profile_lbl_submit', 'local_mentoring'));
        }

        //Custom validation should be added here
        function validation($data, $files) {
            return array();
        }
    }
?>
