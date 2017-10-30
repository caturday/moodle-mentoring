<?php
    require_once('../moodle/config.php');
    require_once("$CFG->libdir/formslib.php");
 
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

            $cats = $DB->get_records('mentoring_category', null, 'category_name, category_desc');

            $mform->addElement('static', 'category_question_text', get_string('apply_lbl_q5', 'local_mentoring'),
                get_string('form_lbl_all_that_apply', 'local_mentoring'));

            foreach ($cats as $cat) {
                $mform->addElement('checkbox', 'q5-' . $cat->id, '', $cat->category_name);
            }

            $mform->addElement('submit', 'submit', get_string('apply_lbl_submit', 'local_mentoring'));
        }

        //Custom validation should be added here
        function validation($data, $files) {
            return array();
        }
    }
?>
