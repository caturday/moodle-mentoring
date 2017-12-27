<?php
    require_once('../../config.php');
    require_once("$CFG->libdir/formslib.php");
 
    class search_form extends moodleform {
        //Add elements to form
        public function definition() {
            global $CFG, $DB;
 
            $mform = $this->_form; // Don't forget the underscore! 
            $mform->disable_form_change_checker();
 
            $cats = $DB->get_records('mentoring_category', null, 'category_name, category_desc');

            $catarray = array();
            foreach ($cats as $cat) {
                $catarray[] = $mform->createElement('checkbox', 'search-cat-' . $cat->id, '', $cat->category_name);
            }

            $mform->addGroup($catarray, 'search-categories', get_string('search_lbl_cats', 'local_mentoring'), array(' '), false);

            $radioarray = array();
            $radioarray[] = $mform->createElement('radio', 'anyall', '', get_string('search_lbl_any', 'local_mentoring'), 0);
            $radioarray[] = $mform->createElement('radio', 'anyall', '', get_string('search_lbl_all', 'local_mentoring'), 1);
            $mform->addGroup($radioarray, 'any_or_all', get_string('search_lbl_anyall', 'local_mentoring'), array(' '), false);
            $mform->setDefault('anyall', 0);

            $mform->addElement('submit', 'submit', get_string('search_lbl_submit', 'local_mentoring'));
        }

        //Custom validation should be added here
        function validation($data, $files) {
            return array();
        }
    }
?>
